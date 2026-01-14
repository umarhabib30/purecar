<?php
namespace App\Console\Commands;

use App\Http\Controllers\DealerKitController;
use App\Models\UserFeedSource;
use Illuminate\Console\Command;

class ProcessDealerKit extends Command
{
    protected $signature = 'dealer:process-api';
    protected $description = 'Process DealerKit API feeds for all dealers';

    public function handle()
    {
        $feedSources = UserFeedSource::where('source_type', 'api')
            ->where('is_active', true)
            ->whereNotNull('dealer_id')
            ->with('user')
            ->get();

        if ($feedSources->isEmpty()) {
            $this->warn('No DealerKit feed sources found.');
            return;
        }

        $controller = new DealerKitController();

        foreach ($feedSources as $source) {
            $this->info("Processing DealerKit for User: {$source->user->name} | DealerID: {$source->dealer_id}");
            
            $response = $controller->fetchVehicles($source->dealer_id, $source->user->id);
            
            if ($response->getStatusCode() === 200) {
                $this->info("✅ Successfully processed cars for DealerID: {$source->dealer_id}");
            } else {
                $this->error("❌ Failed to process cars for DealerID: {$source->dealer_id}");
            }
        }
    }
}