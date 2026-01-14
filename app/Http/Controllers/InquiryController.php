<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Counter;
use Illuminate\Support\Facades\Log;
use App\Models\Car;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function sendInquiry(Request $request)
    {
        try {
            $validated = $request->validate([
                'advert_id' => 'required|integer',
                'advert_name' => 'required|string|max:255',
                'seller_email' => 'required|string',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone_number' => 'required|string',
                'message' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        }

        try {
         
            $car = Car::with('advert_images')
                      ->where('advert_id', $request->advert_id)
                      ->firstOrFail();


            $inquiry = Inquiry::create($validated);


            $data = $request->all();
            $data['car_slug'] = $car->slug;

            $carImage = $this->getCarImage($car);
            $data['car_image'] = $carImage;

   
            Mail::to($request->seller_email)->send(new \App\Mail\InquiryMail($data));

        } catch (\Exception $e) {
            Log::error('Failed to send inquiry email: ' . $e->getMessage(), [
                'advert_id' => $request->advert_id,
                'error' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }

        try {
            Counter::create([
                'advert_id' => $request->advert_id,
                'counter_type' => 'emailsu'
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to create counter: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Your details have been sent to the seller'
        ]);
    }

    public function sendInquiryDealer(Request $request)
    {
        try {
            $validated = $request->validate([
                'dealer_email' => 'required|string',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone_number' => 'required|string',
                'message' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        }

        try {
            $inquiryData = collect($validated)->except('dealer_email')->toArray();
            $inquiryData['advert_id'] = 0; 
            $inquiryData['advert_name'] = 'General Inquiry';
            $inquiryData['seller_email'] = $validated['dealer_email'];

            $data = $inquiryData;
            $inquiry = Inquiry::create($inquiryData);      

            $dealerEmail = $validated['dealer_email'];
            Mail::to($dealerEmail)->send(new \App\Mail\DealerInquiryMail($data));

        } catch (\Exception $e) {
            Log::error('Failed to send dealer inquiry email: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email: ' . $e->getMessage()
            ], 500);
        }

        try {
            Counter::create([
                'counter_type' => 'general_inquiry',
                'created_at' => now()
            ]);
        } catch (\Exception $e) {
            
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Your inquiry has been sent successfully'
        ]);
    }

  
    private function getCarImage($car)
    {
       
        if (!empty($car->main_image)) {
         
            if (filter_var($car->main_image, FILTER_VALIDATE_URL)) {
                return $car->main_image;
            }
      
            return asset('storage/cars/' . $car->main_image);
        }

        // Priority 2: Check image field
        if (!empty($car->image)) {
            if (filter_var($car->image, FILTER_VALIDATE_URL)) {
                return $car->image;
            }
            return asset('storage/cars/' . $car->image);
        }

        // Priority 3: Get first image from advert_images relationship
        if ($car->advert_images && $car->advert_images->isNotEmpty()) {
            $firstImage = $car->advert_images->first();
            
            // Check if image_path exists (adjust field name based on your DB schema)
            if (isset($firstImage->image_path)) {
                if (filter_var($firstImage->image_path, FILTER_VALIDATE_URL)) {
                    return $firstImage->image_path;
                }
                return asset('storage/adverts/' . $firstImage->image_path);
            }
            
            // Alternative: if the field is named 'image'
            if (isset($firstImage->image)) {
                if (filter_var($firstImage->image, FILTER_VALIDATE_URL)) {
                    return $firstImage->image;
                }
                return asset('storage/adverts/' . $firstImage->image);
            }
        }

        // Priority 4: Fallback placeholder
        return 'https://via.placeholder.com/600x300/cccccc/666666?text=No+Image+Available';
    }
}