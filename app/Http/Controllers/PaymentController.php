<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Stripe\Stripe;
use App\Models\Car;
use App\Models\Advert;
use App\Models\Advert_image;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\Advert_ImageController;


class PaymentController extends Controller
{


    public function processPayment(Request $request)
{


    $action = $request->input('action');

    if ($action === 'edit') {
        $message="readonly";
        return redirect()->back()->with([
            'message' => $message,
            'tag' => 'Editable Fields'
        ]);

    }

    $request->validate([
        'price'=>'required',
        'description'=>'required',
        'img1'=>'required|image|mimes:png,jpg,jpeg|max:2048',
        'img2'=>'required|image|mimes:png,jpg,jpeg|max:2048',
        'img3'=>'required|image|mimes:png,jpg,jpeg|max:2048'
    ]);

    if ($action === 'pay') {

    $advert_img = [];

    foreach (['img1', 'img2', 'img3'] as $imageKey) {
        if ($request->hasFile($imageKey)) {
            $file = $request->file($imageKey);
            $imageName = time() . '_' . $imageKey . '.' . $file->getClientOriginalExtension();

            $file->storeAs('advert_img', $imageName, 'public');

            $advert_img[$imageKey] = 'advert_img/' . $imageName;
        }
    }

    session([
        'advert_img' => $advert_img,
        'advert_data' => $request->except('img1', 'img2', 'img3'), // Save other form fields except images
        'advert_desc'=>$request->description
    ]);

    Stripe::setApiKey(env('STRIPE_SECRET'));



    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'usd',  
                    'product_data' => [
                        'name' => 'Advert Payment',  
                    ],
                    'unit_amount' => 1000,  
                ],
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => route('pay.success'),  
        'cancel_url' => route('pay.cancel'),    
    ]);

    
    return redirect($session->url);
 }
}


    public function success()
    {
        if(session('advert_data')){
            $adExpiryDays = getCompanyDetail('ad_expiry'); 

         
            $expiryDate = now()->addDays($adExpiryDays)->format('Y-m-d');
           $advert = Advert::create([
            'user_id'=> Auth::user()->id,
            'name' => session('vehicleInfo')['MakeModel'],
            'license_plate' => session('licensedata')['license_plate'],
            'miles' => session('licensedata')['miles'],
            'engine' => 'TESLA123',
            'owner' => session('advert_data')['owners'],
            'description' => session('advert_desc'),
            'expiry_date' => $expiryDate,
            'status' => 'active', 
            'miles' => session('licensedata')['miles'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $advert_img = session('advert_img');
        Advert::where('advert_id', $advert->id)
        ->update(['image' => $advert_img['img1']]);
        foreach ($advert_img as $imagePath) {
            Advert_image::create([
                'advert_id' => $advert->id, 
                'image_url' => $imagePath,   
            ]);
        }
      

        $car = Car::create([
            'advert_id' => $advert->id,
            'model' => session('vehicleInfo')['model'],
            'make' => session('vehicleInfo')['make'],
            'fuel_type' => session('advert_data')['fuel_type'],
            'transmission_type' => session('advert_data')['Gearbox'],
            'body_type' => session('advert_data')['bodystyle'],
            'variant' => session('vehicleInfo')['variant'],
            'keyword' => '',
            'price' => session('advert_data')['price'],
            'year' => session('vehicleInfo')['YearOfManufacture'],
            'seller_type' => Auth::user()->role,
            'image' => $advert_img['img1'],
            'miles' => session('licensedata')['miles'],
            'engine_size' => session('vehicleInfo')['EngineCapacity'] . 'L',
            'doors' => session('advert_data')['door'],
            'seats' => session('advert_data')['seats'],
            'colors' => session('vehicleInfo')['Color'],
            'advert_variant' => session('vehicleInfo')['variant'],
            'advert_colour' => session('vehicleInfo')['Color'],
            'license_plate' => session('licensedata')['license_plate'],
            'created_at' => now(),
            'updated_at' => now(),

      
            'Rpm' => session('vehicleInfo')['Rpm'],
            'RigidArtic' => session('vehicleInfo')['RigidArtic'],
            'BodyShape' => session('vehicleInfo')['BodyShape'],
            'NumberOfAxles' => session('vehicleInfo')['NumberOfAxles'],
            'FuelTankCapacity' => session('vehicleInfo')['FuelTankCapacity'],
            'GrossVehicleWeight' => session('vehicleInfo')['GrossVehicleWeight'],
            'FuelCatalyst' => session('vehicleInfo')['FuelCatalyst'],
            'Aspiration' => session('vehicleInfo')['Aspiration'],
            'FuelSystem' => session('vehicleInfo')['FuelSystem'],
            'FuelDelivery' => session('vehicleInfo')['FuelDelivery'],


            'Bhp' => session('vehicleInfo')['Bhp'],
            'Kph' => session('vehicleInfo')['Kph'],
            'Transmission' => session('vehicleInfo')['Transmission'],
            'EngineCapacity' => session('vehicleInfo')['EngineCapacity'] . 'L',

            'NumberOfCylinders' => session('vehicleInfo')['NumberOfCylinders'],
            'gear_box' => session('vehicleInfo')['gear_box'],
            'DriveType' => session('vehicleInfo')['DriveType'],
            'Range' => session('vehicleInfo')['Range'],
            'Trim' => session('vehicleInfo')['Trim'],
            'Scrapped' => session('vehicleInfo')['Scrapped'],
            'Imported' => session('vehicleInfo')['Imported'],
            


        ]);


      
        session()->forget(['vehicleInfo','licensedata','advert_data','advert_img']);



        }

         return view('success');

        }

 
    public function cancel()
    {
         
        $advertImages = session('advert_img', []);

        foreach ($advertImages as $imagePath) {
      
            Storage::disk('public')->delete($imagePath);
        }

        session()->forget(['vehicleInfo','licensedata','advert_data','advert_img']);
        return view('cancel');
    }
}
