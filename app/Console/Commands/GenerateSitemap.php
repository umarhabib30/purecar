<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\{Blog, Car, ForumPost, Advert, Event, User, Business};
use Illuminate\Support\Facades\DB;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--limit=15000 : Limit number of dynamic URLs to prevent memory issues}';
    protected $description = 'Generate the sitemap for the website';

    public function handle()
    {
        $sitemap = Sitemap::create();
        $baseUrl = config('app.url');
        $limit = (int) $this->option('limit');

        $staticPages = [
            ['url' => '', 'priority' => 1.0],
            ['url' => 'blogs', 'priority' => 0.9],
            ['url' => 'faqs', 'priority' => 0.7],
            ['url' => 'contactus', 'priority' => 0.6],
            ['url' => 'forum', 'priority' => 0.5],
            ['url' => 'privacy-policy', 'priority' => 0.4],
            ['url' => 'terms-and-conditions', 'priority' => 0.3],
            ['url' => 'refund-policy', 'priority' => 0.2],
            ['url' => 'pricing', 'priority' => 0.1],
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create($baseUrl . $page['url'])
                    ->setPriority($page['priority'])
                    ->setChangeFrequency('weekly')
                    ->setLastModificationDate(now())
            );
        }

        // Blogs
        $blogs = Blog::all();
        foreach ($blogs as $blog) {
            $sitemap->add(Url::create($baseUrl . "blog/{$blog->slug}")
                ->setLastModificationDate($blog->updated_at)
                ->setPriority(0.8)
                ->setChangeFrequency('weekly'));
        }

        // Cars
        $cars = Car::join('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
        ->where('adverts.status', 'active')
        ->select('cars.*') // ensure only car fields are selected
        ->get();
        foreach ($cars as $car) {
            $sitemap->add(Url::create($baseUrl . "car-for-sale/{$car->slug}")
                ->setLastModificationDate($car->updated_at)
                ->setPriority(0.7)
                ->setChangeFrequency('weekly'));
        }

        // Forum Posts
        $forumPosts = ForumPost::all();
        foreach ($forumPosts as $post) {
            $sitemap->add(Url::create($baseUrl . "forum/{$post->slug}")
                ->setLastModificationDate($post->updated_at)
                ->setPriority(0.7)
                ->setChangeFrequency('weekly'));
        }

        // Events
        $eventPosts = Event::all();
        foreach ($eventPosts as $post) {
            $sitemap->add(Url::create($baseUrl . "event-details/{$post->slug}")
                ->setLastModificationDate($post->updated_at)
                ->setPriority(0.7)
                ->setChangeFrequency('weekly'));
        }

        // Dealer Profiles
        $dealerprofiles = User::where('role', 'car_dealer')->get();
        foreach ($dealerprofiles as $profile) {
            $sitemap->add(Url::create($baseUrl . "dealer-profile/{$profile->slug}")
                ->setLastModificationDate(now())
                ->setPriority(0.7)
                ->setChangeFrequency('weekly'));
        }

        // Local business
        // $businesses = Business::all();
        // foreach ($businesses as $business) {
        //     $sitemap->add(Url::create($baseUrl . "business-listings/{$business->businessLocation->slug}/{$business->businessType->slug}/{$business->slug}")
        //         ->setLastModificationDate(now())
        //         ->setPriority(0.7)
        //         ->setChangeFrequency('weekly'));
        // }

        $this->info('Generating dynamic SEO URLs...');
        $this->generateDynamicSeoUrls($sitemap, $baseUrl, $limit);

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap generated successfully!');
    }

    private function generateDynamicSeoUrls($sitemap, $baseUrl, $limit)
    {
        $urlCount = 0;
        $duplicateCheck = [];

        
        $mainPageCount = $this->getCarCountForFilters([]);
        if ($mainPageCount > 0) {
            $this->addUrlIfUnique($sitemap, $baseUrl, 'cars-for-sale', $duplicateCheck, $urlCount, 0.9);
        }

 
        // $locationsWithCars = $this->getLocationsWithCars();
        // foreach ($locationsWithCars as $locationData) {
        //     if ($urlCount >= $limit) break;
        //     $location = $locationData->location;
        //     $url = 'cars-for-sale/' . $this->slugify($location);
        //     if ($this->getCarCountForFilters(['location' => $location]) > 0) {
        //         $this->addUrlIfUnique($sitemap, $baseUrl, $url, $duplicateCheck, $urlCount, 0.8);
        //     }
        // }

     
        $makeLocationCombos = $this->getMakeLocationCombinations();
        foreach ($makeLocationCombos as $combo) {
            if ($urlCount >= $limit) break;
            $url = 'cars-for-sale/' . $this->slugify($combo->make) . '/' . $this->slugify($combo->location);
            if ($this->getCarCountForFilters(['make' => $combo->make, 'location' => $combo->location]) > 0) {
                $this->addUrlIfUnique($sitemap, $baseUrl, $url, $duplicateCheck, $urlCount, 0.7);
            }
        }
        // $makeModelCombos = $this->getMakeModelCombinations();
        // foreach ($makeModelCombos as $combo) {
        //     if ($urlCount >= $limit) break;
        //     $url = 'cars-for-sale/' . $this->slugify($combo->make) . '/' . $this->slugify($combo->model);
        //     if ($this->getCarCountForFilters(['make' => $combo->make, 'model' => $combo->model]) > 0) {
        //         $this->addUrlIfUnique($sitemap, $baseUrl, $url, $duplicateCheck, $urlCount, 0.8);
        //     }
        // }

       
        $makeModelLocationCombos = $this->getMakeModelLocationCombinations();
        foreach ($makeModelLocationCombos as $combo) {
            if ($urlCount >= $limit) break;
            $url = 'cars-for-sale/' . $this->slugify($combo->make) . '/' . $this->slugify($combo->model) . '/' . $this->slugify($combo->location);
            if ($this->getCarCountForFilters(['make' => $combo->make, 'model' => $combo->model, 'location' => $combo->location]) > 0) {
                $this->addUrlIfUnique($sitemap, $baseUrl, $url, $duplicateCheck, $urlCount, 0.8);
            }
        }

   
        // $makeModelYearLocationCombos = $this->getMakeModelYearLocationCombinations();
        // foreach ($makeModelYearLocationCombos as $combo) {
        //     if ($urlCount >= $limit) break;
        //     $url = 'cars-for-sale/' . $this->slugify($combo->make) . '/' . $this->slugify($combo->model) . '/year-' . $combo->year . '/' . $this->slugify($combo->location);
        //     if ($this->getCarCountForFilters(['make' => $combo->make, 'model' => $combo->model, 'year' => $combo->year, 'location' => $combo->location]) > 0) {
        //         $this->addUrlIfUnique($sitemap, $baseUrl, $url, $duplicateCheck, $urlCount, 0.8);
        //     }
        // }

  
        // $makeModelPriceCombos = $this->getMakeModelPriceCombinations();
        // foreach ($makeModelPriceCombos as $combo) {
        //     if ($urlCount >= $limit) break;
        //     $url = 'cars-for-sale/' . $this->slugify($combo->make) . '/' . $this->slugify($combo->model) . '/under-' . $combo->max_price;
        //     if ($this->getCarCountForFilters(['make' => $combo->make, 'model' => $combo->model, 'price_max' => $combo->max_price]) > 0) {
        //         $this->addUrlIfUnique($sitemap, $baseUrl, $url, $duplicateCheck, $urlCount, 0.7);
        //     }
        // }

        
        $fuelLocationCombos = $this->getFuelTypeLocationCombinations();
        foreach ($fuelLocationCombos as $combo) {
            if ($urlCount >= $limit) break;
            $url = 'cars-for-sale/fuel/' . $this->slugify($combo->fuel_type) . '/' . $this->slugify($combo->location);
            if ($this->getCarCountForFilters(['fuel_type' => $combo->fuel_type, 'location' => $combo->location]) > 0) {
                $this->addUrlIfUnique($sitemap, $baseUrl, $url, $duplicateCheck, $urlCount, 0.6);
            }
        }

    
        $transmissionLocationCombos = $this->getTransmissionLocationCombinations();
        foreach ($transmissionLocationCombos as $combo) {
            if ($urlCount >= $limit) break;
            $url = 'cars-for-sale/transmission/' . $this->slugify($combo->transmission_type) . '/' . $this->slugify($combo->location);
            if ($this->getCarCountForFilters(['transmission_type' => $combo->transmission_type, 'location' => $combo->location]) > 0) {
                $this->addUrlIfUnique($sitemap, $baseUrl, $url, $duplicateCheck, $urlCount, 0.6);
            }
        }

    
        $bodyLocationCombos = $this->getBodyTypeLocationCombinations();
        foreach ($bodyLocationCombos as $combo) {
            if ($urlCount >= $limit) break;
            $url = 'cars-for-sale/body/' . $this->slugify($combo->body_type) . '/' . $this->slugify($combo->location);
            if ($this->getCarCountForFilters(['body_type' => $combo->body_type, 'location' => $combo->location]) > 0) {
                $this->addUrlIfUnique($sitemap, $baseUrl, $url, $duplicateCheck, $urlCount, 0.6);
            }
        }

    
        // $makePriceCombos = $this->getMakePriceCombinations();
        // foreach ($makePriceCombos as $combo) {
        //     if ($urlCount >= $limit) break;
        //     $url = 'cars-for-sale/' . $this->slugify($combo->make) . '/under-' . $combo->max_price;
        //     if ($this->getCarCountForFilters(['make' => $combo->make, 'price_max' => $combo->max_price]) > 0) {
        //         $this->addUrlIfUnique($sitemap, $baseUrl, $url, $duplicateCheck, $urlCount, 0.5);
        //     }
        // }

        $this->info("Generated {$urlCount} dynamic SEO URLs (all with available cars)");
    }

    private function getCarCountForFilters($filters)
    {
        $query = Car::leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active');

        foreach ($filters as $column => $value) {
            if ($column === 'location') {
                $query->whereRaw('LOWER(users.location) LIKE ?', ['%' . strtolower($value) . '%']);
            } elseif ($column === 'price_max') {
                $query->where('cars.price', '<=', $value);
            } elseif ($column === 'year') {
                $query->where('cars.year', $value);
            } else {
                $query->whereRaw("LOWER(cars.{$column}) = ?", [strtolower($value)]);
            }
        }

        return $query->count();
    }

    private function getLocationsWithCars()
    {
        return DB::table('users')
            ->select('users.location', DB::raw('COUNT(*) as car_count'))
            ->join('adverts', 'users.id', '=', 'adverts.user_id')
            ->join('cars', 'adverts.advert_id', '=', 'cars.advert_id')
            ->where('adverts.status', 'active')
            ->whereNotNull('users.location')
            ->groupBy('users.location')
            ->having('car_count', '>', 0)
            ->orderBy('car_count', 'desc')
            ->get();
    }

    private function getMakeLocationCombinations()
    {
        return DB::table('cars')
            ->select('cars.make', 'users.location', DB::raw('COUNT(*) as car_count'))
            ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active')
            ->whereNotNull('cars.make')
            ->whereNotNull('users.location')
            ->groupBy('cars.make', 'users.location')
            ->having('car_count', '>', 0)
            ->orderBy('car_count', 'desc')
            ->get();
    }

    private function getFuelTypeLocationCombinations()
    {
        return DB::table('cars')
            ->select('cars.fuel_type', 'users.location', DB::raw('COUNT(*) as car_count'))
            ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active')
            ->whereNotNull('cars.fuel_type')
            ->whereNotNull('users.location')
            ->groupBy('cars.fuel_type', 'users.location')
            ->having('car_count', '>', 0)
            ->orderBy('car_count', 'desc')
            ->get();
    }

    private function getTransmissionLocationCombinations()
    {
        return DB::table('cars')
            ->select('cars.transmission_type', 'users.location', DB::raw('COUNT(*) as car_count'))
            ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active')
            ->whereNotNull('cars.transmission_type')
            ->whereNotNull('users.location')
            ->groupBy('cars.transmission_type', 'users.location')
            ->having('car_count', '>', 0)
            ->orderBy('car_count', 'desc')
            ->get();
    }

    private function getBodyTypeLocationCombinations()
    {
        return DB::table('cars')
            ->select('cars.body_type', 'users.location', DB::raw('COUNT(*) as car_count'))
            ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active')
            ->whereNotNull('cars.body_type')
            ->whereNotNull('users.location')
            ->groupBy('cars.body_type', 'users.location')
            ->having('car_count', '>', 0)
            ->orderBy('car_count', 'desc')
            ->get();
    }

    private function getMakeModelLocationCombinations()
    {
        return DB::table('cars')
            ->select('cars.make', 'cars.model', 'users.location', DB::raw('COUNT(*) as car_count'))
            ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active')
            ->whereNotNull('cars.make')
            ->whereNotNull('cars.model')
            ->whereNotNull('users.location')
            ->groupBy('cars.make', 'cars.model', 'users.location')
            ->having('car_count', '>', 0)
            ->orderBy('car_count', 'desc')
            ->get();
    }

    private function getMakeModelYearLocationCombinations()
    {
        return DB::table('cars')
            ->select('cars.make', 'cars.model', 'cars.year', 'users.location', DB::raw('COUNT(*) as car_count'))
            ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active')
            ->whereNotNull('cars.make')
            ->whereNotNull('cars.model')
            ->whereNotNull('cars.year')
            ->whereNotNull('users.location')
            ->groupBy('cars.make', 'cars.model', 'cars.year', 'users.location')
            ->having('car_count', '>', 0)
            ->orderBy('car_count', 'desc')
            ->get();
    }

    private function getMakeModelPriceCombinations()
    {
        $pricePoints = [5000, 10000, 15000, 20000, 25000, 30000, 40000, 50000];
        $results = collect();

        foreach ($pricePoints as $maxPrice) {
            $combinations = DB::table('cars')
                ->select('cars.make', 'cars.model', DB::raw("$maxPrice as max_price"), DB::raw('COUNT(*) as car_count'))
                ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
                ->where('adverts.status', 'active')
                ->where('cars.price', '<=', $maxPrice)
                ->whereNotNull('cars.make')
                ->whereNotNull('cars.model')
                ->groupBy('cars.make', 'cars.model')
                ->having('car_count', '>', 0)
                ->orderBy('car_count', 'desc')
                ->get();

            $results = $results->merge($combinations);
        }

        return $results;
    }

    private function getMakePriceCombinations()
    {
        $pricePoints = [5000, 10000, 15000, 20000, 25000, 30000, 40000, 50000];
        $results = collect();

        foreach ($pricePoints as $maxPrice) {
            $combinations = DB::table('cars')
                ->select('cars.make', DB::raw("$maxPrice as max_price"), DB::raw('COUNT(*) as car_count'))
                ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
                ->where('adverts.status', 'active')
                ->where('cars.price', '<=', $maxPrice)
                ->whereNotNull('cars.make')
                ->groupBy('cars.make')
                ->having('car_count', '>', 0)
                ->orderBy('car_count', 'desc')
                ->get();

            $results = $results->merge($combinations);
        }

        return $results;
    }

    private function getYearMakeLocationCombinations($year)
    {
        return DB::table('cars')
            ->select('cars.make', 'users.location', DB::raw('COUNT(*) as car_count'))
            ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active')
            ->where('cars.year', $year)
            ->whereNotNull('cars.make')
            ->whereNotNull('users.location')
            ->groupBy('cars.make', 'users.location')
            ->having('car_count', '>', 0)
            ->orderBy('car_count', 'desc')
            ->get();
    }

    private function getPriceLocationCombinations($maxPrice)
    {
        return DB::table('cars')
            ->select('users.location', DB::raw('COUNT(*) as car_count'))
            ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active')
            ->where('cars.price', '<=', $maxPrice)
            ->whereNotNull('users.location')
            ->groupBy('users.location')
            ->having('car_count', '>', 0)
            ->orderBy('car_count', 'desc')
            ->get();
    }

    private function getMakePriceLocationCombinations($maxPrice)
    {
        return DB::table('cars')
            ->select('cars.make', 'users.location', DB::raw('COUNT(*) as car_count'))
            ->leftJoin('adverts', 'cars.advert_id', '=', 'adverts.advert_id')
            ->leftJoin('users', 'adverts.user_id', '=', 'users.id')
            ->where('adverts.status', 'active')
            ->where('cars.price', '<=', $maxPrice)
            ->whereNotNull('cars.make')
            ->whereNotNull('users.location')
            ->groupBy('cars.make', 'users.location')
            ->having('car_count', '>', 0)
            ->orderBy('car_count', 'desc')
            ->get();
    }

    private function addUrlIfUnique($sitemap, $baseUrl, $url, &$duplicateCheck, &$urlCount, $priority)
    {
        if (!in_array($url, $duplicateCheck)) {
            $duplicateCheck[] = $url;
            $sitemap->add(
                Url::create($baseUrl . $url)
                    ->setPriority($priority)
                    ->setChangeFrequency('weekly')
                    ->setLastModificationDate(now())
            );
            $urlCount++;
        }
    }


    private function slugify($string)
    {
        if (empty($string)) {
            return '';
        }
        $string = strtolower(trim($string));
        $string = str_replace([' ', '&', '+'], ['-', 'and', 'plus'], $string);
        $string = preg_replace('/[^a-z0-9\-]/', '', $string);
        $string = preg_replace('/-+/', '-', $string);
        return $string;
    }
}