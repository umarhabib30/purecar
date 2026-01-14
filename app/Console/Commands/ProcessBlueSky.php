<?php
namespace App\Console\Commands;

use App\Http\Controllers\BlueSkyController;
use App\Models\UserFeedSource;
use Illuminate\Console\Command;

class ProcessBlueSky extends Command
{
    protected $signature = 'dealer:process-bluesky';
    protected $description = 'Process BlueSky API feeds for all dealers';

    public function handle()
    {
        $feedSources = UserFeedSource::where('source_type', 'bluesky')
            ->where('is_active', true)
            ->whereNotNull('dealer_id')
            ->with('user')
            ->get();

        if ($feedSources->isEmpty()) {
            $this->info("No BlueSky feed sources found.");
            return;
        }

        $controller = new BlueSkyController();

        foreach ($feedSources as $source) {
            $this->info("Processing BlueSky for User: {$source->user->name} | DealerID: {$source->dealer_id}");
            
            $response = $controller->fetchVehicles($source->dealer_id, $source->user->id);

            if ($response->getStatusCode() === 200) {
                $this->info("✓ Successfully processed cars for DealerID: {$source->dealer_id}");
            } else {
                $this->error("✗ Failed to process cars for DealerID: {$source->dealer_id}");
            }
        }

        $this->info("BlueSky processing completed.");
    }
}