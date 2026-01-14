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
class ProcessDealerFeedController extends Controller
{
    public function process($dealerId)
    {
        $feedSource = UserFeedSource::where('dealer_id', $dealerId)
                    ->where('source_type', 'feed')
                    ->where('is_active', true)
                    ->with('user')
                    ->first();
        if (!$feedSource) {
            return response()->json(['error' => 'Dealer feed not found'], 404);
        }
        $user = $feedSource->user;
        $url = $feedSource->dealer_feed_url;
        if (empty($url)) {
            return response()->json(['error' => 'Dealer feed URL not set'], 400);
        }
        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'Accept' => '*/*',
                    'User-Agent' => 'Mozilla/5.0 (compatible; FeedParser/1.0)'
                ])
                ->get($url);
            if (!$response->successful()) {
                Log::error("Failed to fetch feed for Dealer {$dealerId}. Status: {$response->status()}");
                return response()->json(['error' => "Failed to fetch feed for Dealer {$dealerId}"], 500);
            }
            $content = $response->body();
            
            // Detect if content is CSV or XML
            $feedType = $this->detectFeedType($content);
            if ($feedType === 'CSV') {
                return $this->processCSVFeed($content, $feedSource, $user, $dealerId);
            } elseif ($feedType === 'XML') {
                return $this->processXMLFeed($content, $feedSource, $user, $dealerId);
            } else {
                Log::error("Unknown feed format for dealer {$dealerId}. Content preview: " . substr($content, 0, 200));
                return response()->json(['error' => 'Unknown feed format (not CSV or XML)'], 422);
            }
            
        } catch (\Exception $e) {
            Log::error("Failed to fetch dealer feed for {$dealerId}: " . $e->getMessage());
            return response()->json(['error' => 'Error fetching data feed'], 500);
        }
    }
    private function detectFeedType($content)
    {
        $content = trim($content);
        
        // Remove BOM
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
        
        // Check for XML
        if (preg_match('/^\s*<\?xml/i', $content) || preg_match('/^\s*<[a-zA-Z]/', $content)) {
            return 'XML';
        }
        
        // Check for CSV (starts with quotes or common CSV headers)
        if (preg_match('/^"?[a-zA-Z0-9_-]+("?,|,)/', $content)) {
            return 'CSV';
        }
        
        return 'UNKNOWN';
    }
    private function processCSVFeed($content, $feedSource, $user, $dealerId)
    {
        try {
            DB::beginTransaction();
            $processed = 0;
            $skipped = 0;
            $markedAsSold = 0;
            $updated = 0;
            // Parse CSV
            $lines = str_getcsv($content, "\n");
            if (count($lines) < 2) {
                return response()->json(['error' => 'CSV feed is empty or invalid'], 422);
            }
            // Get headers (first line)
            $headers = str_getcsv(array_shift($lines));
            $headers = array_map('trim', $headers);
            // Collect vehicle IDs from feed
            $feedVehicleIds = [];
            $vehicles = [];
            foreach ($lines as $line) {
                if (empty(trim($line))) {
                    continue;
                }
                $data = str_getcsv($line);
                
                if (count($data) !== count($headers)) {
                    continue;
                }
                $vehicle = array_combine($headers, $data);
                $vehicles[] = $vehicle;
                $vehicleId = $vehicle['VehicleID'] ?? null;
                if ($vehicleId) {
                    $feedVehicleIds[] = $vehicleId;
                }
            }
            // Mark cars not in feed as sold
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
            // Process each vehicle
            foreach ($vehicles as $vehicle) {
                $stockId = $vehicle['VehicleID'] ?? null;
                $manufacturer = $vehicle['Make'] ?? null;
                $model = $vehicle['Model'] ?? null;
                if (empty($stockId) || empty($manufacturer) || empty($model)) {
                    $skipped++;
                    continue;
                }
                $existingCar = Car::where('vehicle_id', $stockId)
                                  ->where('feed_source_id', $feedSource->id)
                                  ->first();
                
                $customImageUrl = 'https://purecar.co.uk/assets/coming_soon.png';
                
                // Parse images
                $imagesString = $vehicle['Images'] ?? '';
                $imageUrls = array_filter(array_map('trim', explode(',', $imagesString)));
                $firstImageUrl = !empty($imageUrls) ? $imageUrls[0] : $customImageUrl;
                
                $description = $vehicle['Description'] ?? '';
                $fullDescription = trim($description);
                
                $price = !empty($vehicle['Price']) ? (float)$vehicle['Price'] : null;
                $mileage = !empty($vehicle['Mileage']) ? (int)$vehicle['Mileage'] : null;
                $year = !empty($vehicle['Year']) ? (int)$vehicle['Year'] : null;
                $vrm = $vehicle['Reg'] ?? '';
                $fuelType = $vehicle['Fuel'] ?? '';
                $transmission = $vehicle['Transmission'] ?? '';
                $bodyStyle = $vehicle['BodyStyle'] ?? '';
                $variant = $vehicle['Variant'] ?? '';
                $doors = !empty($vehicle['Doors']) ? (int)$vehicle['Doors'] : null;
                $seats = !empty($vehicle['Seats']) ? (int)$vehicle['Seats'] : null;
                $colour = $vehicle['Colour'] ?? '';
                $engineCC = !empty($vehicle['CC']) ? (int)$vehicle['CC'] : null;
                $bhp = !empty($vehicle['BHP']) ? (int)$vehicle['BHP'] : null;
                
                $engineSize = null;
                if ($engineCC) {
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
                    'seats' => $seats,
                    'colors' => $colour,
                    'advert_variant' => $variant,
                    'advert_colour' => $colour,
                    'license_plate' => $vrm,
                    'Bhp' => $bhp,
                    'Rpm' => null,
                    'gear_box' => $transmission,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $processed++;
            }
            DB::commit();
            return response()->json([
                'message' => "CSV feed processed for Dealer {$dealerId}",
                'processed' => $processed,
                'updated' => $updated,
                'skipped' => $skipped,
                'marked_as_sold' => $markedAsSold,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error processing CSV feed for dealer {$dealerId}: " . $e->getMessage());
            return response()->json(['error' => 'Error processing CSV feed: ' . $e->getMessage()], 500);
        }
    }
    private function processXMLFeed($content, $feedSource, $user, $dealerId)
    {
        try {
            // Clean XML content
            $content = $this->cleanXmlContent($content);
            
            libxml_use_internal_errors(true);
            
            $xml = simplexml_load_string(
                $content,
                'SimpleXMLElement',
                LIBXML_NOCDATA | LIBXML_NOBLANKS
            );
            
            if ($xml === false) {
                $errors = libxml_get_errors();
                libxml_clear_errors();
                Log::error("XML parsing failed for dealer {$dealerId}: " . json_encode($errors));
                return response()->json(['error' => 'Invalid XML format'], 422);
            }
            $namespaces = $xml->getNamespaces(true);
            $vehicles = $this->findVehicles($xml, $namespaces);
            
            if (count($vehicles) === 0) {
                return response()->json(['error' => 'No vehicles found in feed'], 422);
            }
            DB::beginTransaction();
            try {
                $processed = 0;
                $skipped = 0;
                $markedAsSold = 0;
                $updated = 0;
                $feedVehicleIds = [];
                foreach ($vehicles as $vehicle) {
                    $stockId = $this->getXmlValue($vehicle, 'identifiers/stockid');
                    if (!empty($stockId)) {
                        $feedVehicleIds[] = $stockId;
                    }
                }
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
                foreach ($vehicles as $vehicle) {
                    $stockId = $this->getXmlValue($vehicle, 'identifiers/stockid');
                    $manufacturer = $this->getXmlValue($vehicle, 'manufacturer');
                    $model = $this->getXmlValue($vehicle, 'model');
                    if (empty($stockId) || empty($manufacturer) || empty($model)) {
                        $skipped++;
                        continue;
                    }
                    $existingCar = Car::where('vehicle_id', $stockId)
                                      ->where('feed_source_id', $feedSource->id)
                                      ->first();
                    
                    $customImageUrl = 'https://purecar.co.uk/assets/coming_soon.png';
                    $imageUrls = $this->getImageUrls($vehicle, $customImageUrl);
                    $firstImageUrl = !empty($imageUrls) ? $imageUrls[0] : $customImageUrl;
                    
                    $description = $this->getXmlValue($vehicle, 'description');
                    $equipmentList = $this->getXmlValue($vehicle, 'equipmentlist');
                    $fullDescription = trim($description . "\n\n" . $equipmentList);
                    
                    $price = $this->getXmlValue($vehicle, 'price/current');
                    $mileage = $this->getXmlValue($vehicle, 'odometer/reading');
                    $year = $this->getXmlValue($vehicle, 'year');
                    $vrm = $this->getXmlValue($vehicle, 'identifiers/vrm');
                    $fuelType = $this->getXmlValue($vehicle, 'fueltype');
                    $transmission = $this->getXmlValue($vehicle, 'transmission');
                    $bodyStyle = $this->getXmlValue($vehicle, 'bodystyle');
                    $variant = $this->getXmlValue($vehicle, 'variant');
                    $doors = $this->getXmlValue($vehicle, 'doorcount');
                    $colour = $this->getXmlValue($vehicle, 'colours/exterior/manufacturer');
                    $engineCC = $this->getXmlValue($vehicle, 'engine/size/cc');
                    $engineLitre = $this->getXmlValue($vehicle, 'engine/size/litre');
                    
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
                    'message' => "XML feed processed for Dealer {$dealerId}",
                    'processed' => $processed,
                    'updated' => $updated,
                    'skipped' => $skipped,
                    'marked_as_sold' => $markedAsSold,
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Error processing XML feed for dealer {$dealerId}: " . $e->getMessage());
                return response()->json(['error' => 'Error processing XML feed: ' . $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            Log::error("Failed to process XML for dealer {$dealerId}: " . $e->getMessage());
            return response()->json(['error' => 'Error processing XML feed'], 500);
        }
    }
    private function cleanXmlContent($content)
    {
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
        return trim($content);
    }
    private function findVehicles($xml, $namespaces)
    {
        if (isset($xml->vehicle)) {
            return $xml->vehicle;
        }
        
        foreach ($namespaces as $prefix => $ns) {
            if ($prefix === '') continue;
            $xml->registerXPathNamespace($prefix, $ns);
            $vehicles = $xml->xpath("//{$prefix}:vehicle");
            if (!empty($vehicles)) return $vehicles;
        }
        
        $vehicles = $xml->xpath('//vehicle');
        return !empty($vehicles) ? $vehicles : [];
    }
    private function getXmlValue($element, $path)
    {
        $parts = explode('/', $path);
        $current = $element;
        
        foreach ($parts as $part) {
            if (!isset($current->$part)) {
                return null;
            }
            $current = $current->$part;
        }
        
        $value = (string)$current;
        return !empty($value) ? $value : null;
    }
    private function getImageUrls($vehicle, $defaultUrl)
    {
        $imageUrls = [];
        
        if (isset($vehicle->images)) {
            foreach ($vehicle->images as $imageNode) {
                $imageUrl = trim((string)$imageNode);
                if (!empty($imageUrl)) {
                    $imageUrls[] = $imageUrl;
                }
            }
        }
        
        return !empty($imageUrls) ? $imageUrls : [$defaultUrl];
    }
}