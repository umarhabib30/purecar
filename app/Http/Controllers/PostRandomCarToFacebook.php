<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostRandomCarToFacebook extends Command
{
    protected $signature = 'facebook:post-random-car';
    protected $description = 'Post one random car advert to Facebook page feed and mark as posted';

    public function handle()
    {
        $this->info('Fetching a random car to post to Facebook...');

        $car = Car::with(['advert', 'advert.user'])
            ->whereHas('advert', function ($q) {
                $q->whereIn('status', ['active', 'approved']);
            })
            ->where(function ($q) {
                $q->whereNull('posted_to_facebook')
                   ->orWhere('posted_to_facebook', false);
            })
            ->inRandomOrder()
            ->first();

        if (!$car) {
            $this->warn('No available cars found to post.');
            return 0;
        }

        $this->info("Selected car ID: {$car->car_id} ({$car->make} {$car->model})");

        $pageId = env('FACEBOOK_PAGE_ID');
        $pageToken = env('FACEBOOK_PAGE_TOKEN');

        if (!$pageId || !$pageToken) {
            $this->error('Missing FACEBOOK_PAGE_ID or FACEBOOK_PAGE_TOKEN in .env');
            return 1;
        }

        // Build post content
        $message = "{$car->make} {$car->model} {$car->year}\n\n"
                 . "#purecar #{$car->make} #{$car->model}";
        $link = url("/car-for-sale/{$car->slug}");

        // Send post request to Facebook Graph API
        $response = Http::post("https://graph.facebook.com/v19.0/{$pageId}/feed", [
            'message' => $message,
            'link' => $link,
            'access_token' => $pageToken,
        ]);

        if ($response->successful()) {
            $car->update(['posted_to_facebook' => true]);
         
            $this->info("✓ Posted successfully and marked as posted_to_facebook = true");
        } else {
            
            $this->error("✗ Facebook post failed");
        }

        return 0;
    }
}
