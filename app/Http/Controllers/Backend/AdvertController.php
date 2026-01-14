<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\advert;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\User;
use App\Models\PriceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Advert_image;
use Illuminate\Support\Facades\DB;
class AdvertController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Advert::with(['car', 'user'])
            ->select('adverts.*')
            ->selectRaw('(SELECT COUNT(*) FROM counters WHERE counters.advert_id = adverts.advert_id AND counters.counter_type = "page_view") as page_views')
            ->selectRaw('(SELECT packages.recovery_payment FROM payment_records JOIN packages ON payment_records.package_id = packages.id WHERE payment_records.advert_id = adverts.advert_id LIMIT 1) as recover_payment')
            ->selectRaw('(SELECT COUNT(*) FROM favourites WHERE favourites.advert_id = adverts.advert_id) as total_favorites');

        if ($search) {
            $query->whereHas('car', function ($q) use ($search) {
                $q->where('make', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('variant', 'like', "%{$search}%");
            });
        }

        $listing_data = $query->latest()->paginate(20); // Paginate with 20 items per page

        return view('adverts.list_ads', compact('listing_data'));
    }
    public function setprice()
    {
        $priceSettings = PriceSetting::first();
        return view('/adverts/set_price', compact('priceSettings'));
    }

    public function updatePrice(Request $request)
    {
        $request->validate([
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gt:min_price'
        ]);

        PriceSetting::updateOrCreate(
            ['id' => 1],
            [
                'min_price' => $request->min_price,
                'max_price' => $request->max_price
            ]
        );

        return redirect()->back()->with('status', 'Price settings updated successfully!');
    }

    
    public function edit($advert_id)
    {
        
        $advert = Advert::where('advert_id', $advert_id)
            ->with('Car')
            ->firstOrFail();

        return view('adverts.edit_ad', compact('advert'));
    }

  
    public function update(Request $request, $id)
    {
        
        $advert = Advert::find($id);
    
    
        
        $request->validate([
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'miles' => 'required|numeric',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
        ]);
    
        
        $advert->update([
            'description' => $request->description,
        ]);
        $advert->car()->update([
            'price' => $request->price,
            'miles' => $request->miles,
        ]);
    
        
        if ($request->hasFile('feature_image')) {
            $featureImage = $request->file('feature_image');
          
        
            $featureImageName = time() . '_feature.' . $featureImage->getClientOriginalExtension();
            $featureImage->move(public_path('images/adverts'), $featureImageName);
            $featureImagePath = 'images/adverts/' . $featureImageName;
        
     
        
            // Update the advert with the new feature image
            $advert->update(['image' => $featureImagePath]);
            $advert->car->update(['image' => $featureImagePath]);
        } else {
            
        }
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_main.' . $mainImage->getClientOriginalExtension();
            $mainImagePath = 'images/adverts/' . $mainImageName;
            $mainImage->move(public_path('images/adverts'), $mainImagePath);
            $advert->car->update(['main_image' => $mainImagePath]);
            $advert->update(['main_image' => $mainImagePath]);
        }
    
       
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = 'images/adverts/' . time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/adverts'), $path);

                Advert_image::create([
                    'advert_id' => $advert->advert_id,
                    'image_url' => $path,
                ]);

             
            }
        }
      
    
        return redirect()->route('list-ads.index')->with('success', 'Advert updated successfully');
    }
    
    
      

   
}

