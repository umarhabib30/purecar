<?php

namespace App\Observers;

use App\Models\Car;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CarObserver
{
    /**
     * Handle the Car "created" event.
     */
    public function created(Car $car)
    {
        try {
            $pageId = env('FACEBOOK_PAGE_ID');
            $pageToken = env('FACEBOOK_PAGE_TOKEN');

            if (!$pageId || !$pageToken) {
                Log::warning('Facebook post skipped — missing credentials.');
                return;
            }

            // --- Build the advert message ---
            $message = "🚗 New Car Listed on PURECAR!\n\n";
            $message .= "{$car->year} {$car->make} {$car->model}\n";
            $message .= "Price: £" . number_format($car->price, 2) . "\n\n";

            // --- Build the link to the advert ---
            $link = url("/car-for-sale/{$car->slug}");

       
            $makeTag     = $car->make ? '#' . Str::studly(Str::slug($car->make, '')) : '';
            $modelTag    = $car->model ? '#' . Str::studly(Str::slug($car->model, '')) : '';
            $locationTag = ($car->user && $car->user->location)
                ? '#' . Str::studly(Str::slug($car->user->location, ''))
                : '';
            $dealerTag   = ($car->user && $car->user->name)
                ? '#' . Str::studly(Str::slug($car->user->name, ''))
                : '';

        
            $hashtags = trim(implode(' ', array_filter([
                $makeTag,
                $modelTag,
                $locationTag,
                $dealerTag
            ])));

         
            $message .= "Check it out here 👇\n{$link}\n\n{$hashtags}";

            // --- Post to Facebook ---
            $response = Http::post("https://graph.facebook.com/v19.0/{$pageId}/feed", [
                'message' => $message,
                'link' => $link,
                'access_token' => $pageToken,
            ]);

            // --- Handle API response ---
            if ($response->failed()) {
                Log::error('❌ Failed to post car to Facebook', [
                    'car_id' => $car->car_id,
                    'response' => $response->json(),
                ]);
            } else {
                Log::info('✅ Car posted to Facebook successfully', [
                    'car_id' => $car->car_id,
                    'fb_response' => $response->json(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception while posting car to Facebook', [
                'car_id' => $car->car_id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
