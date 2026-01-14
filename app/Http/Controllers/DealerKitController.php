<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Models\Advert;
use App\Models\Advert_image;
use App\Models\UserFeedSource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DealerKitController extends Controller
{
    public function fetchVehicles($dealerId)
    {
        $feedSource = UserFeedSource::where('dealer_id', $dealerId)
                    ->where('source_type', 'api')
                    ->where('is_active', true)
                    ->with('user')
                    ->first();

        if (!$feedSource) {
            return response()->json(['error' => 'DealerKit feed source not found'], 404);
        }

        $user = $feedSource->user;

        $apiToken = env('DEALERKIT_API_TOKEN');
        if (!$apiToken) {
            return response()->json(['error' => 'API token not configured'], 500);
        }

        $baseUrl = 'https://api.dealerkit.uk/integrators/stock';
        
        $params = [
            'dealer_id' => $dealerId, 
            'page' => 1,
            'per_page' => 100
        ];
        
        $headers = ['Authorization' => "Bearer {$apiToken}"];
        $allVehicles = [];
        $processed = 0;
        $skipped = 0;
        $markedAsSold = 0;
        $updated = 0;

        try {
            $maxPages = 50;
            $currentPage = 1;
            
            while ($currentPage <= $maxPages) {
                $response = Http::withHeaders($headers)->retry(3, 1000)->get($baseUrl, $params);
                
                if (!$response->successful()) {
                    return response()->json([
                        'error' => 'Failed to fetch vehicles from API',
                        'status' => $response->status(),
                        'page' => $currentPage
                    ], 500);
                }

                $data = $response->json();
                $vehicles = $data['data'] ?? [];

                if (empty($vehicles)) {
                    break;
                }

                $allVehicles = array_merge($allVehicles, $vehicles);

                $hasMorePages = false;
                
                if (isset($data['next_page_url']) && $data['next_page_url']) {
                    $hasMorePages = true;
                }
                
                if (isset($data['meta'])) {
                    $meta = $data['meta'];
                    if (isset($meta['current_page']) && isset($meta['last_page'])) {
                        $hasMorePages = $meta['current_page'] < $meta['last_page'];
                    }
                }
                
                if (!$hasMorePages && count($vehicles) >= $params['per_page']) {
                    $hasMorePages = true;
                }
                
                if (isset($data['links']) && is_array($data['links'])) {
                    foreach ($data['links'] as $link) {
                        if (isset($link['rel']) && $link['rel'] === 'next' && $link['url']) {
                            $hasMorePages = true;
                            break;
                        }
                    }
                }

                if (!$hasMorePages) {
                    break;
                }

                $currentPage++;
                $params['page'] = $currentPage;
            }

            if (empty($allVehicles)) {
                return response()->json(['error' => 'No vehicles found in API response'], 422);
            }

            DB::beginTransaction();

            $feedVehicleIds = array_column($allVehicles, 'id');

            // CHANGED: Added feed_source_id filter
            if (count($allVehicles) > 0) {
                $activeCars = Car::where('feed_source_id', $feedSource->id)
                    ->whereIn('advert_id', function ($query) use ($user) {
                        $query->select('advert_id')
                              ->from('adverts')
                              ->where('user_id', $user->id)
                              ->where('status', '!=', 'sold');
                    })->get();

                $carsToMarkAsSold = [];
                
                foreach ($activeCars as $car) {
                    if (!in_array($car->vehicle_id, $feedVehicleIds, true)) {
                        $carsToMarkAsSold[] = [
                            'car_id' => $car->id,
                            'vehicle_id' => $car->vehicle_id,
                            'advert_id' => $car->advert_id,
                            'make' => $car->make,
                            'model' => $car->model
                        ];
                    }
                }

                foreach ($carsToMarkAsSold as $carInfo) {
                    try {
                        $advert = Advert::where('advert_id', $carInfo['advert_id'])->first();
                        if ($advert && $advert->status !== 'sold') {
                            $advert->update(['status' => 'sold']);
                            $markedAsSold++;
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            foreach ($allVehicles as $vehicleData) {
                $vehicle = $vehicleData['vehicle'] ?? [];
                if (empty($vehicleData['id']) || empty($vehicle['manufacturer']) || empty($vehicle['model'])) {
                    $skipped++;
                    continue;
                }

                // CHANGED: Added feed_source_id to the query
                $existingCar = Car::where('vehicle_id', $vehicleData['id'])
                                  ->where('feed_source_id', $feedSource->id)
                                  ->first();
                
                if ($existingCar) {
                    $existingAdvert = Advert::where('advert_id', $existingCar->advert_id)->first();
                    if ($existingAdvert) {
                        if ($existingAdvert->status === 'sold') {
                            $existingAdvert->update(['status' => 'active']);
                        }
                        
                        $newDescription = $vehicleData['advertising']['comments'] ?? null;
                        $customImageUrl = 'https://purecar.co.uk/assets/coming_soon.png';
                        $firstImageUrl = null;
                        
                        if (!empty($vehicleData['media']['cover_image']['url'])) {
                            $firstImageUrl = $vehicleData['media']['cover_image']['url'];
                        } elseif (!empty($vehicleData['media']['images']) && is_array($vehicleData['media']['images']) && !empty($vehicleData['media']['images'][0]['url'])) {
                            $firstImageUrl = $vehicleData['media']['images'][0]['url'];
                        }
                        
                        $mainImage = $firstImageUrl ?? $customImageUrl;
                        
                        $existingAdvert->update([
                            'description' => $newDescription,
                            'image' => $mainImage,
                            'main_image' => $mainImage,
                            'updated_at' => now()
                        ]);
                        
                        $existingCar->update([
                            'image' => $mainImage,
                            'main_image' => $mainImage,
                            'updated_at' => now()
                        ]);
                        
                        Advert_image::where('advert_id', $existingCar->advert_id)->delete();
                        
                        $images = $vehicleData['media']['images'] ?? [];
                        foreach ($images as $image) {
                            $imageUrl = $image['url'] ?? null;
                            if ($imageUrl) {
                                try {
                                    Advert_image::create([
                                        'advert_id' => $existingCar->advert_id,
                                        'image_url' => $imageUrl,
                                        'created_at' => now(),
                                        'updated_at' => now(),
                                    ]);
                                } catch (\Exception $imageException) {
                                    continue;
                                }
                            }
                        }
                        
                        $updated++;
                    }
                    continue;
                }

                $adExpiryDays = 365;
                $expiryDate = Carbon::now()->addDays($adExpiryDays)->format('Y-m-d');
                $customImageUrl = 'https://purecar.co.uk/assets/coming_soon.png';
                $firstImageUrl = null;
                
                if (!empty($vehicleData['media']['cover_image']['url'])) {
                    $firstImageUrl = $vehicleData['media']['cover_image']['url'];
                } elseif (!empty($vehicleData['media']['images']) && is_array($vehicleData['media']['images']) && !empty($vehicleData['media']['images'][0]['url'])) {
                    $firstImageUrl = $vehicleData['media']['images'][0]['url'];
                }

                $advertData = [
                    'user_id' => $user->id,
                    'name' => $vehicle['manufacturer'] . ' ' . $vehicle['model'],
                    'license_plate' => $vehicle['registration'] ?? null,
                    'miles' => $vehicle['mileage'] ?? null,
                    'engine' => $vehicle['engine_size'] ? round($vehicle['engine_size'], 1) . 'L' : '2L',
                    'owner' => $vehicleData['owners'] ?? 1,
                    'description' => $vehicleData['advertising']['comments'] ?? null,
                    'expiry_date' => $expiryDate,
                    'status' => 'active',
                    'image' => $firstImageUrl ?? $customImageUrl,
                    'main_image' => $firstImageUrl ?? $customImageUrl,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                try {
                    $advert = Advert::create($advertData);
                    if (!$advert || !$advert->advert_id) {
                        $skipped++;
                        continue;
                    }

                    $images = $vehicleData['media']['images'] ?? [];
                    foreach ($images as $image) {
                        $imageUrl = $image['url'] ?? null;
                        if ($imageUrl) {
                            try {
                                Advert_image::create([
                                    'advert_id' => $advert->advert_id,
                                    'image_url' => $imageUrl,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            } catch (\Exception $imageException) {
                                continue;
                            }
                        }
                    }

                    // CHANGED: Added feed_source_id field
                    $carDataRecord = [
                        'advert_id' => $advert->advert_id,
                        'vehicle_id' => $vehicleData['id'],
                        'feed_source_id' => $feedSource->id,
                        'model' => $vehicle['model'] ?? null,
                        'make' => $vehicle['manufacturer'] ?? null,
                        'fuel_type' => $vehicle['fuel_type'] ?? null,
                        'transmission_type' => $vehicle['transmission_type'] ?? 'N/A',
                        'body_type' => $vehicle['body_type'] ?? 'N/A',
                        'variant' => $vehicle['derivative'] ?? null,
                        'keyword' => '',
                        'price' => $vehicleData['prices']['cash']['amount'] ?? null,
                        'year' => $vehicle['year'] ?? null,
                        'seller_type' => $user->role,
                        'image' => $firstImageUrl ?? $customImageUrl,
                        'main_image' => $firstImageUrl ?? $customImageUrl,
                        'miles' => $vehicle['mileage'] ?? null,
                        'engine_size' => (isset($vehicle['engine_size']) && is_numeric($vehicle['engine_size'])) 
                                ? round($vehicle['engine_size'] / 1000, 1) . 'L' 
                                : null,
                        'doors' => $vehicle['number_of_doors'] ?? null,
                        'seats' => $vehicle['number_of_seats'] ?? null,
                        'colors' => $vehicle['colour'] ?? null,
                        'advert_variant'=> $vehicle['derivative'] ?? null,
                        'advert_colour' => $vehicle['colour'] ?? null,
                        'license_plate' => $vehicle['registration'] ?? null,
                        'Bhp' => $vehicle['bhp'] ?? null,
                        'Rpm' => $vehicle['torque_rpm'] ?? null,
                        'RigidArtic' => null,
                        'BodyShape' => $vehicle['body_type'] ?? null,
                        'NumberOfAxles' => null,
                        'FuelTankCapacity' => $vehicle['fuel_tank_capacity_litres'] ?? null,
                        'FuelCatalyst' => null,
                        'Aspiration' => $vehicle['camshaft'] ?? null,
                        'FuelSystem' => null,
                        'FuelDelivery' => null,
                        'NumberOfCylinders' => $vehicle['cylinders'] ?? null,
                        'gear_box' => $vehicle['transmission_type'] ?? 'N/A',
                        'DriveType' => $vehicle['drive_train'] ?? null,
                        'Range' => $vehicle['battery_range_miles'] ?? null,
                        'Trim' => $vehicle['trim'] ?? null,
                        'Scrapped' => 0,
                        'Imported' => 0,
                        'ExtraUrban' => 0,
                        'UrbanCold' => 0,
                        'Combined' => $vehicle['mpg_combined'] ?? 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    try {
                        $car = Car::create($carDataRecord);
                        if (!$car || !$car->id) {
                            $skipped++;
                            continue;
                        }
                        $processed++;
                    } catch (\Exception $carException) {
                        $skipped++;
                        continue;
                    }
                } catch (\Exception $advertException) {
                    $skipped++;
                    continue;
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'All vehicles processed successfully',
                'total_vehicles_fetched' => count($allVehicles),
                'processed' => $processed,
                'updated' => $updated,
                'skipped' => $skipped,
                'marked_as_sold' => $markedAsSold,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'error' => 'Error processing API data',
                'message' => env('APP_DEBUG', false) ? $e->getMessage() : 'An unexpected error occurred'
            ], 500);
        }
    }
}