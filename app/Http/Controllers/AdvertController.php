<?php

namespace App\Http\Controllers;
use App\Models\PaymentRecord;
use App\Models\User;
use App\Models\Advert_image;
use App\Models\AdvertImage;
use App\Models\Package;
use App\Models\advert;
use App\Models\Car;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarController;
use App\Mail\AdvertCreatedMail;
use App\Mail\AdvertDeletedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\MotData;
use App\Models\VehicleKeeperData;
use Illuminate\Support\Facades\Storage;
use App\Models\Counter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdvertController extends Controller
{

    
    public function deleteImage($id)
{
    
    $image = Advert_image::where('image_id', $id)->firstOrFail();

    
    if (Storage::disk('public')->exists($image->image_url)) {
        Storage::disk('public')->delete($image->image_url);
        
    } 
    $image->delete();
    return response()->json([
        'success' => true,
        'message' => 'Image deleted successfully'
    ]);
}

    public function editAdvert($id)
    {
        
        $advert = Advert::find($id);

        
        if (!$advert || $advert->user_id !== Auth::id()) {
            return redirect()->route('my_listing')->withErrors('Advert not found or not authorized.');
        }

        
        return view('editadvert', compact('advert'));
    }
    
    
    public function updateAdvert(Request $request, $id)
    {
  
        $advert = Advert::find($id);
    
  
        if (!$advert || $advert->user_id !== Auth::id()) {
            return redirect()->route('my_listing')->withErrors('Advert not found or not authorized.');
        }
    
        
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
    
        
    
        return redirect()->route('my_listing')->with('message', 'Listing has been updated');
    }
    
    public function show_listing()
    {
        $authUser=Auth::user();
        $listing_data = Advert::with('car')
        ->where('user_id', $authUser->id)
        ->where('status', '!=' , 'sold')
        ->orderBy('created_at', 'desc') 
        ->paginate(1000);
        foreach ($listing_data as $advert) {
            $advert->page_views = DB::table('counters')
                ->where('advert_id', $advert->advert_id)
                ->where('counter_type', 'page_view') 
                ->count(); 
          
            $advert->recover_payment = DB::table('payment_records')
            ->join('packages', 'payment_records.package_id', '=', 'packages.id')
            ->where('payment_records.advert_id', $advert->advert_id)
            ->value('packages.recovery_payment'); 

            $advert->total_favorites = DB::table('favourites')
            ->where('advert_id', $advert->advert_id)
            ->count();
        }
        $user_role = $authUser->role;
        return view('MyListingPage', compact('listing_data' , 'user_role'));
    }

    public function getStatus($advertId)
    {
        $advert = Advert::find($advertId); 
        if ($advert) {
            return response()->json(['success' => true, 'status' => $advert->status]);
        } else {
            return response()->json(['success' => false, 'message' => 'Advert not found']);
        }
    }
    
    public function set_favourite(Request $request, $id)
{
    
    $advert = Advert::where('advert_id', $id)->first();
        
    if ($advert) {
        Advert::where('advert_id', $id)->update([
            'favourite' => $advert->favourite == 0 ? 1 : 0,
        ]);
        return redirect()->back()->with('success', 'Favorite status updated.');
    }

    
    return redirect()->back()->withErrors(['error' => 'Advert not found.']);
}
public function show_favourite(){
    $authUser = Auth::user();
    
    
    $favourite_data = Advert::
        with('user') 
        ->where('user_id', $authUser->id)
        ->where('favourite', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('MyFavoritePage', compact('favourite_data'));
}

    public function delete_listing(int $advert_id)
{
    
    $advert = Advert::where('advert_id', $advert_id)->first();

    if (!$advert) {
        return back()->withErrors(['message' => 'Advert not found']);
    }

    
    Advert::where('advert_id', $advert_id)->delete();

 

    return back()->with(['message' => 'Advert deleted successfully']);
}
   
   

    public function show_advert(){
        
    }

    public function showPackages()
    {
        $packages = Package::where('is_active', 1)->get();
        return view('package-select', compact('packages'));
    }

  
    public function storeAdvert(Request $request)
{
  
    $request->validate([
        'fuel_type' => 'required|string|max:255',
        'bodystyle' => 'required|string|max:255',
        'engine' => 'required|string|max:255',
        'Gearbox' => 'required|string|max:255',
        'door' => 'required|integer',
        'seats' => 'required|integer',
        'price' => 'required|numeric',
        'description' => 'nullable|string',
        'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
        'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
    ]);

    
    $package_duration = (int) $request->input('package_duration');
    $expiryDate = now()->addDays($package_duration);

 
    DB::beginTransaction();

    try {
        
        $advert = Advert::create([
            'user_id' => Auth::id(),
            'name' => session('vehicleInfo')['MakeModel'] ?? 'Default Name',
            'license_plate' => session('licensedata')['license_plate'] ?? 'Unknown Plate',
            'miles' => session('licensedata')['miles'] ?? 0,
            'engine' => $request->engine,
            'owner' => Auth::user()->name,
            'description' => $request->description,
            'expiry_date' => $expiryDate,
            'status' => 'active',
        ]);

        if (!$advert) {
            throw new \Exception('Failed to create advert.');
        }

    
        if ($request->hasFile('feature_image')) {
            $featureImage = $request->file('feature_image');
            $featureImageName = time() . '_feature.' . $featureImage->getClientOriginalExtension();
            $featureImagePath = 'images/adverts/' . $featureImageName;
            $featureImage->move(public_path('images/adverts'), $featureImagePath);
            $advert->update(['image' => $featureImagePath]);
        }
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_main.' . $mainImage->getClientOriginalExtension();
            $mainImagePath = 'images/adverts/' . $mainImageName;
            $mainImage->move(public_path('images/adverts'), $mainImagePath);
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

    
        $vrm = session('licensedata')['license_plate'] ?? null;
        if ($vrm) {
            $vrmWithoutSpaces = str_replace(' ', '', $vrm);

            $featuresResponse = app(APIController::class)->getVehiclefeaturesData(new Request(['vrm' => $vrmWithoutSpaces]));
            $featuresResponseData = $featuresResponse->getData();
            if (isset($vehicleData->vehicle_data)) {
                VehicleKeeperData::updateOrCreate(
                    ['license_plate' => $vrmWithoutSpaces],
                    ['vehicle_data' => $vehicleData->vehicle_data]
                );
            }
        }

        Car::create([
            'advert_id' => $advert->advert_id,
            'model' => strtoupper(session('vehicleInfo')['model'] ?? 'Unknown Model'),
            'make' => session('vehicleInfo')['make'] ?? 'Unknown Make',
            'fuel_type' => $request->fuel_type,
            'transmission_type' => $request->Gearbox,
            'body_type' => $request->bodystyle,
            'variant' => session('vehicleInfo')['Trim'] ?? 'Unknown variant',
            'price' => $request->price,
            'year' => session('vehicleInfo')['YearOfManufacture'] ?? now()->year,
            'seller_type' => Auth::user()->role,
            'image' => $advert->image,
            'main_image' => $advert->main_image,
            'miles' => session('licensedata')['miles'] ?? 0,
            'engine_size' => session('vehicleInfo')['EngineCapacity'] . 'L',
            'doors' => $request->door,
            'seats' => $request->seats,
            'colors' => session('vehicleInfo')['Color'] ?? 'Unknown Color',
            'license_plate' => session('licensedata')['license_plate'] ?? 'Unknown Plate',
            'description' => $request->description,
            'Rpm' => session('vehicleInfo')['Rpm'] ?? 0,
            'RigidArtic' => session('vehicleInfo')['RigidArtic'] ?? 'Unknown',
            'BodyShape' => session('vehicleInfo')['BodyShape'] ?? 'Unknown',
            'NumberOfAxles' => session('vehicleInfo')['NumberOfAxles'] ?? 0,
            'FuelTankCapacity' => session('vehicleInfo')['FuelTankCapacity'] ?? 0,
            'GrossVehicleWeight' => session('vehicleInfo')['GrossVehicleWeight'] ?? 0,
            'FuelCatalyst' => session('vehicleInfo')['FuelCatalyst'] ?? 'Unknown',
            'Aspiration' => session('vehicleInfo')['Aspiration'] ?? 'Unknown',
            'FuelSystem' => session('vehicleInfo')['FuelSystem'] ?? 'Unknown',
            'FuelDelivery' => session('vehicleInfo')['FuelDelivery'] ?? 'Unknown',
            'Bhp' => session('vehicleInfo')['Bhp'] ?? 0,
            'Kph' => session('vehicleInfo')['Kph'] ?? 0,
            'Transmission' => session('vehicleInfo')['Transmission'] ?? 'Unknown',
            'EngineCapacity' => session('vehicleInfo')['EngineCapacity'] . 'L',
            'NumberOfCylinders' => session('vehicleInfo')['NumberOfCylinders'] ?? 0,
            'gear_box' => session('vehicleInfo')['gear_box'] ?? 'Unknown',
            'DriveType' => session('vehicleInfo')['DriveType'],
            'Range' => session('vehicleInfo')['Range'],
            'Trim' => session('vehicleInfo')['Trim'],
            'Scrapped' => session('vehicleInfo')['Scrapped'],
            'Imported' => session('vehicleInfo')['Imported'],
            'ExtraUrban' => session('vehicleInfo')['ExtraUrban'],
            'UrbanCold' => session('vehicleInfo')['UrbanCold'],
            'Combined' => session('vehicleInfo')['Combined'],
        ]);

       
        $paymentRecord = PaymentRecord::where('user_id', Auth::id())->latest()->first();
        if ($paymentRecord) {
            $paymentRecord->advert_id = $advert->advert_id;
            $paymentRecord->save();
        }

        DB::commit();
            
       
        
        return redirect()->route('my_listing')->with('success', 'Advert submitted successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors('Failed to create advert: ' . $e->getMessage());
    }
}




   
    

}

    