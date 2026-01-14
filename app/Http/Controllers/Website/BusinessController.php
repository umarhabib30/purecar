<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Business;
use App\Models\BusinessImage;
use App\Models\BusinessType;
use App\Models\BusinessLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessController extends Controller
{
    public function create()
    {
        $businessTypes = BusinessType::orderBy('name')->get();

        $businessLocations = BusinessLocation::orderBy('name')->get();


        return view('business.website.business.create', compact('businessTypes', 'businessLocations'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'business_type_id' => 'required|exists:business_types,id',
            'business_location_id' => 'required|exists:business_locations,id',
            'contact_no' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:20048',
        ]);

        $business = Business::create($validated);

        if ($request->hasFile('images')) {
            $directory = public_path('images/business');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($directory, $filename);
                $path = 'images/business/' . $filename;

                BusinessImage::create([
                    'business_id' => $business->id,
                    'image_path' => $path,
                ]);
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Business listing submitted successfully!'
            ]);
        }

        return redirect()->route('business.index')->with('success', 'Business listing submitted successfully!');
    }

    public function index(Request $request)
    {
       $count = Business::with('businessType', 'businessLocation', 'images')
            ->where('is_approved', true)
            ->count();
        $businessTypes = BusinessType::whereHas('businesses', function ($query) use ($request) {
            $query->where('is_approved', true);
            if ($request->has('business_location_id') && $request->business_location_id) {
                $query->where('business_location_id', $request->business_location_id);
            }
        })->orderBy('name')->get();

        $businessLocations = BusinessLocation::whereHas('businesses', function ($query) use ($request) {
            $query->where('is_approved', true);
            if ($request->has('business_type_id') && $request->business_type_id) {
                $query->where('business_type_id', $request->business_type_id);
            }
        })->orderBy('name')->get();

        $query = Business::with('businessType', 'businessLocation', 'images')
            ->where('is_approved', true);

        if ($request->has('business_type_id') && $request->business_type_id) {
            $query->where('business_type_id', $request->business_type_id);
        }

        if ($request->has('business_location_id') && $request->business_location_id) {
            $query->where('business_location_id', $request->business_location_id);
        }

        $count = $query->count();

        $businesses = $query->paginate(10);

        return view('business.website.business.index', compact('businesses', 'businessTypes', 'businessLocations','count'));
    }

    public function getBusinessTypesByLocation(Request $request)
    {
        $locationId = $request->query('business_location_id');

        $businessTypes = BusinessType::whereHas('businesses', function ($query) use ($locationId) {
            $query->where('is_approved', true);
            if ($locationId) {
                $query->where('business_location_id', $locationId);
            }
        })->get();

        return response()->json([
            'business_types' => $businessTypes->map(function ($type) {
                return ['id' => $type->id, 'name' => $type->name];
            })
        ]);
    }

    public function getBusinessLocationsByType(Request $request)
    {
        $typeId = $request->query('business_type_id');

        $businessLocations = BusinessLocation::whereHas('businesses', function ($query) use ($typeId) {
            $query->where('is_approved', true);
            if ($typeId) {
                $query->where('business_type_id', $typeId);
            }
        })->get();

        return response()->json([
            'business_locations' => $businessLocations->map(function ($location) {
                return ['id' => $location->id, 'name' => $location->name];
            })
        ]);
    }

    public function show(Business $business)
    {
        if (!$business->is_approved) {
            abort(404);
        }

        $business->load('businessType', 'businessLocation', 'images');

        return redirect()->route('business.show.seo', [
            'city' => $business->businessLocation->slug ?? Str::slug($business->businessLocation->name),
            'category' => $business->businessType->slug ?? Str::slug($business->businessType->name),
            'slug' => $business->slug ?? Str::slug($business->name)
        ]);
    }

    public function showBySlug($city, $category, $slug)
    {
        $business = Business::where('slug', $slug)
            ->whereHas('businessLocation', function ($query) use ($city) {
                $query->where('slug', $city)->orWhere('name', $city);
            })
            ->whereHas('businessType', function ($query) use ($category) {
                $query->where('slug', $category)->orWhere('name', $category);
            })
            ->with('businessType', 'businessLocation', 'images')
            ->firstOrFail();

        if (!$business->is_approved) {
            abort(404);
        }
        $data = Car::whereHas('advert', function ($query) {
            $query->where('status', 'active');
        })->inRandomOrder()->take(4)->get();

        return view('business.website.business.show', compact('business','data'));
    }
}