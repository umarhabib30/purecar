<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Models\Advert;
use App\Models\Advert_image;
use App\Models\UserFeedSource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProcessMazdaDealerFeedController extends Controller
{
    public function process($dealerId)
    {
        $feedSource = UserFeedSource::where('dealer_id', $dealerId)
                    ->where('source_type', 'mazda')
                    ->where('is_active', true)
                    ->with('user')
                    ->first();

        if (!$feedSource) {
            return response()->json(['error' => 'Mazda dealer not found'], 404);
        }

        $user = $feedSource->user;
        $url = $feedSource->dealer_feed_url;

        if (empty($url)) {
            return response()->json(['error' => 'Mazda dealer feed URL not set'], 400);
        }

        try {
            $response = Http::timeout(60)->get($url);

            if (!$response->successful()) {
                return response()->json(['error' => "Failed to fetch Mazda feed for Dealer {$dealerId}"], 500);
            }

            $xmlContent = $response->body();
            
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($xmlContent);
            
            if ($xml === false) {
                $errors = libxml_get_errors();
                libxml_clear_errors();
                Log::error("XML parsing failed for dealer {$dealerId}: " . json_encode($errors));
                return response()->json(['error' => 'Invalid XML format'], 422);
            }

            if (!isset($xml->vehicle) || count($xml->vehicle) === 0) {
                return response()->json(['error' => 'No vehicles found in feed'], 422);
            }

            DB::beginTransaction();
            try {
                $processed = 0;
                $skipped = 0;
                $markedAsSold = 0;
                $updated = 0;

                $feedVehicleIds = [];
                foreach ($xml->vehicle as $vehicle) {
                    if (!empty((string)$vehicle->identifiers->stockid)) {
                        $feedVehicleIds[] = (string)$vehicle->identifiers->stockid;
                    }
                }

                // CHANGED: Added feed_source_id filter
                $carsNotInFeed = Car::where('feed_source_id', $feedSource->id)
                    ->whereHas('advert', function ($query) use ($user) {
                        $query->where('user_id', $user->id)->where('status', '!=', 'sold');
                    })
                    ->whereNotIn('vehicle_id', $feedVehicleIds)
                    ->get();

                foreach ($carsNotInFeed as $car) {
                    $advert = Advert::where('advert_id', $car->advert_id)->first();
                    if ($advert) {
                        $advert->update(['status' => 'sold']);
                        $markedAsSold++;
                    }
                }

                foreach ($xml->vehicle as $vehicle) {
                    $stockId = (string)$vehicle->identifiers->stockid;
                    $manufacturer = (string)$vehicle->manufacturer;
                    $model = (string)$vehicle->model;

                    if (empty($stockId) || empty($manufacturer) || empty($model)) {
                        $skipped++;
                        continue;
                    }

                    // CHANGED: Added feed_source_id to the query
                    $existingCar = Car::where('vehicle_id', $stockId)
                                      ->where('feed_source_id', $feedSource->id)
                                      ->first();
                    
                    $customImageUrl = 'https://purecar.co.uk/assets/coming_soon.png';
                    
                    $imageUrls = [];
                    if (isset($vehicle->images)) {
                        foreach ($vehicle->images as $imageNode) {
                            $imageUrl = trim((string)$imageNode);
                            if (!empty($imageUrl)) {
                                $imageUrls[] = $imageUrl;
                            }
                        }
                    }
                    
                    $firstImageUrl = !empty($imageUrls) ? $imageUrls[0] : $customImageUrl;
                    
                    $description = (string)$vehicle->description;
                    $equipmentList = (string)$vehicle->equipmentlist;
                    $fullDescription = trim($description . "\n\n" . $equipmentList);
                    
                    $price = !empty((string)$vehicle->price->current) ? (float)$vehicle->price->current : null;
                    $mileage = !empty((string)$vehicle->odometer->reading) ? (int)$vehicle->odometer->reading : null;
                    $year = !empty((string)$vehicle->year) ? (int)$vehicle->year : null;
                    $vrm = (string)$vehicle->identifiers->vrm;
                    $fuelType = (string)$vehicle->fueltype;
                    $transmission = (string)$vehicle->transmission;
                    $bodyStyle = (string)$vehicle->bodystyle;
                    $variant = (string)$vehicle->variant;
                    $doors = !empty((string)$vehicle->doorcount) ? (int)$vehicle->doorcount : null;
                    $colour = (string)$vehicle->colours->exterior->manufacturer;
                    $engineCC = !empty((string)$vehicle->engine->size->cc) ? (int)$vehicle->engine->size->cc : null;
                    $engineLitre = !empty((string)$vehicle->engine->size->litre) ? (float)$vehicle->engine->size->litre : null;
                    
                    $engineSize = null;
                    if ($engineLitre) {
                        $engineSize = $engineLitre . 'L';
                    } elseif ($engineCC) {
                        $engineSize = round($engineCC / 1000, 1) . 'L';
                    }

                    if ($existingCar) {
                        $existingAdvert = Advert::where('advert_id', $existingCar->advert_id)->first();
                        if ($existingAdvert) {
                            if ($existingAdvert->status === 'sold') {
                                $existingAdvert->update(['status' => 'active']);
                            }
                            
                            $existingAdvert->update([
                                'description' => $fullDescription,
                                'image' => $firstImageUrl,
                                'main_image' => $firstImageUrl,
                                'miles' => $mileage,
                                'updated_at' => now()
                            ]);
                            
                            $existingCar->update([
                                'price' => $price,
                                'miles' => $mileage,
                                'image' => $firstImageUrl,
                                'main_image' => $firstImageUrl,
                                'updated_at' => now()
                            ]);
                            
                            Advert_image::where('advert_id', $existingCar->advert_id)->delete();
                            
                            if (!empty($imageUrls)) {
                                foreach ($imageUrls as $imageUrl) {
                                    Advert_image::create([
                                        'advert_id' => $existingCar->advert_id,
                                        'image_url' => $imageUrl,
                                        'created_at' => now(),
                                        'updated_at' => now()
                                    ]);
                                }
                            }
                            
                            $updated++;
                        }
                        continue;
                    }

                    $expiryDate = Carbon::now()->addDays(365);

                    $advert = Advert::create([
                        'user_id' => $user->id,
                        'name' => "{$manufacturer} {$model}",
                        'license_plate' => $vrm,
                        'miles' => $mileage,
                        'description' => $fullDescription,
                        'expiry_date' => $expiryDate,
                        'status' => 'active',
                        'image' => $firstImageUrl,
                        'main_image' => $firstImageUrl,
                        'owner' => '1'
                    ]);

                    if (!$advert) {
                        $skipped++;
                        continue;
                    }

                    if (!empty($imageUrls)) {
                        foreach ($imageUrls as $imageUrl) {
                            Advert_image::create([
                                'advert_id' => $advert->advert_id,
                                'image_url' => $imageUrl,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }

                    // CHANGED: Added feed_source_id field
                    Car::create([
                        'advert_id' => $advert->advert_id,
                        'vehicle_id' => $stockId,
                        'feed_source_id' => $feedSource->id,
                        'model' => $model,
                        'make' => $manufacturer,
                        'fuel_type' => $fuelType,
                        'transmission_type' => $transmission,
                        'body_type' => $bodyStyle,
                        'variant' => $variant,
                        'keyword' => '',
                        'price' => $price,
                        'year' => $year,
                        'seller_type' => $user->role,
                        'image' => $firstImageUrl,
                        'main_image' => $firstImageUrl,
                        'miles' => $mileage,
                        'engine_size' => $engineSize,
                        'doors' => $doors,
                        'seats' => null,
                        'colors' => $colour,
                        'advert_variant' => $variant,
                        'advert_colour' => $colour,
                        'license_plate' => $vrm,
                        'Bhp' => null,
                        'Rpm' => null,
                        'gear_box' => $transmission,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $processed++;
                }

                DB::commit();

                return response()->json([
                    'message' => "Mazda feed processed for Dealer {$dealerId}",
                    'processed' => $processed,
                    'updated' => $updated,
                    'skipped' => $skipped,
                    'marked_as_sold' => $markedAsSold,
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Error processing Mazda feed for dealer {$dealerId}: " . $e->getMessage());
                return response()->json(['error' => 'Error processing Mazda data feed: ' . $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            Log::error("Failed to fetch Mazda dealer feed for {$dealerId}: " . $e->getMessage());
            return response()->json(['error' => 'Error fetching Mazda data feed'], 500);
        }
    }
}