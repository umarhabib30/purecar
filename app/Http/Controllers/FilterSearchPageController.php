<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
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

}
