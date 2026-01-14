<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SeoController extends Controller
{
   public function index(Request $request)
    {
        $routeParams = $request->route()->parameters();
        $routeName = $request->route()->getName();
       
        $allParams = array_merge($request->all(), $routeParams);
        $validated = $this->validateParameters($allParams);
        $query = Car::select('cars.*', 'users.location as user_location')
            ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active');

        $this->applyFilters($query, $validated);

        $sql = $query->toSql();
        $bindings = $query->getBindings();
      
        $totalCount = (clone $query)->count();
        if ($totalCount === 0) {
            if ($request->ajax()) {
                return response()->json([
                    'redirect' => route('search_car', $validated),
                    'html' => '',
                    'next_page_url' => null,
                    'current_page' => 1,
                    'last_page' => 1,
                ]);
            }
            return redirect()->route('search_car', $validated);
        }
        $perPage = 20;
        $cars = $query->paginate($perPage)->appends($validated);
       
        $seoData = $this->generateSeoData($validated, $totalCount);
      
        $search_field = $this->getFilterOptions();
        $random_ads = Car::leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->where('adverts.status', 'active')
            ->inRandomOrder()
            ->limit(3)
            ->get();
        $more_cars_data = Car::whereHas('advert', function ($query) {
            $query->where('status', 'active');
        })->inRandomOrder()->take(4)->get();
        $selectedFilters = $this->getSelectedFilters($validated);

        if ($request->ajax()) {
            $html = view('partials.car_list', compact('cars'))->render();
            return response()->json([
                'html' => $html,
                'next_page_url' => $cars->nextPageUrl(),
                'current_page' => $cars->currentPage(),
                'last_page' => $cars->lastPage(),
            ]);
        }

        $data = Car::whereHas('advert', function ($query) {
            $query->where('status', 'active');
        })->inRandomOrder()->take(4)->get();

        return view('seo.index', compact(
            'cars',
            'totalCount',
            'search_field',
            'random_ads',
            'more_cars_data',
            'data'
        ) + $seoData + $selectedFilters);
    }

    private function isSeoRoute($routeName)
    {
        $seoRoutes = [
            'seo.make.model.year.location',
            'seo.make.model.price.under',
            'seo.fuel.location',
            'seo.transmission.location',
            'seo.body.location',
            'seo.make.price.under',
            'seo.make.model.location',
            'seo.make.location',
       
             
        ];
        
        return in_array($routeName, $seoRoutes);
    }

    private function validateParameters(array $params)
    {
        
        $routeName = request()->route()->getName();
        
    
        $params = $this->convertSluggedParams($params);

        switch($routeName) {
            case 'seo.fuel.location':
                if(isset($params['fuel_type'])) {
                    $params['fuel_type'] = $this->convertFuelType($params['fuel_type']);
                }
                break;
            case 'seo.transmission.location':
                if(isset($params['transmission_type'])) {
                    $params['transmission_type'] = $this->convertTransmissionType($params['transmission_type']);
                }
                break;
            case 'seo.body.location':
                if(isset($params['body_type'])) {
                    $params['body_type'] = $this->convertBodyType($params['body_type']);
                }
                break;
            case 'seo.make.price.under':
            case 'seo.make.model.price.under':
                if(isset($params['price'])) {
                    $params['price_to'] = $params['price'];
                    unset($params['price']);
                }
                break;
            case 'seo.make.model.year.location':
               
                break;
        }

        $rules = [
            'make' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'transmission_type' => 'nullable|string|max:255',
            'body_type' => 'nullable|string|max:255',
            'price_to' => 'nullable|numeric|min:0',
            'year' => 'nullable|integer|min:1900|max:2025',
            'keyword' => 'nullable|string|max:255',
            'sort' => 'nullable|string|in:most-recent,low-high,high-low,mileage,mileage-low,newest,oldest',
        ];

        $validator = validator($params, $rules);
        if ($validator->fails()) {
            abort(404, 'Invalid parameters');
        }
        
        $validatedData = $validator->validated();

        return $validatedData;
    }

    private function convertSluggedParams(array $params)
    {
        foreach (['make', 'model', 'location', 'fuel_type', 'transmission_type', 'body_type'] as $key) {
            if (isset($params[$key])) {
                $params[$key] = $this->unSlugify($params[$key]);
            }
        }
        
        return $params;
    }

    private function unSlugify($string)
{
   
    return str_replace(['-', 'plus'], [' ', '+'], $string);
}

    private function convertFuelType($fuelType)
    {
        $fuelTypeMap = [
            'petrol' => 'petrol',
            'diesel' => 'diesel',
            'electric' => 'electric',
            'hybrid' => 'hybrid',
            'lpg' => 'lpg',
            'gasoline' => 'gasoline'
        ];
        
        return $fuelTypeMap[strtolower($fuelType)] ?? $fuelType;
    }

    private function convertTransmissionType($transmissionType)
    {
        $transmissionMap = [
            'automatic' => 'automatic',
            'manual' => 'manual',
            'auto' => 'automatic'
        ];
        
        return $transmissionMap[strtolower($transmissionType)] ?? $transmissionType;
    }

    private function convertBodyType($bodyType)
    {
        $bodyTypeMap = [
            'convertible' => 'convertible',
            'coupe' => 'coupe',
            'estate' => 'estate',
            'hatchback' => 'hatchback',
            'mpv' => 'mpv',
            'saloon' => 'saloon',
            'suv' => 'suv',
            'sedan' => 'sedan'
        ];
        
        return $bodyTypeMap[strtolower($bodyType)] ?? $bodyType;
    }

    private function applyFilters($query, $validated)
    {
        if (!empty($validated['make'])) {
            $query->whereRaw('LOWER(cars.make) LIKE ?', ['%' . strtolower($validated['make']) . '%']);
        }
        if (!empty($validated['model'])) {
            $query->whereRaw('LOWER(cars.model) LIKE ?', ['%' . strtolower($validated['model']) . '%']);
        }
        // if (!empty($validated['location'])) {
        //     $query->whereRaw('LOWER(users.location) LIKE ?', ['%' . strtolower($validated['location']) . '%']);
        // }
        if (!empty($validated['location'])) {
        $query->where('users.location', '=', $validated['location']);
        $validLocations = DB::table('users')
            ->select('location')
            ->distinct()
            ->pluck('location')
            ->toArray();
        if (!in_array($validated['location'], $validLocations)) {
          
        }
    }
        if (!empty($validated['fuel_type'])) {
            $query->whereRaw('LOWER(cars.fuel_type) = ?', [strtolower($validated['fuel_type'])]);
        }
        if (!empty($validated['transmission_type'])) {
            $query->whereRaw('LOWER(cars.transmission_type) = ?', [strtolower($validated['transmission_type'])]);
        }
        if (!empty($validated['body_type'])) {
            $query->whereRaw('LOWER(cars.body_type) LIKE ?', ['%' . strtolower($validated['body_type']) . '%']);
        }
        if (isset($validated['price_to']) && $validated['price_to'] !== null) {
            $query->where('cars.price', '<=', $validated['price_to']);
        }
        if (isset($validated['year']) && $validated['year'] !== null) {
            $query->where('cars.year', '=', $validated['year']);
        }
        if (!empty($validated['keyword'])) {
            $keyword = $validated['keyword'];
            $query->where(function ($q) use ($keyword) {
                $q->where('cars.make', 'like', '%' . $keyword . '%')
                  ->orWhere('cars.model', 'like', '%' . $keyword . '%')
                  ->orWhere('cars.fuel_type', 'like', '%' . $keyword . '%')
                  ->orWhere('cars.body_type', 'like', '%' . $keyword . '%')
                  ->orWhere('users.location', 'like', '%' . $keyword . '%');
            });
        }
        
    }

    private function applySorting($query, $sort)
    {
        $sort = $sort ?? 'most-recent';
        switch ($sort) {
            case 'low-high':
                $query->orderBy('cars.price', 'asc');
                break;
            case 'high-low':
                $query->orderBy('cars.price', 'desc');
                break;
            case 'mileage':
                $query->orderBy('cars.miles', 'asc');
                break;
            case 'mileage-low':
                $query->orderBy('cars.miles', 'desc');
                break;
            case 'newest':
                $query->orderBy('cars.year', 'desc');
                break;
            case 'oldest':
                $query->orderBy('cars.year', 'asc');
                break;
            case 'most-recent':
            default:
                $query->orderBy('cars.created_at', 'desc');
                break;
        }
    }

    private function generateSeoData(array $validated, int $totalCount)
    {
        $make = ucfirst($validated['make'] ?? '');
        $model = ucfirst($validated['model'] ?? '');
        $location = ucfirst($validated['location'] ?? 'Northern Ireland');
        $fuelType = ucfirst($validated['fuel_type'] ?? '');
        $transmission = ucfirst($validated['transmission_type'] ?? '');
        $bodyType = ucfirst($validated['body_type'] ?? '');
        $priceTo = $validated['price_to'] ?? null;
        $year = $validated['year'] ?? null;

        $titleParts = [];
        $descriptionParts = [];
        $h1Parts = [];
        $canonicalUrlParts = ['/cars-for-sale'];

        if ($make && $model && $year && $location) {
            $h1Parts[] = "$year $make $model Cars";
            $titleParts[] = "$year $make $model";
            $descriptionParts[] = "$year $make $model";
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $make));
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $model));
            $canonicalUrlParts[] = "year-$year";
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $location));
        } elseif ($make && $model && $location) {
            $h1Parts[] = "$make $model Cars";
            $titleParts[] = "$make $model";
            $descriptionParts[] = "$make $model";
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $make));
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $model));
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $location));
        } elseif ($make && $priceTo) {
            $h1Parts[] = "$make Cars under £" . number_format($priceTo);
            $titleParts[] = "$make under £" . number_format($priceTo);
            $descriptionParts[] = "$make under £" . number_format($priceTo);
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $make));
            $canonicalUrlParts[] = "under-$priceTo";
        }elseif ($make && $model && $priceTo) {
            $h1Parts[] = "$make  $model Cars under £" . number_format($priceTo);
            $titleParts[] = "$make under £" . number_format($priceTo);
            $descriptionParts[] = "$make under £" . number_format($priceTo);
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $make));
            $canonicalUrlParts[] = "under-$priceTo";
        }
        elseif ($fuelType && $location) {
            $h1Parts[] = "$fuelType Cars";
            $titleParts[] = "$fuelType Cars";
            $descriptionParts[] = "$fuelType cars";
            $canonicalUrlParts[] = 'fuel';
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $fuelType));
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $location));
        } elseif ($transmission && $location) {
            $h1Parts[] = "$transmission Cars";
            $titleParts[] = "$transmission Cars";
            $descriptionParts[] = "$transmission cars";
            $canonicalUrlParts[] = 'transmission';
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $transmission));
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $location));
        } elseif ($bodyType && $location) {
            $h1Parts[] = "$bodyType's";
            $titleParts[] = "$bodyType's";
            $descriptionParts[] = "$bodyType's";
            $canonicalUrlParts[] = 'body';
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $bodyType));
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $location));
        } elseif ($make && $location) {
            $h1Parts[] = "$make Cars";
            $titleParts[] = "$make Cars";
            $descriptionParts[] = "$make cars";
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $make));
            $canonicalUrlParts[] = strtolower(str_replace(' ', '-', $location));
        }
      

        if (empty($h1Parts)) {
            $h1Parts[] = 'Cars';
            $titleParts[] = 'Cars';
            $descriptionParts[] = 'cars';
        } else {
            $h1Parts[] = 'for Sale';
            $titleParts[] = 'for Sale';
            $descriptionParts[] = 'for sale';
        }

        $page_title = implode(' ', array_filter($titleParts)) . ' in ' . $location . ' | Pure Car';
        $meta_description = "Find " . implode(' ', array_filter($descriptionParts)) . " in $location. Browse used and new vehicles with great deals and local listings.";
        $h1_heading = implode(' ', array_filter($h1Parts)) . " in $location";
        $canonical_url = url(implode('/', array_filter($canonicalUrlParts)));
        $meta_robots = $totalCount > 0 ? 'index, follow' : 'noindex, follow';

        $seoData = [
            'page_title' => $page_title,
            'meta_description' => $meta_description,
            'h1_heading' => $h1_heading,
            'canonical_url' => $canonical_url,
            'meta_robots' => $meta_robots,
            'make' => $make,
            'model' => $model,
            'location' => $location,
            'fuel_type' => $fuelType,
            'transmission' => $transmission,
            'body_type' => $bodyType,
            'price_to' => $priceTo,
            'year' => $year,
        ];

     
        return $seoData;
    }

    private function getFilterOptions()
    {
        $filterOptions = [
            'make' => Car::select('make', DB::raw('COUNT(*) as count'))
                ->whereNotNull('make')
                ->groupBy('make')
                ->orderBy('make')
                ->get(),
            'model' => Car::select('model', DB::raw('COUNT(*) as count'))
                ->whereNotNull('model')
                ->groupBy('model')
                ->orderBy('model')
                ->get(),
            'location' => DB::table('users')
                ->select('location', DB::raw('COUNT(*) as count'))
                ->whereNotNull('location')
                ->groupBy('location')
                ->orderBy('location')
                ->get(),
            'fuel_type' => Car::select('fuel_type', DB::raw('COUNT(*) as count'))
                ->whereNotNull('fuel_type')
                ->groupBy('fuel_type')
                ->orderBy('fuel_type')
                ->get(),
            'transmission_type' => Car::select('transmission_type', DB::raw('COUNT(*) as count'))
                ->whereNotNull('transmission_type')
                ->groupBy('transmission_type')
                ->orderBy('transmission_type')
                ->get(),
            'body_type' => Car::select('body_type', DB::raw('COUNT(*) as count'))
                ->whereNotNull('body_type')
                ->groupBy('body_type')
                ->orderBy('body_type')
                ->get(),
        ];

        return $filterOptions;
    }
   

    private function getSelectedFilters(array $validated)
    {
        $selectedFilters = [
            'makeselected' => $validated['make'] ?? null,
            'modelselected' => $validated['model'] ?? null,
            'locationselected' => $validated['location'] ?? null,
            'fuel_typeselected' => $validated['fuel_type'] ?? null,
            'transmission_typeselected' => $validated['transmission_type'] ?? null,
            'body_typeselected' => $validated['body_type'] ?? null,
            'pricetoselected' => $validated['price_to'] ?? null,
            'yearselected' => $validated['year'] ?? null,
            'sortselected' => $validated['sort'] ?? 'most-recent',
        ];
    return $selectedFilters;
    }
}