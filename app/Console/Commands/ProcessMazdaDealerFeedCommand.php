<?php
namespace App\Console\Commands;

use App\Http\Controllers\ProcessMazdaDealerFeedController;
use App\Models\UserFeedSource;
use Illuminate\Console\Command;

class ProcessMazdaDealerFeedCommand extends Command
{
    protected $signature = 'mazda:process-feed {--dealer_id= : Process specific dealer ID}';
    protected $description = 'Process Mazda XML feeds for all Mazda dealers';

    public function handle()
    {
        $specificDealerId = $this->option('dealer_id');
        
        $query = UserFeedSource::where('source_type', 'mazda')
            ->where('is_active', true)
            ->whereNotNull('dealer_id')
            ->whereNotNull('dealer_feed_url')
            ->with('user');

        if ($specificDealerId) {
            $query->where('dealer_id', $specificDealerId);
        }

        $feedSources = $query->get();

        if ($feedSources->isEmpty()) {
            $this->warn('No Mazda dealers found with feed URLs.');
            return;
        }

        $this->info("Found {$feedSources->count()} Mazda feed source(s) to process.");

        $controller = new ProcessMazdaDealerFeedController();
        $totalProcessed = 0;
        $totalUpdated = 0;
        $totalSkipped = 0;
        $totalMarkedAsSold = 0;
        $successCount = 0;
        $failureCount = 0;

        foreach ($feedSources as $source) {
   
            $this->info("Processing Mazda feed for User: {$source->user->name} | DealerID: {$source->dealer_id}");
            $this->line("Feed URL: {$source->dealer_feed_url}");

            try {
                $response = $controller->process($source->dealer_id, $source->user->id);
                $status = $response->getStatusCode();
                $data = $response->getData();

                if ($status === 200) {
                    $this->info("✅ Success: {$data->message}");
                    $this->line("   • New vehicles: {$data->processed}");
                    $this->line("   • Updated vehicles: {$data->updated}");
                    $this->line("   • Skipped: {$data->skipped}");
                    $this->line("   • Marked as sold: {$data->marked_as_sold}");
                    
                    $totalProcessed += $data->processed;
                    $totalUpdated += $data->updated;
                    $totalSkipped += $data->skipped;
                    $totalMarkedAsSold += $data->marked_as_sold;
                    $successCount++;
                } else {
                    $errorMessage = $data->error ?? 'Unknown error';
                    $this->error("❌ Failed: {$errorMessage}");
                    $failureCount++;
                }
            } catch (\Exception $e) {
                $this->error("❌ Exception: " . $e->getMessage());
                $failureCount++;
            }
        }

  
        $this->info("📊 * Processing Summary:");
        $this->line("   • Sources processed successfully: {$successCount}");
        $this->line("   • Sources failed: {$failureCount}");
        $this->line("   • Total new vehicles: {$totalProcessed}");
        $this->line("   • Total updated vehicles: {$totalUpdated}");
        $this->line("   • Total skipped: {$totalSkipped}");
        $this->line("   • Total marked as sold: {$totalMarkedAsSold}");

    }
}