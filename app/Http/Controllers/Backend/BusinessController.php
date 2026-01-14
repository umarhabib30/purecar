<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessImage;
use App\Models\BusinessType;
use App\Models\BusinessLocation;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
        {$businesses = Business::with('businessType', 'businessLocation', 'images')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('business.backend.businesses.index', compact('businesses'));
    }
    public function show(Business $business)
    {
        $business->load('businessType', 'businessLocation', 'images');
        return view('business.backend.businesses.show', compact('business'));
    }
    public function edit(Business $business)
    {
        $businessTypes = BusinessType::all();
        $businessLocations = BusinessLocation::all();
        $business->load('images');
        return view('business.backend.businesses.edit', compact('business', 'businessTypes', 'businessLocations'));
    }

    public function update(Request $request, $id)
    {
        $business = Business::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'business_type_id' => 'required|exists:business_types,id',
            'business_location_id' => 'required|exists:business_locations,id',
            'contact_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $business->update($validated);

        // Handle new image uploads
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

        return redirect()->route('list-businesses.index')->with('success', 'Business updated successfully!');
    }

    public function delete(Business $business)
    {
        foreach ($business->images as $image) {
            $imagePath = public_path($image->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();
        }
        $business->delete();
        return redirect()->route('list-businesses.index')->with('success', 'Business deleted successfully!');
    }

    public function approve(Business $business)
    {
        $business->update(['is_approved' => true]);
        return redirect()->route('list-businesses.index')->with('success', 'Business approved successfully!');
    }

    public function deleteImage($imageId)
    {
        $image = BusinessImage::findOrFail($imageId);
        $imagePath = public_path($image->image_path);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $image->delete();
        return back()->with('success', 'Image deleted successfully!');
    }
}