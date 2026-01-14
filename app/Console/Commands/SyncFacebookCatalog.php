<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncFacebookCatalog extends Command
{
    protected $signature = 'facebook:sync-catalog';
    protected $description = 'Post one random car advert to Facebook Page feed and mark as posted';

    public function handle()
    {
        $this->info('Running Facebook car post scheduler...');

        // Get a random car that hasn't been posted yet
        $car = Car::with(['advert', 'advert.user'])
            ->whereHas('advert', function($q) {
                $q->whereIn('status', ['active', 'approved']);
            })
            ->where(function($q) {
                $q->whereNull('posted_to_facebook')
                  ->orWhere('posted_to_facebook', false);
            })
            ->inRandomOrder()
            ->first();

        if (!$car) {
            $this->warn('No eligible cars found to post to Facebook.');
            return 0;
        }

        $this->info("Selected car ID: {$car->car_id} ({$car->make} {$car->model})");

        $pageId = env('FACEBOOK_PAGE_ID');
        $pageToken = env('FACEBOOK_PAGE_TOKEN');

        if (!$pageId || !$pageToken) {
            $this->error('Missing FACEBOOK_PAGE_ID or FACEBOOK_PAGE_TOKEN in .env');
            return 1;
        }

      
        function makeHashtag($text) {
            return '#' . preg_replace('/[^a-z0-9]/i', '', str_replace(' ', '', strtolower($text)));
        }

        // Build hashtags
        $makeTag = makeHashtag($car->make);           
        $modelTag = makeHashtag($car->model);         
        $dealerTag = makeHashtag($car->user->name);  
        $locationTag = makeHashtag($car->user->location); 

        // Build post content
        $message = "{$car->make} {$car->model} {$car->year} for sale now on PureCar! 🚗💨\n\n"
                . "👀 Check it out 👉 " . url("/car-for-sale/{$car->slug}") . "\n\n"
                . "#purecar {$makeTag} {$modelTag} {$dealerTag} {$locationTag}\n\n"
                . "📣 Got a car to sell? List it on PureCar today — it’s quick, easy & only £9.99 until it sells! 💸";

        $link = url("/car-for-sale/{$car->slug}");

        try {
            // Post to Facebook Page feed
            $response = Http::post("https://graph.facebook.com/v19.0/{$pageId}/feed", [
                'message' => $message,
                'link' => $link,
                'access_token' => $pageToken,
            ]);

            if ($response->successful()) {
                $car->update(['posted_to_facebook' => true]);

                Log::info("✅ Successfully posted car {$car->car_id} to Facebook", [
                    'response' => $response->json(),
                ]);

                $this->info("✓ Posted successfully and marked as posted_to_facebook = true");
            } else {
                Log::error("❌ Failed to post car {$car->car_id} to Facebook", [
                    'response' => $response->json(),
                    'status' => $response->status(),
                ]);

                $this->error("✗ Facebook post failed. Check logs for details.");
            }

        } catch (\Exception $e) {
            Log::error("Exception posting car {$car->car_id} to Facebook", [
                'error' => $e->getMessage(),
            ]);

            $this->error("Exception: " . $e->getMessage());
        }

        return 0;
    }
}
