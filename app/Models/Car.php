<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\NormalizationRule;
use App\Observers\CarObserver; 

class Car extends Model
{
    protected $table = 'cars';
    protected $primaryKey = 'car_id';
    
    protected $fillable = [
        'advert_id',
        'vehicle_id',
        'dealer_id',
        'model',
        'original_model',
        'make',
        'original_make',
        'fuel_type',
        'original_fuel_type',
        'transmission_type',
        'original_transmission_type',
        'body_type',
        'original_body_type',
        'variant',
        'original_variant',
        'keyword',
        'price',
        'year',
        'seller_type',
        'image',
        'main_image',
        'miles',
        'engine_size',
        'original_engine_size',
        'doors',
        'original_doors',
        'seats',
        'original_seats',
        'colors',
        'original_colors',
        'gear_box',
        'original_gear_box',
        'license_plate',
        'Rpm',
        'RigidArtic',
        'BodyShape',
        'NumberOfAxles',
        'FuelTankCapacity',
        'GrossVehicleWeight',
        'FuelCatalyst',
        'Aspiration',
        'FuelSystem',
        'FuelDelivery',
        'Bhp',
        'Kph',
        'Transmission',
        'EngineCapacity',
        'NumberOfCylinders',
        'DriveType',
        'Trim',
        'Range',
        'Scrapped',
        'Imported',
        'ExtraUrban',
        'UrbanCold',
        'Combined',
        'registered',
        'origin',
        'owners',
        'slug',
        'advert_variant',
        'advert_colour',
        'posted_to_facebook',
        'feed_source_id'
    ];

    public function advert()
    {
        return $this->belongsTo(Advert::class, 'advert_id', 'advert_id');
    }

    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Advert::class,
            'advert_id',
            'id',
            'advert_id',
            'user_id'
        );
    }

    public function advert_images()
    {
        return $this->hasManyThrough(
            Advert_image::class,
            Advert::class,
            'advert_id',
            'advert_id',
            'advert_id',
            'advert_id'
        );
    }

    /**
     * Boot model events + observer
     */
    protected static function boot()
    {
        parent::boot();

        // ✅ Register your Facebook observer
        // static::observe(CarObserver::class);

        // --- Slug generation ---
        static::creating(function ($car) {
            try {
                $car->slug = static::generateSlug($car);
            } catch (\Exception $e) {
                \Log::error('Error generating slug for car: ' . $e->getMessage(), [
                    'car_data' => $car->toArray()
                ]);
                $car->slug = 'car-' . uniqid();
            }
        });

        // --- Slug update logic ---
        static::updating(function ($car) {
            if ($car->isDirty('make') || $car->isDirty('model') || $car->isDirty('year')) {
                try {
                    $car->slug = static::generateSlug($car);
                } catch (\Exception $e) {
                    \Log::error('Error updating slug for car: ' . $e->getMessage());
                }
            }
        });

        // --- Normalization logic ---
        static::saving(function ($car) {
            $categories = [
                'model', 'make', 'fuel_type', 'transmission_type', 'body_type',
                'variant', 'colors', 'gear_box', 'Transmission','doors','engine_size'
            ];

            foreach ($categories as $cat) {
                if ($car->$cat !== null) {
                    $mappings = NormalizationRule::getMappings($cat);
                    $raw = strtolower(trim($car->$cat)); 
                    if (array_key_exists($raw, $mappings)) {
                        $car->$cat = $mappings[$raw] ?? null; 
                    }
                }
            }
        });
    }

    // protected static function generateSlug($car)
    // {
    //     $make = !empty($car->make) ? Str::slug($car->make) : 'make-' . rand(1000, 9999);
    //     $model = !empty($car->model) ? Str::slug($car->model) : 'model-' . rand(1000, 9999);
    //     $year = !empty($car->year) ? $car->year : rand(2000, 2024);
        
    //     $baseSlug = "{$make}-{$model}-{$year}";
    //     $baseSlug = substr($baseSlug, 0, 200);

    //     $count = 1;
    //     $originalSlug = $baseSlug;
        
    //     while (static::where('slug', $baseSlug)
    //            ->where('car_id', '!=', $car->car_id ?? 0)
    //            ->exists()) {
    //         $baseSlug = $originalSlug . '-' . $count;
    //         $count++;
    //         if ($count > 1000) {
    //             $baseSlug = $originalSlug . '-' . uniqid();
    //             break;
    //         }
    //     }
        
    //     return $baseSlug;
    // }

    protected static function generateSlug($car)
{
    $make = !empty($car->make) ? Str::slug($car->make) : 'make-' . rand(1000, 9999);
    $model = !empty($car->model) ? Str::slug($car->model) : 'model-' . rand(1000, 9999);
    $year = !empty($car->year) ? $car->year : rand(2000, 2024);

    // ✅ Fetch user location via the advert relationship (if available)
    $userLocation = null;
    try {
        if ($car->advert && $car->advert->user) {
            $userLocation = $car->advert->user->location ?? null;
        }
    } catch (\Exception $e) {
        \Log::error('Error fetching user location for slug: ' . $e->getMessage());
    }

  
    $userLocation = $userLocation ? Str::slug($userLocation) : 'unknown-location';

  
    $baseSlug = "{$make}-{$model}-{$year}-northern-ireland-{$userLocation}";
    $baseSlug = substr($baseSlug, 0, 200);

  
    $count = 1;
    $originalSlug = $baseSlug;

    while (static::where('slug', $baseSlug)
        ->where('car_id', '!=', $car->car_id ?? 0)
        ->exists()) {
        $baseSlug = $originalSlug . '-' . $count;
        $count++;
        if ($count > 1000) {
            $baseSlug = $originalSlug . '-' . uniqid();
            break;
        }
    }

    return $baseSlug;
}

}
