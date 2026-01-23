<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarFacetService
{
    /**
     * Filters we accept from request (used both for filtering and for facet exclusion).
     */
    public function allowedFilters(): array
    {
        return [
            // equals fields
            'make',
            'model',
            'variant',
            'body_type',
            'engine_size',
            'fuel_type',
            'gear_box',
            'doors',
            'colors',
            'seller_type',

            // range fields (handled below)
            'miles',
            'price_from',
            'price_to',
            'year_from',
            'year_to',
        ];
    }

    /**
     * Facets that are simple equals counts.
     */
    public function facetEqualsFields(): array
    {
        return [
            'make',
            'model',
            'variant',
            'body_type',
            'engine_size',
            'fuel_type',
            'gear_box',
            'doors',
            'colors',
            'seller_type',
        ];
    }

    /**
     * Base query for all car searching/facets (active adverts + valid make).
     */
    public function buildStatusQuery(): Builder
    {
        $q = Car::query();
        $q->whereHas('advert', function ($qq) {
            $qq->where('status', 'active');
        });

        // Exclude cars without a valid make from all results/facets.
        $q->whereNotNull('make')
            ->where('make', '!=', '')
            ->where(function ($qq) {
                $this->excludeNaPlaceholders($qq, 'make');
            });

        return $q;
    }

    /**
     * Build facets using "exclude-self" logic (facet counts are computed with all current
     * filters EXCEPT the facet itself).
     */
    public function buildFacets(Builder $statusQuery, Request $request, array $allowedFilters): array
    {
        $facets = [];

        // Equals facets
        foreach ($this->facetEqualsFields() as $field) {
            $q = (clone $statusQuery);
            $this->applyRequestFilters($q, $request, $allowedFilters, [$field]);

            $rows = $q->whereNotNull($field)
                ->where($field, '!=', '')
                ->where(function ($qq) use ($field) {
                    $this->excludeNaPlaceholders($qq, $field);
                })
                ->selectRaw("$field as k, COUNT(*) as c")
                ->groupBy($field)
                ->orderByDesc('c')
                ->get();

            $facets[$field] = $rows->pluck('c', 'k')->toArray();
        }

        // Year facet (covers year_from/year_to)
        $currentYear = (int) date('Y');
        $maxYear = max($currentYear, 2026);
        $yearRanges = range(2000, $maxYear);

        $yearQuery = (clone $statusQuery);
        $this->applyRequestFilters($yearQuery, $request, $allowedFilters, ['year_from', 'year_to']);

        $yearRows = $yearQuery
            ->select('year', DB::raw('COUNT(*) as c'))
            ->whereNotNull('year')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $yearCounts = [];
        foreach ($yearRows as $row) {
            $y = (int) $row->year;
            if ($y > 0) {
                $yearCounts[(string) $y] = (int) $row->c;
            }
        }

        $facets['year'] = collect($yearRanges)->mapWithKeys(function ($year) use ($yearCounts) {
            $k = (string) $year;
            return [$k => (int) ($yearCounts[$k] ?? 0)];
        })->toArray();

        // Price buckets (covers price_from/price_to)
        $priceRanges = [
            ['min' => 500, 'max' => 1000],
            ['min' => 1000, 'max' => 1500],
            ['min' => 1500, 'max' => 2000],
            ['min' => 2000, 'max' => 2500],
            ['min' => 2500, 'max' => 3000],
            ['min' => 3000, 'max' => 3500],
            ['min' => 3500, 'max' => 4000],
            ['min' => 4000, 'max' => 4500],
            ['min' => 4500, 'max' => 5000],
            ['min' => 5000, 'max' => 5500],
            ['min' => 5500, 'max' => 6000],
            ['min' => 6000, 'max' => 6500],
            ['min' => 6500, 'max' => 7000],
            ['min' => 7000, 'max' => 7500],
            ['min' => 7500, 'max' => 8000],
            ['min' => 8000, 'max' => 8500],
            ['min' => 8500, 'max' => 9000],
            ['min' => 9000, 'max' => 9500],
            ['min' => 10000, 'max' => 20000],
            ['min' => 20000, 'max' => 30000],
            ['min' => 30000, 'max' => 40000],
            ['min' => 40000, 'max' => 50000],
            ['min' => 50000, 'max' => 60000],
            ['min' => 60000, 'max' => 70000],
            ['min' => 70000, 'max' => 80000],
            ['min' => 80000, 'max' => 90000],
            ['min' => 90000, 'max' => 100000],
            ['min' => 100000, 'max' => 200000],
        ];

        $priceQuery = (clone $statusQuery);
        $this->applyRequestFilters($priceQuery, $request, $allowedFilters, ['price_from', 'price_to']);

        $priceBucketCase = 'CASE ';
        foreach ($priceRanges as $r) {
            $min = (int) $r['min'];
            $max = (int) $r['max'];
            $label = $min . '-' . $max;
            $priceBucketCase .= "WHEN price BETWEEN $min AND $max THEN '$label' ";
        }
        $priceBucketCase .= 'ELSE NULL END';

        $priceBucketCounts = (clone $priceQuery)
            ->whereNotNull('price')
            ->selectRaw("$priceBucketCase as bucket, COUNT(*) as c")
            ->groupBy('bucket')
            ->get()
            ->pluck('c', 'bucket')
            ->toArray();

        $facets['price'] = collect($priceRanges)->map(function ($range) use ($priceBucketCounts) {
            $min = (int) $range['min'];
            $max = (int) $range['max'];
            $label = $min . '-' . $max;
            return [
                'min' => $min,
                'max' => $max,
                'count' => (int) ($priceBucketCounts[$label] ?? 0),
            ];
        })->values()->toArray();

        // Miles buckets (covers miles)
        $milesRanges = [
            ['min' => 0, 'max' => 10000],
            ['min' => 10000, 'max' => 20000],
            ['min' => 20000, 'max' => 30000],
            ['min' => 30000, 'max' => 40000],
            ['min' => 40000, 'max' => 50000],
            ['min' => 50000, 'max' => 60000],
            ['min' => 60000, 'max' => 70000],
            ['min' => 70000, 'max' => 80000],
            ['min' => 80000, 'max' => 90000],
            ['min' => 90000, 'max' => 100000],
        ];

        $milesQuery = (clone $statusQuery);
        $this->applyRequestFilters($milesQuery, $request, $allowedFilters, ['miles']);

        $milesBucketCase = 'CASE ';
        foreach ($milesRanges as $r) {
            $min = (int) $r['min'];
            $max = (int) $r['max'];
            $label = $min . '-' . $max;
            $milesBucketCase .= "WHEN miles BETWEEN $min AND $max THEN '$label' ";
        }
        $milesBucketCase .= 'ELSE NULL END';

        $milesBucketCounts = (clone $milesQuery)
            ->whereNotNull('miles')
            ->selectRaw("$milesBucketCase as bucket, COUNT(*) as c")
            ->groupBy('bucket')
            ->get()
            ->pluck('c', 'bucket')
            ->toArray();

        $facets['miles'] = collect($milesRanges)->map(function ($range) use ($milesBucketCounts) {
            $min = (int) $range['min'];
            $max = (int) $range['max'];
            $label = $min . '-' . $max;
            return [
                'min' => $min,
                'max' => $max,
                'count' => (int) ($milesBucketCounts[$label] ?? 0),
            ];
        })->values()->toArray();

        return $facets;
    }

    public function applyRequestFilters(Builder $query, Request $request, array $allowedFilters, array $excludeKeys): void
    {
        $exclude = array_flip($excludeKeys);

        foreach ($request->except(['_token']) as $key => $val) {
            if (!in_array($key, $allowedFilters, true)) {
                continue;
            }
            if (isset($exclude[$key])) {
                continue;
            }
            if (!$request->filled($key)) {
                continue;
            }

            // Range filters
            if ($key === 'price_from') { $query->where('price', '>=', (float)$val); continue; }
            if ($key === 'price_to')   { $query->where('price', '<=', (float)$val); continue; }
            if ($key === 'year_from')  { $query->where('year', '>=', (int)$val); continue; }
            if ($key === 'year_to')    { $query->where('year', '<=', (int)$val); continue; }
            if ($key === 'miles')      { $query->where('miles', '<=', (int)$val); continue; }

            // Colors can be array or scalar (string column version)
            if ($key === 'colors') {
                $colors = is_array($val) ? $val : [$val];
                $colors = array_map(fn($c) => $this->normalizeIfNeeded('colors', $c), $colors);
                $query->whereIn('colors', $colors);
                continue;
            }

            // Default exact-match filters (normalized)
            $value = $this->normalizeIfNeeded($key, $val);
            $query->where($key, $value);
        }
    }

    private function normalizeIfNeeded(string $category, $value)
    {
        if ($value === null) {
            return null;
        }
        if (is_string($value)) {
            return trim($value);
        }
        return $value;
    }

    /**
     * Exclude placeholder values like "N/A", "N/A L", "NA", etc for a string column.
     */
    private function excludeNaPlaceholders(Builder $query, string $field): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'pgsql') {
            $query->where($field, 'NOT ILIKE', 'n/a%')
                ->where($field, 'NOT ILIKE', 'na%');
            return;
        }

        // MySQL/MariaDB/SQLite: LIKE is typically case-insensitive with default collations
        $query->where($field, 'NOT LIKE', 'N/A%')
            ->where($field, 'NOT LIKE', 'NA%');
    }
}

