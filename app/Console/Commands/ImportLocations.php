<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BusinessLocation;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ImportLocations extends Command
{
    protected $signature = 'import:locations {filename? : The Excel file in the public folder}';
    protected $description = 'Import business locations from an Excel file, avoiding duplicates.';

    public function handle()
    {
        $defaultFilename = 'locations.xlsx';
        $filename = $this->argument('filename') ?: $defaultFilename;
        $filePath = public_path($filename);

        if (!File::exists($filePath)) {
            $this->error("❌ File not found: {$filePath}");
            return Command::FAILURE;
        }

        $this->info("📥 Importing locations from: {$filename}");

        try {
            $rows = Excel::toArray([], $filePath)[0];

            if (empty($rows) || empty($rows[0])) {
                $this->error("❌ The Excel file is empty or missing headers.");
                return Command::FAILURE;
            }

            $header = trim($rows[0][0]);
            if (strtolower($header) !== 'location') {
                $this->error("❌ Expected first column to be 'Location', found '{$header}' instead.");
                return Command::FAILURE;
            }

            $locations = array_slice($rows, 1); 
            $total = count($locations);
            $this->info("🔍 Found {$total} locations to process.");

            $bar = $this->output->createProgressBar($total);
            $bar->start();

            $createdCount = 0;
            foreach ($locations as $row) {
          
                $rawName = trim($row[0] ?? '');
                if (empty($rawName)) {
                    $bar->advance();
                    continue;
                }

                $normalizedName = ucwords(strtolower(Str::squish($rawName)));
                $slug = Str::slug($normalizedName);

                
                $location = BusinessLocation::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $normalizedName]
                );

                if ($location->wasRecentlyCreated) {
                    $createdCount++;
                }

                $bar->advance();
            }

            $bar->finish();
            $this->info("\n✅ Successfully imported {$createdCount} new location(s).");
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Error during import: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
