<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookCatalogService
{
    private $catalogId;
    private $accessToken;
    private $apiVersion = 'v23.0';
    
    public function __construct()
    {
        $this->catalogId = config('services.facebook.catalog_id');
        $this->accessToken = config('services.facebook.access_token');
    }
    
    /**
     * Sync a single car to Facebook Catalog
     */
    public function syncCar(Car $car)
    {
        try {
            // Load relationships
            $car->load(['advert', 'advert.user']);
            
            // Validate required data
            if (!$car->advert || !$car->advert->user) {
                Log::warning("Car {$car->car_id} missing advert or user relationship");
                return false;
            }
            
            $payload = $this->buildProductPayload($car);
            
            // Log the payload for debugging
            Log::info("Syncing car {$car->car_id} with payload", [
                'retailer_id' => $payload['retailer_id'],
                'url' => $payload['url'],
                'image_url' => $payload['image_url'],
                'price' => $payload['price'],
            ]);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
            ])->post(
                "https://graph.facebook.com/{$this->apiVersion}/{$this->catalogId}/products",
                $payload
            );
            
            if ($response->successful()) {
                Log::info("Successfully synced car {$car->car_id} to Facebook Catalog", [
                    'product_id' => $response->json('id')
                ]);
                return true;
            } else {
                Log::error("Failed to sync car {$car->car_id} to Facebook", [
                    'response' => $response->json(),
                    'status' => $response->status(),
                    'payload' => $payload
                ]);
                return false;
            }
            
        } catch (\Exception $e) {
            Log::error("Exception syncing car {$car->car_id}: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Build a valid product URL
     */
    private function buildProductUrl(Car $car)
    {
        // Ensure slug exists and is valid
        $slug = $car->slug;
        
        if (empty($slug)) {
            $slug = 'car-' . $car->car_id;
        }
        
        // Clean the slug - remove any invalid characters
        $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug));
        
        // Build full URL with proper protocol
        $baseUrl = config('app.url');
        
        // Ensure base URL has protocol
        if (!preg_match('/^https?:\/\//', $baseUrl)) {
            $baseUrl = 'https://' . $baseUrl;
        }
        
        // Remove trailing slash from base URL
        $baseUrl = rtrim($baseUrl, '/');
        
        return $baseUrl . '/car-for-sale/' . $slug;
    }

    /**
     * Build the product payload for Facebook
     */
    private function buildProductPayload(Car $car)
    {
        $advert = $car->advert;
        $user = $advert->user;
        
        // Build car name
        $carName = trim("{$car->make} {$car->model} {$car->year}");
        if (empty($carName)) {
            $carName = "Vehicle #{$car->car_id}";
        }
        
        // Build description
        $description = $this->buildDescription($car, $advert);
        
        // Build product URL - must be a valid, publicly accessible URL
        $productUrl = $this->buildProductUrl($car);
        
        // Get main image
        $imageUrl = $this->getMainImage($car, $advert);
        
        // Price as integer in cents/pence (Facebook requirement)
        // If your price is already in pence, use as is. If in pounds, multiply by 100
        $priceInPence = $car->price ? (int)($car->price * 100) : 0;
        
        // Determine availability
        $availability = ($advert->status === 'active') 
            ? 'in stock' 
            : 'out of stock';
        
        $payload = [
            'retailer_id' => "car_{$car->car_id}", // Unique identifier
            'name' => substr($carName, 0, 200), // Facebook limit
            'description' => substr($description, 0, 5000), // Facebook limit
            'url' => $productUrl,
            'image_url' => $imageUrl,
            'brand' => $car->make ?? 'Unknown',
            'price' => $priceInPence,
            'currency' => 'GBP', // Required separate currency field
            'availability' => $availability,
            'condition' => 'used', // Adjust if you have new cars
        ];
        
        // Add optional fields only if they have values
        if ($this->getAdditionalImages($car, $advert)) {
            $payload['additional_image_link'] = $this->getAdditionalImages($car, $advert);
        }
        
        if ($car->body_type) {
            $payload['vehicle_type'] = $car->body_type;
        }
        
        if ($car->year) {
            $payload['year'] = (string)$car->year;
        }
        
        if ($car->miles) {
            $payload['mileage'] = [
                'value' => (string)$car->miles,
                'unit' => 'mi'
            ];
        }
        
        if ($car->transmission_type) {
            $payload['transmission'] = $car->transmission_type;
        }
        
        if ($car->fuel_type) {
            $payload['fuel_type'] = $car->fuel_type;
        }
        
        if ($car->colors) {
            $payload['color'] = $car->colors;
        }
        
        if ($user && $user->location) {
            $payload['location'] = $user->location;
        }
        
        return $payload;
    }
    
    /**
     * Build comprehensive description
     */
    private function buildDescription(Car $car, $advert)
    {
        $parts = [];
        
        // Add advert description if available
        if (!empty($advert->description)) {
            $parts[] = $advert->description;
        }
        
        // Add key specifications
        $specs = [];
        if ($car->year) $specs[] = "Year: {$car->year}";
        if ($car->miles) $specs[] = "Mileage: " . number_format($car->miles) . " miles";
        if ($car->transmission_type) $specs[] = "Transmission: {$car->transmission_type}";
        if ($car->fuel_type) $specs[] = "Fuel: {$car->fuel_type}";
        if ($car->body_type) $specs[] = "Body: {$car->body_type}";
        if ($car->engine_size) $specs[] = "Engine: {$car->engine_size}";
        if ($car->doors) $specs[] = "Doors: {$car->doors}";
        if ($car->seats) $specs[] = "Seats: {$car->seats}";
        if ($car->colors) $specs[] = "Color: {$car->colors}";
        if ($car->owners) $specs[] = "Owners: {$car->owners}";
        
        if (!empty($specs)) {
            $parts[] = implode(' | ', $specs);
        }
        
        // Add location
        if ($advert->user && $advert->user->location) {
            $parts[] = "Location: {$advert->user->location}";
        }
        
        return implode("\n\n", array_filter($parts));
    }
    
    /**
     * Get main image URL
     */
    private function getMainImage(Car $car, $advert)
    {
        // Priority: car main_image > advert main_image > car image > advert image
        if (!empty($car->main_image)) {
            return $this->normalizeImageUrl($car->main_image);
        }
        
        if (!empty($advert->main_image)) {
            return $this->normalizeImageUrl($advert->main_image);
        }
        
        if (!empty($car->image)) {
            return $this->normalizeImageUrl($car->image);
        }
        
        if (!empty($advert->image)) {
            return $this->normalizeImageUrl($advert->image);
        }
        
        // Fallback placeholder
        return url('/images/placeholder-car.jpg');
    }
    
    /**
     * Get additional images (up to 10 additional per Facebook guidelines)
     */
    private function getAdditionalImages(Car $car, $advert)
    {
        $images = [];
        
        // Get images from advert_images relationship
        if ($advert->advert_images) {
            foreach ($advert->advert_images as $image) {
                if (!empty($image->image_url)) {
                    $images[] = $this->normalizeImageUrl($image->image_url);
                }
            }
        }
        
        // Limit to 10 additional images
        $images = array_slice($images, 0, 10);
        
        return !empty($images) ? implode(',', $images) : null;
    }
    
    /**
     * Normalize image URL to full URL
     */
    private function normalizeImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return null;
        }
        
        // If already a full URL, validate and return
        if (preg_match('/^https?:\/\//', $imagePath)) {
            // Remove any credentials from URL
            $imagePath = preg_replace('/\/\/[^@]+@/', '//', $imagePath);
            return $imagePath;
        }
        
        // Get base URL
        $baseUrl = config('app.url');
        
        // Ensure base URL has protocol
        if (!preg_match('/^https?:\/\//', $baseUrl)) {
            $baseUrl = 'https://' . $baseUrl;
        }
        
        // Remove trailing slash from base URL
        $baseUrl = rtrim($baseUrl, '/');
        
        // Clean image path
        $imagePath = '/' . ltrim($imagePath, '/');
        
        return $baseUrl . $imagePath;
    }
    
    /**
     * Sync all active cars
     */
    public function syncAllCars($limit = null)
    {
        $query = Car::with(['advert', 'advert.user'])
            ->whereHas('advert', function($q) {
                $q->whereIn('status', ['active', 'approved']);
            });
        
        if ($limit) {
            $query->limit($limit);
        }
        
        $cars = $query->get();
        
        $results = [
            'total' => $cars->count(),
            'success' => 0,
            'failed' => 0
        ];
        
        foreach ($cars as $car) {
            if ($this->syncCar($car)) {
                $results['success']++;
            } else {
                $results['failed']++;
            }
            
            // Add small delay to avoid rate limiting
            usleep(100000); // 0.1 second delay
        }
        
        return $results;
    }
    
    /**
     * Update a product in Facebook Catalog
     */
    public function updateCar(Car $car)
    {
        // Facebook uses the same endpoint for both create and update
        // It will update if the retailer_id already exists
        return $this->syncCar($car);
    }
    
    /**
     * Delete a product from Facebook Catalog
     */
    public function deleteCar(Car $car)
    {
        try {
            $retailerId = "car_{$car->car_id}";
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->accessToken,
            ])->delete(
                "https://graph.facebook.com/{$this->apiVersion}/{$this->catalogId}/products",
                ['retailer_id' => $retailerId]
            );
            
            if ($response->successful()) {
                Log::info("Successfully deleted car {$car->car_id} from Facebook Catalog");
                return true;
            } else {
                Log::error("Failed to delete car {$car->car_id} from Facebook", [
                    'response' => $response->json()
                ]);
                return false;
            }
            
        } catch (\Exception $e) {
            Log::error("Exception deleting car {$car->car_id}: " . $e->getMessage());
            return false;
        }
    }
}