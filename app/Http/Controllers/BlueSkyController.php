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

class BlueSkyController extends Controller
{
    public function fetchVehicles($dealerId)
    {
        $feedSource = UserFeedSource::where('dealer_id', $dealerId)
                    ->where('source_type', 'bluesky')
                    ->where('is_active', true)
                    ->with('user')
                    ->first();

        if (!$feedSource) {
            return response()->json(['error' => 'BlueSky feed source not found'], 404);
        }

        $user = $feedSource->user;
        $apiKey = $feedSource->api_key;
        
        if (!$apiKey) {
            return response()->json(['error' => 'BlueSky API token not configured'], 500);
        }

        $url = "https://api.blueskyinteractive.co.uk/api/v1/vehicles/{$dealerId}";
        
        $headers = ['Authorization' => $apiKey];
    
        $allVehicles = [];
        $processed = 0;
        $skipped = 0;
        $markedAsSold = 0;

        try {
            $response = Http::withHeaders($headers)->retry(3, 1000)->get($url);
            
            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Failed to fetch vehicles from BlueSky API',
                    'status' => $response->status()
                ], 500);
            }

            $data = $response->json();
            $vehicles = $data['Data'] ?? [];

            if (empty($vehicles)) {
                return response()->json(['error' => 'No vehicles found in BlueSky API response'], 422);
            }

            $allVehicles = $vehicles;

            DB::beginTransaction();

            $feedVehicleIds = array_column($allVehicles, 'UniqueId');

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
                if (empty($vehicleData['UniqueId']) || empty($vehicleData['Manufacturer']) || empty($vehicleData['Model'])) {
                    $skipped++;
                    continue;
                }

                // CHANGED: Added feed_source_id to the query
                $existingCar = Car::where('vehicle_id', $vehicleData['UniqueId'])
                                  ->where('feed_source_id', $feedSource->id)
                                  ->first();
                
                if ($existingCar) {
                    $existingAdvert = Advert::where('advert_id', $existingCar->advert_id)->first();
                    if ($existingAdvert) {
                        if ($existingAdvert->status === 'sold') {
                            $existingAdvert->update(['status' => 'active']);
                        }
                        $existingAdvert->touch();
                    }
                    $skipped++;
                    continue;
                }

                $adExpiryDays = 365;
                $expiryDate = Carbon::now()->addDays($adExpiryDays)->format('Y-m-d');
                $customImageUrl = 'https://purecar.co.uk/assets/coming_soon.png';
                
                $imagesStr = $vehicleData['Images'] ?? '';
                $images = array_filter(array_map('trim', explode(',', $imagesStr)));
                $firstImageUrl = !empty($images[0]) ? $images[0] : null;

                $advertData = [
                    'user_id' => $user->id,
                    'name' => $vehicleData['Manufacturer'] . ' ' . $vehicleData['Model'],
                    'license_plate' => $vehicleData['VRM'] ?? null,
                    'miles' => $vehicleData['Mileage'] ?? null,
                    'engine' => isset($vehicleData['EngineSize']) ? round($vehicleData['EngineSize'] / 1000, 1) . 'L' : '2L',
                    'owner' => $vehicleData['PreviousOwners'] ?? 1,
                    'description' => $vehicleData['Notes'] ?? null,
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

                    foreach ($images as $imageUrl) {
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
                        'vehicle_id' => $vehicleData['UniqueId'],
                        'feed_source_id' => $feedSource->id,
                        'model' => $vehicleData['Model'] ?? null,
                        'make' => $vehicleData['Manufacturer'] ?? null,
                        'fuel_type' => $vehicleData['FuelType'] ?? null,
                        'transmission_type' => $vehicleData['Transmission'] ?? 'N/A',
                        'body_type' => $vehicleData['BodyType'] ?? 'N/A',
                        'variant' => $vehicleData['Version'] ?? null,
                        'keyword' => '',
                        'price' => $vehicleData['Price'] ?? null,
                        'year' => $vehicleData['YearOfRegistration'] ?? null,
                        'seller_type' => $user->role,
                        'image' => $firstImageUrl ?? $customImageUrl,
                        'main_image' => $firstImageUrl ?? $customImageUrl,
                        'miles' => $vehicleData['Mileage'] ?? null,
                        'engine_size' => isset($vehicleData['EngineSize']) && is_numeric($vehicleData['EngineSize']) 
                                ? round($vehicleData['EngineSize'] / 1000, 1) . 'L' 
                                : null,
                        'doors' => $vehicleData['Doors'] ?? null,
                        'seats' => $vehicleData['Seats'] ?? null,
                        'colors' => $vehicleData['Colour'] ?? null,
                        'advert_variant' => $vehicleData['Version'] ?? null,
                        'advert_colour' => $vehicleData['Colour'] ?? null,
                        'license_plate' => $vehicleData['VRM'] ?? null,
                        'Bhp' => $vehicleData['BHP'] ?? null,
                        'Rpm' => $vehicleData['RPM'] ?? null,
                        'RigidArtic' => null,
                        'BodyShape' => $vehicleData['BodyType'] ?? null,
                        'NumberOfAxles' => null,
                        'FuelTankCapacity' => null,
                        'FuelCatalyst' => null,
                        'Aspiration' => $vehicleData['Aspiration'] ?? null,
                        'FuelSystem' => null,
                        'FuelDelivery' => $vehicleData['FuelDelivery'] ?? null,
                        'NumberOfCylinders' => $vehicleData['Cylinders'] ?? null,
                        'gear_box' => $vehicleData['Transmission'] ?? 'N/A',
                        'DriveType' => $vehicleData['DriveType'] ?? null,
                        'Range' => null,
                        'Trim' => null,
                        'Scrapped' => 0,
                        'Imported' => 0,
                        'ExtraUrban' =>  0,
                        'UrbanCold' =>  0,
                        'Combined' =>  0,
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
                'message' => 'All BlueSky vehicles processed successfully',
                'total_vehicles_fetched' => count($allVehicles),
                'processed' => $processed,
                'skipped' => $skipped,
                'marked_as_sold' => $markedAsSold,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'error' => 'Error processing BlueSky API data',
                'message' => env('APP_DEBUG', false) ? $e->getMessage() : 'An unexpected error occurred'
            ], 500);
        }
    }
}