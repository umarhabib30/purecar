<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Advert;
use App\Models\Counter;
use App\Models\ForumPost;
use App\Models\User;
use App\Models\Advert_image;
use App\Models\PageSection;
use App\Models\Package;
use App\Models\Favourite;
use App\Models\Event;
use App\Models\ForumTopicCategory;
use App\Models\PriceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class landingPageController extends Controller
{
    
 public function landing_page(){
    $data = Car::whereHas('advert', function ($query) {
    $query->where('status', 'active');
        })
        ->inRandomOrder()
        ->take(16)
        ->get();

    
    $blogs = Blog::latest()->take(5)->get();
    $sections = PageSection::all();
    $brands = Brand::all();
    $events = Event::latest()->take(3)->get();
    $forum_posts = ForumPost::latest()->take(4)->get();
    



     $totalCars = Advert::where('status', 'active')
     ->count();
    $forumSections = ForumTopicCategory::count(); 
    $visitorsPerDay = rand(5000, 10000); 
    $verifiedDealers = User::where('role', 'car_dealer')
        ->count();


    $counters = [
        'cars' => $totalCars,
        'forums' => $forumSections,
        'visitors' => $visitorsPerDay,
        'dealers' => $verifiedDealers,
    ];


    $price_ranges = [
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
    
   
    $price_counts = [];
    foreach ($price_ranges as $range) {
        $count = Car::whereBetween('price', [$range['min'], $range['max']])->count();
        $price_counts[] = [
            'min' => $range['min'],
            'max' => $range['max'],
            'count' => $count
        ];
    }
    
   
    $year_counts = Car::select('year', DB::raw('COUNT(*) as count'))
        ->whereNotNull('year')
        ->where('year', '>', 0)
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->get()
        ->map(function($item) {
            return [
                'year' => $item->year,
                'count' => $item->count
            ];
        })
        ->toArray();
    
    // Search field data
    $search_field = [
        'make' => Car::select('make', DB::raw('COUNT(*) as count'))
            ->whereNotNull('make')
            ->where('make', '!=', '')
            ->groupBy('make')
            ->orderBy('make')
            ->get(),
        'model' => Car::select('model', DB::raw('COUNT(*) as count'))
            ->whereNotNull('model')
            ->where('model', '!=', '')
            ->groupBy('model')
            ->orderBy('model')
            ->get(),
        'variant' => Car::select('variant', DB::raw('COUNT(*) as count'))
            ->whereNotNull('variant')
            ->where('variant', '!=', '')
            ->groupBy('variant')
            ->orderBy('variant')
            ->get(),
        'price' => Car::select('price', DB::raw('COUNT(*) as count'))
            ->whereNotNull('price')
            ->where('price', '>', 0)
            ->groupBy('price')
            ->orderBy('price')
            ->get(),
        'year' => Car::select('year', DB::raw('COUNT(*) as count'))
            ->whereNotNull('year')
            ->where('year', '>', 0)
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get(),
    ];

    // take 5 random dealers
    $dealers = User::where('role', 'car_dealer')->take(5)->inRandomOrder()->get();
    
    return view('landing_page', compact(
        'data',
        'events',
        'search_field',
        'blogs',
        'sections',
        'brands',
        'forum_posts',
        'price_ranges',
        'price_counts',
        'year_counts',
        'counters',
        'dealers'
    ));
}

public function fetchVariants(Request $request)
{
    $model = $request->input('model');

  
    $variants = Car::where('model', $model)
        ->select('variant', DB::raw('COUNT(*) as count'))
        ->groupBy('variant')
        ->get();

    return response()->json(['variants' => $variants]);
}
public function fetchModels(Request $request)
{
    $make = $request->query('make');
    $priceFrom = $request->query('pricefrom'); 
    $priceTo = $request->query('priceto');     
    $yearFrom = $request->query('yearfrom');
    $yearTo = $request->query('yearto');

    $query = Car::query()
        ->join('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
        ->where('cars.make', $make)
        ->where('adverts.status', 'active'); 

    if ($priceFrom) {
        $query->where('cars.price', '>=', $priceFrom);
    }
    if ($priceTo) {
        $query->where('cars.price', '<=', $priceTo);
    }
    if ($yearFrom) {
        $query->where('cars.year', '>=', $yearFrom);
    }
    if ($yearTo) {
        $query->where('cars.year', '<=', $yearTo);
    }

    $models = $query->groupBy('cars.model')
        ->select('cars.model', DB::raw('COUNT(*) as count'))
        ->get();

    return response()->json(['models' => $models]);
}
public function fetchVariantshome(Request $request)
{
    $make = $request->get('make');
    $model = $request->get('model');
    $priceFrom = $request->query('pricefrom'); 
    $priceTo = $request->query('priceto');     
    $yearFrom = $request->query('yearfrom');
    $yearTo = $request->query('yearto');

    if (!$make || !$model) {
        return response()->json(['variants' => []]);
    }

    $query = Car::query()
        ->join('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
        ->where('cars.make', $make)
        ->where('cars.model', $model)
        ->whereNotNull('cars.variant')
        ->where('cars.variant', '!=', '')
        ->where('adverts.status', 'active'); 

    if ($priceFrom) {
        $query->where('cars.price', '>=', $priceFrom);
    }
    if ($priceTo) {
        $query->where('cars.price', '<=', $priceTo);
    }
    if ($yearFrom) {
        $query->where('cars.year', '>=', $yearFrom);
    }
    if ($yearTo) {
        $query->where('cars.year', '<=', $yearTo);
    }

    $variants = $query->groupBy('cars.variant')
        ->select('cars.variant', DB::raw('COUNT(*) as count'))
        ->orderBy('cars.variant')
        ->get();

    return response()->json(['variants' => $variants]);
}

// public function fetchVariantshome(Request $request)
// {
//     $make = $request->get('make');
//     $model = $request->get('model');
    
//     if (!$make || !$model) {
//         return response()->json(['variants' => []]);
//     }
    
//     $variants = Car::select('variant', DB::raw('COUNT(*) as count'))
//         ->where('make', $make)
//         ->where('model', $model)
//         ->whereNotNull('variant')
//         ->where('variant', '!=', '')
//         ->groupBy('variant')
//         ->orderBy('variant')
//         ->get();
    
//     return response()->json(['variants' => $variants]);
// }
// public function fetchModels(Request $request)
// {
//     // Extract all filter parameters
//     $make = $request->input('make');
//     $priceFrom = $request->input('pricefrom');
//     $priceTo = $request->input('priceto');
//     $fuelType = $request->input('fuel_type');
//     $bodyType = $request->input('body_type');
//     $engineSize = $request->input('engine_size');
//     $doors = $request->input('doors');
//     $colors = $request->input('colors');
//     $sellerType = $request->input('seller_type');
//     $gearBox = $request->input('gear_box');
//     $yearFrom = $request->input('yearFrom');
//     $yearTo = $request->input('yearTo');
    
//     // Start building the query with the make filter
//     $query = Car::where('make', $make);
    
//     // Apply all other active filters
//     if ($priceFrom) {
//         $query->where('price', '>=', $priceFrom);
//     }
    
//     if ($priceTo) {
//         $query->where('price', '<=', $priceTo);
//     }
    
//     if ($fuelType) {
//         $query->where('fuel_type', $fuelType);
//     }
    
//     if ($bodyType) {
//         $query->where('body_type', $bodyType);
//     }
    
//     if ($engineSize) {
//         $query->where('engine_size', $engineSize);
//     }
    
//     if ($doors) {
//         $query->where('doors', $doors);
//     }
    
//     if ($colors) {
//         $query->where('colors', $colors);
//     }
    
//     if ($sellerType) {
//         $query->where('seller_type', $sellerType);
//     }
    
//     if ($gearBox) {
//         $query->where('gear_box', $gearBox);
//     }
    
//     if ($yearFrom) {
//         $query->where('year', '>=', $yearFrom);
//     }
    
//     if ($yearTo) {
//         $query->where('year', '<=', $yearTo);
//     }
    
//     // Get models after applying all filters
//     $models = $query->select('model', DB::raw('COUNT(*) as count'))
//                     ->groupBy('model')
//                     ->get();
    
//     return response()->json(['models' => $models]);
// }

// public function fetchVariants(Request $request)
// {
//     // Extract all filter parameters
//     $model = $request->input('model');
//     $make = $request->input('make');
//     $priceFrom = $request->input('pricefrom');
//     $priceTo = $request->input('priceto');
//     $fuelType = $request->input('fuel_type');
//     $bodyType = $request->input('body_type');
//     $engineSize = $request->input('engine_size');
//     $doors = $request->input('doors');
//     $colors = $request->input('colors');
//     $sellerType = $request->input('seller_type');
//     $gearBox = $request->input('gear_box');
//     $yearFrom = $request->input('yearFrom');
//     $yearTo = $request->input('yearTo');
    
//     // Start building the query with the model filter
//     $query = Car::where('model', $model);
    
//     // Apply all other active filters
//     if ($make) {
//         $query->where('make', $make);
//     }
    
//     if ($priceFrom) {
//         $query->where('price', '>=', $priceFrom);
//     }
    
//     if ($priceTo) {
//         $query->where('price', '<=', $priceTo);
//     }
    
//     if ($fuelType) {
//         $query->where('fuel_type', $fuelType);
//     }
    
//     if ($bodyType) {
//         $query->where('body_type', $bodyType);
//     }
    
//     if ($engineSize) {
//         $query->where('engine_size', $engineSize);
//     }
    
//     if ($doors) {
//         $query->where('doors', $doors);
//     }
    
//     if ($colors) {
//         $query->where('colors', $colors);
//     }
    
//     if ($sellerType) {
//         $query->where('seller_type', $sellerType);
//     }
    
//     if ($gearBox) {
//         $query->where('gear_box', $gearBox);
//     }
    
//     if ($yearFrom) {
//         $query->where('year', '>=', $yearFrom);
//     }
    
//     if ($yearTo) {
//         $query->where('year', '<=', $yearTo);
//     }
    
//     // Get variants after applying all filters
//     $variants = $query->select('variant', DB::raw('COUNT(*) as count'))
//                     ->groupBy('variant')
//                     ->get();
    
//     return response()->json(['variants' => $variants]);
// }
// public function fetchModels(Request $request)
//     {
//         $filters = $request->only([
//             'make', 'model', 'variant', 'fuel_type', 'body_type', 'engine_size',
//             'doors', 'colors', 'seller_type', 'gear_box', 'miles', 'year_from',
//             'year_to', 'price_from', 'price_to'
//         ]);

//         $query = Car::query();

//         foreach ($filters as $key => $value) {
//             if ($value && $value !== 'Any') {
//                 if ($key === 'price_from') {
//                     $query->where('price', '>=', $value);
//                 } elseif ($key === 'price_to') {
//                     $query->where('price', '<=', $value);
//                 } elseif ($key === 'year_from') {
//                     $query->where('year', '>=', $value);
//                 } elseif ($key === 'year_to') {
//                     $query->where('year', '<=', $value);
//                 } elseif ($key === 'miles') {
//                     $query->where('miles', '<=', $value);
//                 } else {
//                     $query->where($key, $value);
//                 }
//             }
//         }

//         $models = $query->select('model')
//             ->groupBy('model')
//             ->get()
//             ->map(function ($item) {
//                 return [
//                     'model' => $item->model,
//                     'count' => Car::where('model', $item->model)->count()
//                 ];
//             });

//         return response()->json(['models' => $models]);
//     }

//     public function fetchVariants(Request $request)
//     {
//         $filters = $request->only([
//             'make', 'model', 'variant', 'fuel_type', 'body_type', 'engine_size',
//             'doors', 'colors', 'seller_type', 'gear_box', 'miles', 'year_from',
//             'year_to', 'price_from', 'price_to'
//         ]);

//         $query = Car::query();

//         foreach ($filters as $key => $value) {
//             if ($value && $value !== 'Any') {
//                 if ($key === 'price_from') {
//                     $query->where('price', '>=', $value);
//                 } elseif ($key === 'price_to') {
//                     $query->where('price', '<=', $value);
//                 } elseif ($key === 'year_from') {
//                     $query->where('year', '>=', $value);
//                 } elseif ($key === 'year_to') {
//                     $query->where('year', '<=', $value);
//                 } elseif ($key === 'miles') {
//                     $query->where('miles', '<=', $value);
//                 } else {
//                     $query->where($key, $value);
//                 }
//             }
//         }

//         $variants = $query->select('variant')
//             ->groupBy('variant')
//             ->get()
//             ->map(function ($item) {
//                 return [
//                     'variant' => $item->variant,
//                     'count' => Car::where('variant', $item->variant)->count()
//                 ];
//             });

//         return response()->json(['variants' => $variants]);
//     }

private function getSections()
{
    return PageSection::all();
}
public function signuppage()
{
    $sections = $this->getSections();
    return view('signup_page', compact('sections'));
}

public function loginpage()
{
    $sections = $this->getSections();
    return view('login_page', compact('sections'));
}
public function adminloginpage()
{   $sections = $this->getSections();
    return view('admin_login/admin_login_page', compact('sections'));
}





public function searchMake(Request $request)
    {
        $priceRange = PriceSetting::first();

        if (!$priceRange) {
           
            return response()->json([
                'success' => false,
                'message' => 'No price range set. Please configure price settings.',
                'car_data' => [],
            ]);
        }

        $minPrice = $priceRange->min_price;
        $maxPrice = $priceRange->max_price;

        $car_data = Car::where('price', '>=', $minPrice)
            ->where('price', '<=', $maxPrice)
            ->whereHas('advert', function ($query) {
                $query->where('status', 'active');
            })
            ->with('user:id,location')
            ->orderBy('price', 'asc')
            // ->take(4)
              ->whereNotNull('make')       // Exclude null values
        ->where('make', '!=', '')  
         ->where('make', '!=', 'UNKNOWN') 
          ->where('make', '!=', 'N/A')  
           ->where('make', '!=', '') 
            ->get();

        return response()->json([
            'success' => true,
            'car_data' => $car_data->map(function ($car) {
                return [
                    'car_id' => $car->car_id,
                    'car_slug' => $car->slug,
          
          'make' => $car->make,
                    'model' => $car->model,
                    'Trim' => $car->Trim,
                    'year' => $car->year,
                    'miles' => $car->miles,
                    'fuel_type' => $car->fuel_type,
                    'gear_box' => $car->gear_box,
                    'engine_size' => $car->engine_size,
                    'seller_type' => $car->user->role === 'car_dealer' ? 'Dealer' : 'Private',
                    'location' => $car->user->location ?? 'N/A',
                    'price' => $car->price,
                    'image' => $car->image,
                ];
            }),
        ]);
    }

    public function CheapestCars() {
    $data = Car::whereHas('advert', function ($query) {
            $query->where('status', 'active');
        })
        ->whereNotNull('make')       // Exclude null values
        ->where('make', '!=', '')  
         ->where('make', '!=', 'UNKNOWN') 
          ->where('make', '!=', 'N/A')  
           ->where('make', '!=', '') 
        ->where('price', '>', 0)
        ->orderBy('price', 'asc')
        ->get();

    return view('cheapestcars.index', compact('data'));
}


public function showCarInfo($slug)
{
    $car_info = Car::with(['user', 'advert_images', 'advert.notes'])->where('slug', $slug)->first();
    if (!$car_info && is_numeric($slug)) {
        $car_info = Car::with(['user', 'advert_images', 'advert'])->find($slug);
    }
    
     if (!$car_info || !$car_info->advert) {
            $parts = explode('-', $slug);
            $make = $parts[0] ?? null;   
            $model = $parts[1] ?? null;  
            return redirect()->route('search_car', [
                'make' => $make,
                'model' => $model,
            ]);
        }
        
    
    Counter::create([
        'advert_id' => $car_info->advert_id,
        'counter_type' => 'page_view',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $user = $car_info->advert->user;
  
    $related_cars = Car::whereHas('advert', function ($query) use ($user) {
        $query->where('user_id', $user->id)
                ->where('status', 'active');
    })
    ->where('car_id', '!=', $car_info->car_id)
    ->latest() 
    ->take(4) 
    ->get();

    $total_cars = Car::whereHas('advert', function ($query) use ($user) {
        $query->where('user_id', $user->id)
              ->where('status', 'active');
    })
    ->count();

 

    $meta_title = $car_info->advert->name ?? 'Car Advert';
    $meta_description = Str::limit(strip_tags($car_info->advert->description), 150);
    $meta_image = !empty($car_info->advert->image) ? asset($car_info->advert->image) : null;
    $meta_type = 'article';

    return view('forum_carinfo', compact('car_info', 'related_cars', 'total_cars', 'meta_title', 'meta_description', 'meta_image', 'meta_type'));
}

public function termsAndConditions()
{
    return view('terms_and_conditions'); // This should match the Blade file name you saved.
}
public function privacyPolicy()
{
    return view('privacy_policy');
}
public function refundPolicy()
{
    return view('refund_policy');
}


public function fetchpacakges()
{
    
    $packages = Package::where('is_active', true)
                     ->orderBy('price', 'asc')
                     ->get();

    return view('pricing', compact('packages'));
}

}