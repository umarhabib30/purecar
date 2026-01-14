<?php
namespace App\Console\Commands;

use App\Http\Controllers\FtpFeedController;
use Illuminate\Console\Command;

class ProcessFtpFeed extends Command
{
    protected $signature = 'ftp:process-feeds';
    protected $description = 'Process FTP feed CSV files from public/feeds directory';

    public function handle()
    {
        $this->info('Starting FTP feed processing...');

        try {
            $controller = new FtpFeedController();
            $response = $controller->processFtpFeeds();

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getContent(), true);
                
                $this->info("✅ FTP feeds processed successfully!");
                $this->info("📊 Summary:");
                $this->info("   • Total processed: " . $data['total_processed']);
                $this->info("   • Total updated: " . $data['total_updated']);
                $this->info("   • Total skipped: " . $data['total_skipped']);
                $this->info("   • Marked as sold: " . $data['total_marked_as_sold']);

                if (!empty($data['processed_files'])) {
                    $this->info("📁 Processed files:");
                    foreach ($data['processed_files'] as $file) {
                        $this->info("   • " . $file);
                    }
                } else {
                    $this->info("📁 No files found to process");
                }

                return Command::SUCCESS;
            } else {
                $errorData = json_decode($response->getContent(), true);
                $this->error("❌ Failed to process FTP feeds: " . ($errorData['error'] ?? 'Unknown error'));
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error("❌ An error occurred: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}