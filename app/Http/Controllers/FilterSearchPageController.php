<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CarFacetService;

class FilterSearchPageController extends Controller
{
    public function filter(Request $request)
    {
        $facetService = app(CarFacetService::class);

        // 1) Base query (active adverts only + valid make)
        $statusQuery = $facetService->buildStatusQuery();

        // Only allow known filter keys (prevents accidental/unsafe column filtering)
        $allowedFilters = $facetService->allowedFilters();

        // Build fully-filtered query (used for results list)
        $baseQuery = (clone $statusQuery);
        $facetService->applyRequestFilters($baseQuery, $request, $allowedFilters, []);

        // 2) Build facets (exclude-self) for dropdowns
        $facets = $facetService->buildFacets($statusQuery, $request, $allowedFilters);

        // 3) Cars list (apply sort from request; does not change filters)
        $sortQuery = clone $baseQuery;
        $sort = $request->get('sort');
        if ($sort && in_array($sort, ['most-recent', 'low-high', 'high-low', 'mileage', 'mileage-low', 'newest', 'oldest'], true)) {
            switch ($sort) {
                case 'low-high':
                    $sortQuery->orderBy('price', 'asc');
                    break;
                case 'high-low':
                    $sortQuery->orderBy('price', 'desc');
                    break;
                case 'mileage':
                    $sortQuery->orderBy('miles', 'asc');
                    break;
                case 'mileage-low':
                    $sortQuery->orderBy('miles', 'desc');
                    break;
                case 'newest':
                    $sortQuery->orderBy('year', 'desc');
                    break;
                case 'oldest':
                    $sortQuery->orderBy('year', 'asc');
                    break;
                case 'most-recent':
                default:
                    $sortQuery->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $sortQuery->orderByDesc('car_id');
        }
        $cars = $sortQuery
            ->paginate(20)
            ->appends($request->except('_token')) // ✅ keeps filters in pagination links
            ->withPath(route('forsale_filter')); // ✅ ensure pagination links go to HTML page

        // ✅ IMPORTANT: pass paginator object, NOT ->items()
        $carsHtml = view('partials.car_list', ['cars' => $cars])->render();

        $queryParams = $request->except('_token', 'page');
        $currentPage = $cars->currentPage();
        $lastPage = $cars->lastPage();
        $nextPageUrl = $currentPage < $lastPage
            ? route('forsale_filter', array_merge($queryParams, ['page' => $currentPage + 1]))
            : null;
        $prevPageUrl = $currentPage > 1
            ? route('forsale_filter', array_merge($queryParams, ['page' => $currentPage - 1]))
            : null;
       
        return response()->json([
            'filters_applied' => $request->except(['_token']),
            'total' => $cars->total(),
            'cars' => $cars->items(), // still returning array if you need it on frontend
            'cars_html' => $carsHtml,
            'next_page_url' => $nextPageUrl,
            'prev_page_url' => $prevPageUrl,
            'current_page' => $currentPage,
            'last_page' => $lastPage,
            'facets' => $facets,
        ]);
    }
}
