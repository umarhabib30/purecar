<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\DB;

class FilterSearchPageController extends Controller
{
    public function filter(Request $request)
    {
        // 1) Build base query with AND filters
        $baseQuery = Car::query();
        $baseQuery->whereHas('advert', function ($q) {
            $q->where('status', 'active');
        });

        // Only allow known filter keys (prevents accidental/unsafe column filtering)
        $allowedFilters = [
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
    
        // Apply filters dynamically (only if filled)
        foreach ($request->except(['_token']) as $key => $val) {
            if (!in_array($key, $allowedFilters, true)) {
                continue;
            }
            if (!$request->filled($key)) continue;
    
            // Range filters
            if ($key === 'price_from') { $baseQuery->where('price', '>=', (float)$val); continue; }
            if ($key === 'price_to')   { $baseQuery->where('price', '<=', (float)$val); continue; }
            if ($key === 'year_from')  { $baseQuery->where('year', '>=', (int)$val); continue; }
            if ($key === 'year_to')    { $baseQuery->where('year', '<=', (int)$val); continue; }
            if ($key === 'miles')      { $baseQuery->where('miles', '<=', (int)$val); continue; }
    
            // Colors can be array or scalar (string column version)
            if ($key === 'colors') {
                $colors = is_array($val) ? $val : [$val];
                $colors = array_map(fn($c) => $this->normalizeIfNeeded('colors', $c), $colors);
                $baseQuery->whereIn('colors', $colors);
                continue;
            }
    
            // Default exact-match filters (normalized)
            $value = $this->normalizeIfNeeded($key, $val);
            $baseQuery->where($key, $value);
        }

        // 2) Build facets off the filtered result set (ALWAYS return all facets)
        $facets = [];

        $facetEqualsFields = [
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

        foreach ($facetEqualsFields as $field) {
            $q = (clone $baseQuery);

            $rows = $q->whereNotNull($field)
                ->where($field, '!=', '')
                ->where($field, '!=', 'N/A')
                ->selectRaw("$field as k, COUNT(*) as c")
                ->groupBy($field)
                ->orderByDesc('c')
                ->get();

            $facets[$field] = $rows->pluck('c', 'k')->toArray();
        }

        // Year counts (covers year_from/year_to facets)
        $yearRanges = range(2000, 2024);
        $yearRows = (clone $baseQuery)
            ->select('year', DB::raw('COUNT(*) as c'))
            ->whereNotNull('year')
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        // Normalize year keys so "2020", 2020, "2020.0", "2020 " all map to "2020"
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

        // Price buckets (covers price_from/price_to facets)
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

        $facets['price'] = collect($priceRanges)->map(function ($range) use ($baseQuery) {
            $count = (clone $baseQuery)
                ->whereBetween('price', [$range['min'], $range['max']])
                ->count();

            return [
                'min' => (int) $range['min'],
                'max' => (int) $range['max'],
                'count' => (int) $count,
            ];
        })->values()->toArray();

        // Miles buckets (covers miles facet)
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

        $facets['miles'] = collect($milesRanges)->map(function ($range) use ($baseQuery) {
            $count = (clone $baseQuery)
                ->whereBetween('miles', [$range['min'], $range['max']])
                ->count();

            return [
                'min' => (int) $range['min'],
                'max' => (int) $range['max'],
                'count' => (int) $count,
            ];
        })->values()->toArray();
    
        // 4) Cars list (optional)
        $cars = (clone $baseQuery)->orderByDesc('car_id')->paginate(20);

        // Render HTML for for-sale page grid updates (re-uses existing Blade card markup)
        $carsHtml = view('partials.car_list', ['cars' => $cars->items()])->render();
    
        return response()->json([
            'filters_applied' => $request->except(['_token']),
            'total' => $cars->total(),
            'cars' => $cars->items(),
            'cars_html' => $carsHtml,
            'next_page_url' => $cars->nextPageUrl(),
            'facets' => $facets,
        ]);
    }

    private function normalizeIfNeeded(string $category, $value)
    {
        if ($value === null) {
            return null;
        }

        // No external normalization model exists in this project.
        // Keep normalization lightweight and safe: trim strings, preserve original value otherwise.
        if (is_string($value)) {
            return trim($value);
        }

        return $value;
    }
    
}
