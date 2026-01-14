<?php
namespace App\Console\Commands;

use App\Http\Controllers\ProcessDealerFeedController;
use App\Models\UserFeedSource;
use Illuminate\Console\Command;

class ProcessDealerFeedCommand extends Command
{
    protected $signature = 'dealer:process-feed';
    protected $description = 'Process URL feeds for all dealers';

    public function handle()
    {
        $feedSources = UserFeedSource::where('source_type', 'feed')
            ->where('is_active', true)
            ->whereNotNull('dealer_id')
            ->whereNotNull('dealer_feed_url')
            ->with('user')
            ->get();

        if ($feedSources->isEmpty()) {
            $this->warn('No URL feed sources found.');
            return;
        }

        $controller = new ProcessDealerFeedController();

        foreach ($feedSources as $source) {
            $this->info("Processing URL feed for User: {$source->user->name} | DealerID: {$source->dealer_id}");
            
            $response = $controller->process($source->dealer_id, $source->user->id);
            $status = $response->getStatusCode();
            $message = $response->getData()->message ?? $response->getData()->error ?? '';

            if ($status === 200) {
                $this->info("✅ Success: {$message}");
            } else {
                $this->error("❌ Failed: {$message}");
            }
        }
    }
}