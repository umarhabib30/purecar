<?php
namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Services\CarFacetService;
class CarController extends Controller
{
    public function search_car(Request $request, CarFacetService $facetService)
    {
        $validated = $request->validate([
            'make' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'variant' => 'nullable|string|max:255',
            'year_from' => 'nullable|integer|min:1900|max:2026',
            'price_from' => 'nullable|numeric|min:0',
            'seller_type' => 'nullable|string|max:255',
            'transmission_type' => 'nullable|string|max:255',
            'year_to' => 'nullable|integer|min:1900|max:2026',
            'price_to' => 'nullable|numeric|min:0',
            'miles' => 'nullable|numeric|min:0',
            'body_type' => 'nullable|string|max:255',
            'engine_size' => 'nullable|string|max:255',
            'doors' => 'nullable|integer|min:0',
            'colors' => 'nullable|string',
            'keyword' => 'nullable|string|max:255',
            'sort' => 'nullable|string|in:most-recent,low-high,high-low,mileage,mileage-low,newest,oldest',
        ]);
        // echo $request->colors;die();
        $query = $facetService->buildStatusQuery();
        
        if (!empty($validated['make'])) {
            $query->where('make', 'like', '%' . $validated['make'] . '%');
        }
        // if (!empty($validated['model'])) {
        //     $query->where('model', 'like', '%' . $validated['model'] . '%');
        // }
        if (!empty($validated['model'])) {
            $query->where('model', $validated['model']);
        }
        if (!empty($validated['variant'])) {
            $query->where('variant', 'like', '%' . $validated['variant'] . '%');
        }
        if (!empty($validated['fuel_type'])) {
            $query->where('fuel_type', 'like', '%' . $validated['fuel_type'] . '%');
        }
        if (!empty($validated['seller_type'])) {
            $query->where('seller_type', 'like', '%' . $validated['seller_type'] . '%');
        }
        if (!empty($validated['transmission_type'])) {
            $query->where('transmission_type', 'like', '%' . $validated['transmission_type'] . '%');
        }
        if (!empty($validated['miles'])) {
            $query->where('miles', '<=', $validated['miles']);
        }
        if (!empty($validated['body_type'])) {
            $query->where('body_type', 'like', '%' . $validated['body_type'] . '%');
        }
        if (!empty($validated['engine_size'])) {
            $query->where('engine_size', '=', $validated['engine_size']);
        }
        if (!empty($validated['doors'])) {
            $query->where('doors', '=', $validated['doors']);
        }
        if (!empty($validated['colors'])) {
            $query->where('advert_colour', 'like', '%' . $validated['colors'] . '%');
        }
        if (!empty($validated['year_from'])) {
            $query->where('year', '>=', $validated['year_from']);
        }
        if (!empty($validated['year_to'])) {
            $query->where('year', '<=', $validated['year_to']);
        }
        if (!empty($validated['price_from']) || !empty($validated['price_to'])) {
            $query->where('price', '>', 0);
        }
        if (!empty($validated['price_from'])) {
            $query->where('price', '>=', $validated['price_from']);
        }
        if (!empty($validated['price_to'])) {
            $query->where('price', '<=', $validated['price_to']);
        }if (!empty($validated['keyword'])) {
            $keyword = $validated['keyword'];
            $query->where(function ($q) use ($keyword) {
                $q->where('make', 'like', '%' . $keyword . '%')
                  ->orWhere('model', 'like', '%' . $keyword . '%')
                  ->orWhere('variant', 'like', '%' . $keyword . '%')
                  ->orWhere('fuel_type', 'like', '%' . $keyword . '%')
                  ->orWhere('body_type', 'like', '%' . $keyword . '%')
                  ->orWhere('colors', 'like', '%' . $keyword . '%');
            });
        }
        if (!empty($validated['sort'])) {
            switch ($validated['sort']) {
                case 'low-high':
                    $query->orderBy('price', 'asc')->orderBy('car_id', 'asc');
                    break;
                case 'high-low':
                    $query->orderBy('price', 'desc')->orderBy('car_id', 'asc');
                    break;
                case 'mileage':
                    $query->orderBy('miles', 'asc')->orderBy('car_id', 'asc');
                    break;
                case 'mileage-low':
                    $query->orderBy('miles', 'desc')->orderBy('car_id', 'asc');
                    break;
                case 'newest':
                    $query->orderBy('year', 'desc')->orderBy('car_id', 'asc');
                    break;
                case 'oldest':
                    $query->orderBy('year', 'asc')->orderBy('car_id', 'asc');
                    break;
                case 'most-recent':
                default:
                    $query->orderBy('created_at', 'desc')->orderBy('car_id', 'asc');
                    break;
            }
        } else {
            $query->orderBy('car_id', 'desc');
        }
        $totalCount = (clone $query)->count();
        $perPage = 20;
        $cars = $query->paginate($perPage)->appends($validated);
        if ($request->ajax()) {
            $html = view('partials.car_list', compact('cars'))->render();
            return response()->json([
                'html' => $html,
                'next_page_url' => $cars->nextPageUrl(),
                'current_page' => $cars->currentPage(),
                'last_page' => $cars->lastPage(),
            ]);
        }
      
        $count = $cars->count();
        $makeselected=$request->input('make');
        $modelselected=$request->input('model');
        $variantselected=$request->input('variant');
        $fuel_typeselected=$request->input('fuel_type');
        $milesselected=$request->input('miles');
        $seller_typeselected=$request->input('seller_type');
        $gear_boxselected=$request->input('gear_box');
        $body_typeselected=$request->input('body_type');
        
        $doorsselected=$request->input('doors');
        $engine_sizeselected=$request->input('engine_size');
        $colorsselected=$request->input('colors');
        $pricefromselected=$request->input('price_from');
        $pricetoselected=$request->input('price_to');
        $yeartoselected=$request->input('year');
        $yearfromselected=$request->input('year_from');
        $currentYear = (int) date('Y');
        $maxYear = max($currentYear, 2026);
        $year_ranges = range(2000, $maxYear);
                    
        $year_counts = [];
        foreach ($year_ranges as $year) {
            $year_counts[$year] = Car::where('year', $year)
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->count();
        }

        $year_counts_to = [];
        $running_year_total = 0;
        foreach ($year_ranges as $year) {
            $running_year_total += (int) ($year_counts[$year] ?? 0);
            $year_counts_to[$year] = $running_year_total;
        }

        $year_counts_from = $year_counts_to;

        // Price breakpoints: 1k-15k in 1k steps, then 20k-120k in 5k steps
        $pricePoints = array_merge(
            range(1000, 15000, 1000),
            range(20000, 120000, 5000)
        );

        $basePriceQuery = (clone $facetService->buildStatusQuery())->whereNotNull('price')->where('price', '>', 0);

        $price_counts = [];
        foreach ($pricePoints as $p) {
            $cTo = (clone $basePriceQuery)->where('price', '<=', $p)->count();
            $cFrom = (clone $basePriceQuery)->where('price', '>=', $p)->count();
            $price_counts[] = [
                'min' => $p,
                'max' => $p,
                'count' => $cTo,
                'count_to' => $cTo,
                'count_from' => $cFrom,
            ];
        }
        $miles_ranges = [
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
        $miles_counts = [];
        foreach ($miles_ranges as $range) {
            $count = Car::whereBetween('miles', [$range['min'], $range['max']])->count();
            $miles_counts[$range['max']] = $count; // This will create the counts keyed by the maximum value
        }
       
        $search_field = [
            'make' => Car::select('make', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->where('make', '!=', 'N/A') 
                ->where('make', '!=', '')
                ->where('make', '!=', null)
                ->groupBy('make')
                ->orderBy('make')
                ->get(),
                
            'model' => Car::select('model', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->where('model', '!=', 'N/A') 
                ->where('model', '!=', '')
                ->where('model', '!=', null)
                ->groupBy('model')
                ->orderBy('model')
                ->get(),
                
            'variant' => Car::select('variant', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->where('variant', '!=', 'N/A') 
                ->where('variant', '!=', '')
                ->where('variant', '!=', null)
                ->groupBy('variant')
                ->orderBy('variant')
                ->get(),
            'fuel_type' => Car::select('fuel_type', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->where('fuel_type', '!=', 'N/A') 
                ->where('fuel_type', '!=', '')
                ->where('fuel_type', '!=', null)
                ->groupBy('fuel_type')
                ->orderBy('fuel_type')
                ->get(),
            'year' => Car::select('year', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->groupBy('year')
                ->orderBy('year')
                ->get(),
            'price' => Car::select('price', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->groupBy('price')
                ->orderBy('price')
                ->get(),
            'seller_type' => Car::select('seller_type', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->groupBy('seller_type')
                ->orderBy('seller_type')
                ->get()
                ->map(function($item) {
                    $item->seller_type = match($item->seller_type) {
                        'private_seller' => 'Private',
                        'car_dealer' => 'Dealer',
                        default => $item->seller_type,
                    };
                    return $item;
                }),
            'gear_box' => Car::select('gear_box', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->where('gear_box', '!=', 'N/A') 
                ->where('gear_box', '!=', '')
                ->where('gear_box', '!=', null)
                ->groupBy('gear_box')
                ->orderBy('gear_box')
                ->get(),
            'miles' => Car::select('miles', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->groupBy('miles')
                ->orderBy('miles')
                ->get(),
            'body_type' => Car::select('body_type', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->where('body_type', '!=', 'N/A') 
                ->where('body_type', '!=', '')
                ->where('body_type', '!=', null)
                ->groupBy('body_type')
                ->orderBy('body_type')
                ->get(),
            'engine_size' => Car::select('engine_size', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->where('engine_size', '!=', 'N/A') 
                ->where('engine_size', '!=', '')
                ->where('engine_size', '!=', null)
                ->groupBy('engine_size')
                ->orderBy('engine_size')
                ->get(),
            'doors' => Car::select('doors', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->where('doors', '!=', 'N/A')
                ->where('doors', '!=', '')
                ->where('doors', '!=', null)
                ->groupBy('doors')
                ->orderBy('doors')
                ->get(),
            'colors' => Car::select('advert_colour as colors', DB::raw('COUNT(*) as count'))
                ->whereHas('advert', function ($query) {
                    $query->where('status', 'active');
                })
                ->where('advert_colour', '!=', 'N/A')
                ->where('advert_colour', '!=', '')
                ->where('advert_colour', '!=', null)
                ->groupBy('advert_colour')
                ->orderBy('advert_colour')
                ->get(),
            ];
            // DB::enableQueryLog();
            // $color_query = Car::select('colors,advert_colour', DB::raw('COUNT(*) as count'))
            // ->whereHas('advert', function ($query) {
            //     $query->where('status', 'active');
            // })
            // ->where('colors', '!=', 'N/A')
            // ->where('colors', '!=', '')
            // ->where('colors', '!=', null)
            // ->groupBy('colors')
            // ->orderBy('colors')
            // ->get();
            // dd($count);
        // Initial facets for the shared search form partial (cached).
        $initialFacets = Cache::remember('facets.initial.v3', 600, function () use ($facetService) {
            $statusQuery = $facetService->buildStatusQuery();
            return $facetService->buildFacets($statusQuery, new Request([]), $facetService->allowedFilters());
        });
        $totalResults = (clone $facetService->buildStatusQuery())->count();
        return view('forsale_page', compact(
            'cars', 'count', 'search_field', 'makeselected', 'fuel_typeselected',
            'colorsselected', 'engine_sizeselected', 'doorsselected', 'body_typeselected',
            'gear_boxselected', 'seller_typeselected', 'milesselected', 'modelselected',
            'variantselected', 'year_ranges', 'year_counts', 'price_counts',
            'pricefromselected', 'pricetoselected', 'yeartoselected', 'yearfromselected','totalCount',
            'year_counts_to', 'year_counts_from',
            'initialFacets', 'totalResults'
        ));
    }
 
 
public function getFilteredFields(Request $request)
{
  
    $baseQuery = Car::query()
        ->whereHas('advert', function ($query) {
            $query->where('status', 'active');
        });
    
    $filters = [
        'make', 'model', 'variant', 'fuel_type', 'body_type', 
        'engine_size', 'doors', 'colors', 'seller_type', 'gear_box'
    ];
    
    // Create a function that builds a query with all filters EXCEPT the excluded ones
    $createFilteredQuery = function ($field, $excludeFilters = []) use ($request, $filters) {
        $query = Car::query()
            ->whereHas('advert', function ($q) {
                $q->where('status', 'active');
            });
        
        // Apply all filters except the excluded ones
        foreach ($filters as $filter) {
            if (!in_array($filter, $excludeFilters) && $request->has($filter) && $request->get($filter) !== '') {
                $query->where($filter, $request->get($filter));
            }
        }
        
        // Apply miles filter (excluding if in excludeFilters)
        if (!in_array('miles', $excludeFilters) && $request->has('miles') && is_numeric($request->get('miles'))) {
            $query->where('miles', '<=', $request->get('miles'));
        }
        
        // Apply year filters (excluding if 'year' is in excludeFilters)
        // Note: getFilteredFields uses yearFrom/yearTo (camelCase) while getFilteredFieldssale uses yearfrom/yearto
        if (!in_array('year', $excludeFilters)) {
            if ($request->has('yearFrom') && $request->get('yearFrom') !== '') {
                $query->where('year', '>=', $request->get('yearFrom'));
            }
            if ($request->has('yearTo') && $request->get('yearTo') !== '') {
                $query->where('year', '<=', $request->get('yearTo'));
            }
        }
        
        // Apply price filters (excluding if 'price' is in excludeFilters)
        if (!in_array('price', $excludeFilters)) {
            if (($request->has('pricefrom') && $request->get('pricefrom') !== '') ||
                ($request->has('priceto') && $request->get('priceto') !== '')) {
                $query->where('price', '>', 0);
            }
            if ($request->has('pricefrom') && $request->get('pricefrom') !== '') {
                $query->where('price', '>=', $request->get('pricefrom'));
            }
            if ($request->has('priceto') && $request->get('priceto') !== '') {
                $query->where('price', '<=', $request->get('priceto'));
            }
        }
        
        return $query->select($field)
            ->selectRaw('COUNT(*) as count')
            ->whereNotNull($field)
            ->groupBy($field);
    };
    
    $filtered_fields = [
        'make' => $createFilteredQuery('make', ['make'])
        ->where('make', '!=', 'N/A')
        ->get()
        ->map(fn($item) => ['make' => $item->make, 'count' => $item->count]),
            
        'fuel_type' => $createFilteredQuery('fuel_type', ['fuel_type'])
        ->where('fuel_type', '!=', 'N/A')
        ->get()
        ->map(fn($item) => ['fuel_type' => $item->fuel_type, 'count' => $item->count]),
            
        'body_type' => $createFilteredQuery('body_type', ['body_type']) 
        ->where('body_type', '!=', 'N/A')
          ->where('body_type', '!=', 'UNLISTED')
        ->get()
        ->map(fn($item) => ['body_type' => $item->body_type, 'count' => $item->count]),
            
       'engine_size' => $createFilteredQuery('engine_size', ['engine_size'])
        ->where('engine_size', '!=', 'N/AL')
        ->where('engine_size', '!=', '0.0L')
        ->get()
        ->map(fn($item) => ['engine_size' => $item->engine_size, 'count' => $item->count]),
            
        'doors' => $createFilteredQuery('doors', ['doors'])
        ->where('doors', '!=', 0)
        ->get()
            ->map(fn($item) => ['doors' => $item->doors, 'count' => $item->count]),
            
        'colors' => $createFilteredQuery('colors', ['colors'])
        ->where('colors', '!=', 'N/A')
          ->where('colors', '!=', '')
            ->where('colors', '!=', null)
        ->get()
            ->map(fn($item) => ['colors' => $item->colors, 'count' => $item->count]),
            
        'seller_type' => $createFilteredQuery('seller_type', ['seller_type'])->get()
    ->map(fn($item) => [
        'seller_type' => $item->seller_type === 'car_dealer' ? 'Dealer' : 'Private',
        'original_seller_type' => $item->seller_type,
        'count' => $item->count
    ]),
            
        'gear_box' => $createFilteredQuery('gear_box', ['gear_box'])
        ->where('gear_box', '!=', 'N/A')
        ->get()
            ->map(fn($item) => ['gear_box' => $item->gear_box, 'count' => $item->count]),
            
        'miles' => $createFilteredQuery('miles', ['miles'])
            ->orderBy('miles', 'asc')
            ->get()
            ->map(fn($item) => ['miles' => $item->miles, 'count' => $item->count]),
            
        'year' => $createFilteredQuery('year', ['year'])
            ->orderBy('year', 'desc')
            ->get()
            ->map(fn($item) => [
                'yearfrom' => $item->year,
                'yearto' => $item->year,
                'count' => $item->count
            ]),
            
        'price' => $createFilteredQuery('price', ['price'])
            ->where('price', '>', 0)
            ->orderBy('price', 'asc')
            ->get()
            ->map(fn($item) => [
                'pricefrom' => $item->price,
                'priceto' => $item->price,
                'count' => $item->count
            ])
    ];
    
    return response()->json($filtered_fields);
}
public function getFilteredFieldssale(Request $request)
{
  
  
    $baseQuery = Car::query()
        ->whereHas('advert', function ($query) {
            $query->where('status', 'active');
        });
    $filters = [
        'make', 'model', 'variant', 'fuel_type', 'body_type', 
        'engine_size', 'doors', 'colors', 'seller_type', 'gear_box'
    ];
    
    foreach ($filters as $filter) {
        if ($request->has($filter) && $request->get($filter) !== '') {
            // Handle colors filter - use advert_colour column
            if ($filter === 'colors') {
                $baseQuery->where('advert_colour', 'like', '%' . $request->get($filter) . '%');
            } else {
                $baseQuery->where($filter, $request->get($filter));
            }
        }
    }
    
    if ($request->has('miles') && is_numeric($request->get('miles'))) {
        $baseQuery->where('miles', '<=', $request->get('miles'));
    }
    
    if ($request->has('yearfrom') && $request->get('yearfrom') !== '') {
        $baseQuery->where('year', '>=', $request->get('yearfrom'));
    }
    
    if ($request->has('yearto') && $request->get('yearto') !== '') {
        $baseQuery->where('year', '<=', $request->get('yearto'));
    }
    
    
    if ($request->has('pricefrom') && $request->get('pricefrom') !== '') {
        $baseQuery->where('price', '>', 0);
        $baseQuery->where('price', '>=', $request->get('pricefrom'));
    }
    
    if ($request->has('priceto') && $request->get('priceto') !== '') {
        $baseQuery->where('price', '>', 0);
        $baseQuery->where('price', '<=', $request->get('priceto'));
    }
    
    $createFilteredQuery = function ($field, $excludeFilters = []) use ($baseQuery, $request, $filters) {
        $query = Car::query()
            ->whereHas('advert', function ($q) {
                $q->where('status', 'active');
            });
        
      
        foreach ($filters as $filter) {
            if (!in_array($filter, $excludeFilters) && $request->has($filter) && $request->get($filter) !== '') {
                // Handle colors filter - use advert_colour column
                if ($filter === 'colors') {
                    $query->where('advert_colour', 'like', '%' . $request->get($filter) . '%');
                } else {
                    $query->where($filter, $request->get($filter));
                }
            }
        }
        
        
        if (!in_array('miles', $excludeFilters) && $request->has('miles') && is_numeric($request->get('miles'))) {
            $query->where('miles', '<=', $request->get('miles'));
        }
        
        if (!in_array('year', $excludeFilters)) {
            if ($request->has('yearfrom') && $request->get('yearfrom') !== '') {
                $query->where('year', '>=', $request->get('yearfrom'));
            }
            if ($request->has('yearto') && $request->get('yearto') !== '') {
                $query->where('year', '<=', $request->get('yearto'));
            }
        }
        
  
        if (!in_array('price', $excludeFilters)) {
            if (($request->has('pricefrom') && $request->get('pricefrom') !== '') ||
                ($request->has('priceto') && $request->get('priceto') !== '')) {
                $query->where('price', '>', 0);
            }
            if ($request->has('pricefrom') && $request->get('pricefrom') !== '') {
                $query->where('price', '>=', $request->get('pricefrom'));
            }
            if ($request->has('priceto') && $request->get('priceto') !== '') {
                $query->where('price', '<=', $request->get('priceto'));
            }
        }
        
        return $query->select($field)
            ->selectRaw('COUNT(*) as count')
            ->whereNotNull($field)
            ->groupBy($field);
    };
    
 
    $filtered_fields = [
        'make' => $createFilteredQuery('make', ['make'])
            ->where('make', '!=', 'N/A')
            ->get()
            ->map(fn($item) => ['make' => $item->make, 'count' => $item->count]),
            
        'fuel_type' => $createFilteredQuery('fuel_type', ['fuel_type'])
            ->where('fuel_type', '!=', 'N/A')
            ->get()
            ->map(fn($item) => ['fuel_type' => $item->fuel_type, 'count' => $item->count]),
            
        'body_type' => $createFilteredQuery('body_type', ['body_type'])
            ->where('body_type', '!=', 'N/A')
            ->where('body_type', '!=', 'UNLISTED')
            ->get()
            ->map(fn($item) => ['body_type' => $item->body_type, 'count' => $item->count]),
            
        'engine_size' => $createFilteredQuery('engine_size', ['engine_size'])
            ->where('engine_size', '!=', 'N/A')
            ->where('engine_size', '!=', '0.0L')
            ->get()
            ->map(fn($item) => ['engine_size' => $item->engine_size, 'count' => $item->count]),
            
        'doors' => $createFilteredQuery('doors', ['doors'])
            ->where('doors', '!=', 0)
            ->get()
            ->map(fn($item) => ['doors' => $item->doors, 'count' => $item->count]),
            
        'colors' => (function() use ($createFilteredQuery, $request, $filters) {
            $query = Car::query()
                ->whereHas('advert', function ($q) {
                    $q->where('status', 'active');
                });
            
            // Apply all filters except colors
            foreach ($filters as $filter) {
                if ($filter !== 'colors' && $request->has($filter) && $request->get($filter) !== '') {
                    $query->where($filter, $request->get($filter));
                }
            }
            
            // Apply miles filter
            if ($request->has('miles') && is_numeric($request->get('miles'))) {
                $query->where('miles', '<=', $request->get('miles'));
            }
            
            // Apply year filters
            if ($request->has('yearfrom') && $request->get('yearfrom') !== '') {
                $query->where('year', '>=', $request->get('yearfrom'));
            }
            if ($request->has('yearto') && $request->get('yearto') !== '') {
                $query->where('year', '<=', $request->get('yearto'));
            }
            
            // Apply price filters
            if ($request->has('pricefrom') && $request->get('pricefrom') !== '') {
                $query->where('price', '>', 0);
                $query->where('price', '>=', $request->get('pricefrom'));
            }
            if ($request->has('priceto') && $request->get('priceto') !== '') {
                $query->where('price', '>', 0);
                $query->where('price', '<=', $request->get('priceto'));
            }
            
            return $query->selectRaw('advert_colour as colors')
                ->selectRaw('COUNT(*) as count')
                ->where('advert_colour', '!=', 'N/A')
                ->where('advert_colour', '!=', '')
                ->whereNotNull('advert_colour')
                ->groupBy('advert_colour')
                ->orderBy('advert_colour')
                ->get()
                ->map(fn($item) => ['colors' => $item->colors, 'count' => $item->count]);
        })(),
            
        'seller_type' => $createFilteredQuery('seller_type', ['seller_type'])
            ->get()
            ->map(fn($item) => [
                'seller_type' => $item->seller_type === 'car_dealer' ? 'Dealer' : 'Private',
                'original_seller_type' => $item->seller_type,
                'count' => $item->count
            ]),
            
        'gear_box' => $createFilteredQuery('gear_box', ['gear_box'])
            ->where('gear_box', '!=', 'N/A')
            ->get()
            ->map(fn($item) => ['gear_box' => $item->gear_box, 'count' => $item->count]),
            
        'miles' => $createFilteredQuery('miles', ['miles'])
            ->orderBy('miles', 'asc')
            ->get()
            ->map(fn($item) => ['miles' => $item->miles, 'count' => $item->count]),
            
        'year' => $createFilteredQuery('year', ['year'])
            ->orderBy('year', 'desc')
            ->get()
            ->map(fn($item) => [
                'yearfrom' => $item->year,
                'yearto' => $item->year,
                'count' => $item->count
            ]),
            
        'price' => $createFilteredQuery('price', ['price'])
            ->where('price', '>', 0)
            ->orderBy('price', 'asc')
            ->get()
            ->map(fn($item) => [
                'pricefrom' => $item->price,
                'priceto' => $item->price,
                'count' => $item->count
            ])
    ];
    
    return response()->json($filtered_fields);
}
public function countCars(Request $request)
{
    $facetService = app(CarFacetService::class);
    $validated = $request->validate([
        'make' => 'nullable|string|max:255',
        'fuel_type' => 'nullable|string|max:255',
        'model' => 'nullable|string|max:255',
        'variant' => 'nullable|string|max:255',
        'year_from' => 'nullable|integer|min:1900|max:2026',
        'price_from' => 'nullable|numeric|min:0',
        'seller_type' => 'nullable|string|max:255',
        'transmission_type' => 'nullable|string|max:255',
        'year_to' => 'nullable|integer|min:1900|max:2026',
        'price_to' => 'nullable|numeric|min:0',
        'miles' => 'nullable|numeric|min:0',
        'body_type' => 'nullable|string|max:255',
        'engine_size' => 'nullable|string|max:255',
        'doors' => 'nullable|integer|min:0',
        'colors' => 'nullable|string',
        'keyword' => 'nullable|string|max:255',
    ]);
    
    $query = $facetService->buildStatusQuery();
    if (!empty($validated['make'])) {
        $query->where('make', 'like', '%' . $validated['make'] . '%');
    }
  
    // if (!empty($validated['model'])) {
    //     $query->where('model', 'like', '%' . $validated['model'] . '%');
    // }
    if (!empty($validated['model'])) {
    $query->where('model', $validated['model']);
}
    if (!empty($validated['variant'])) {
        $query->where('variant', 'like', '%' . $validated['variant'] . '%');
    }
    if (!empty($validated['fuel_type'])) {
        $query->where('fuel_type', 'like', '%' . $validated['fuel_type'] . '%');
    }
    if (!empty($validated['seller_type'])) {
        $query->where('seller_type', 'like', '%' . $validated['seller_type'] . '%');
    }
    if (!empty($validated['transmission_type'])) {
        $query->where('transmission_type', 'like', '%' . $validated['transmission_type'] . '%');
    }
    if (!empty($validated['miles'])) {
        $query->where('miles', '<=', $validated['miles']);
    }
    if (!empty($validated['body_type'])) {
        $query->where('body_type', 'like', '%' . $validated['body_type'] . '%');
    }
    if (!empty($validated['engine_size'])) {
        $query->where('engine_size', '=', $validated['engine_size']);
    }
    if (!empty($validated['doors'])) {
        $query->where('doors', '=', $validated['doors']);
    }
    if (!empty($validated['colors'])) {
        $query->where('colors', 'like', '%' . $validated['colors'] . '%');
    }
    if (!empty($validated['year_from'])) {
        $query->where('year', '>=', $validated['year_from']);
    }
    if (!empty($validated['year_to'])) {
        $query->where('year', '<=', $validated['year_to']);
    }
    if (!empty($validated['price_from']) || !empty($validated['price_to'])) {
        $query->where('price', '>', 0);
    }
    if (!empty($validated['price_from'])) {
        $query->where('price', '>=', $validated['price_from']);
    }
    if (!empty($validated['price_to'])) {
        $query->where('price', '<=', $validated['price_to']);
    }if (!empty($validated['keyword'])) {
        $keyword = $validated['keyword'];
        $query->where(function ($q) use ($keyword) {
            $q->where('make', 'like', '%' . $keyword . '%')
              ->orWhere('model', 'like', '%' . $keyword . '%')
              ->orWhere('variant', 'like', '%' . $keyword . '%')
       
              ->orWhere('fuel_type', 'like', '%' . $keyword . '%')
              ->orWhere('body_type', 'like', '%' . $keyword . '%')
              ->orWhere('colors', 'like', '%' . $keyword . '%');
        });
    }
    
    $count = $query->count();
    
    return response()->json(['count' => $count]);
}
public function sortCars(Request $request)
    {
        $validated = $request->validate([
            'make' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'variant' => 'nullable|string|max:255',
            'year_from' => 'nullable|integer|min:1900|max:2026',
            'price_from' => 'nullable|numeric|min:0',
            'seller_type' => 'nullable|string|max:255',
            'transmission_type' => 'nullable|string|max:255',
            'year_to' => 'nullable|integer|min:1900|max:2026',
            'price_to' => 'nullable|numeric|min:0',
            'miles' => 'nullable|numeric|min:0',
            'body_type' => 'nullable|string|max:255',
            'engine_size' => 'nullable|string|max:255',
            'doors' => 'nullable|integer|min:0',
            'colors' => 'nullable|string',
            'keyword' => 'nullable|string|max:255',
            'sort' => 'nullable|string|in:most-recent,low-high,high-low,mileage,mileage-low,newest,oldest',
        ]);
        $query = Car::whereHas('advert', function ($query) {
            $query->where('status', 'active');
        });
      
        if (!empty($validated['make'])) {
            $query->where('make', 'like', '%' . $validated['make'] . '%');
        }
        if (!empty($validated['model'])) {
            $query->where('model', 'like', '%' . $validated['model'] . '%');
        }
        if (!empty($validated['variant'])) {
            $query->where('variant', 'like', '%' . $validated['variant'] . '%');
        }
        if (!empty($validated['fuel_type'])) {
            $query->where('fuel_type', 'like', '%' . $validated['fuel_type'] . '%');
        }
        if (!empty($validated['seller_type'])) {
            $query->where('seller_type', 'like', '%' . $validated['seller_type'] . '%');
        }
        if (!empty($validated['transmission_type'])) {
            $query->where('transmission_type', 'like', '%' . $validated['transmission_type'] . '%');
        }
        if (!empty($validated['miles'])) {
            $query->where('miles', '<=', $validated['miles']);
        }
        if (!empty($validated['body_type'])) {
            $query->where('body_type', 'like', '%' . $validated['body_type'] . '%');
        }
        if (!empty($validated['engine_size'])) {
            $query->where('engine_size', '=', $validated['engine_size']);
        }
        if (!empty($validated['doors'])) {
            $query->where('doors', '=', $validated['doors']);
        }
        if (!empty($validated['colors'])) {
            $query->where('colors', 'like', '%' . $validated['colors'] . '%');
        }
       
        if (!empty($validated['year_from'])) {
            $query->where('year', '>=', $validated['year_from']);
        }
        if (!empty($validated['year_to'])) {
            $query->where('year', '<=', $validated['year_to']);
        }
        if (!empty($validated['price_from']) || !empty($validated['price_to'])) {
            $query->where('price', '>', 0);
        }
        if (!empty($validated['price_from'])) {
            $query->where('price', '>=', $validated['price_from']);
        }
        if (!empty($validated['price_to'])) {
            $query->where('price', '<=', $validated['price_to']);
        }
        if (!empty($validated['keyword'])) {
            $keyword = $validated['keyword'];
            $query->where(function ($q) use ($keyword) {
                $q->where('make', 'like', '%' . $keyword . '%')
                  ->orWhere('model', 'like', '%' . $keyword . '%')
                  ->orWhere('variant', 'like', '%' . $keyword . '%')
                  ->orWhere('fuel_type', 'like', '%' . $keyword . '%')
                  ->orWhere('body_type', 'like', '%' . $keyword . '%')
                  ->orWhere('colors', 'like', '%' . $keyword . '%');
            });
        }
     
        $sort = $validated['sort'] ?? 'most-recent';
        switch ($sort) {
            case 'low-high':
                $query->orderBy('price', 'asc');
                break;
            case 'high-low':
                $query->orderBy('price', 'desc');
                break;
            case 'mileage':
                $query->orderBy('miles', 'asc');
                break;
            case 'mileage-low':
                $query->orderBy('miles', 'desc');
                break;
            case 'newest':
                $query->orderBy('year', 'desc');
                break;
            case 'oldest':
                $query->orderBy('year', 'asc');
                break;
            case 'most-recent':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
       
        $perPage = 20;
        $cars = $query->paginate($perPage)->appends($validated);
      
        return response()->json([
            'html' => view('partials.car_list', compact('cars'))->render(),
            'total' => $cars->total(),
            'next_page_url' => $cars->nextPageUrl(),
            'current_page' => $cars->currentPage(),
            'last_page' => $cars->lastPage(),
        ]);
    }
}
