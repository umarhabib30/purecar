<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Business;
use App\Models\BusinessImage;
use App\Models\BusinessType;
use App\Models\BusinessLocation;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel; 

class ImportBusinesses extends Command
{
   
    protected $signature = 'import:businesses {filename? : The name of the Excel file in the public folder. Defaults to Maps_Scrapped_Data.xlsx}';

   
    protected $description = 'Import business data from an Excel (.xlsx) file in the public folder.';

 
    public function handle()
    {
      
        $defaultFilename = 'northern_ireland_businesses.xlsx';

     
        $filename = $this->argument('filename') ?: $defaultFilename;
        $filePath = public_path($filename);

     
        if (!File::exists($filePath)) {
            $this->error("Error: Excel file not found at: {$filePath}");
            $this->error("Please ensure '{$filename}' is in your 'public' directory.");
            return Command::FAILURE;
        }

        $this->info("Attempting to import data from Excel file: {$filePath}");

        try {
           
            $allRows = Excel::toArray([], $filePath)[0];

            if (empty($allRows) || empty($allRows[0])) {
                $this->error("Error: No data or headers found in the Excel file.");
                return Command::FAILURE;
            }

           
            $headers = array_map('trim', $allRows[0]);

            $records = array_slice($allRows, 1);

            $totalRecords = count($records);
            $this->info("Found {$totalRecords} records to import.");

            
            $bar = $this->output->createProgressBar($totalRecords);
            $bar->start();

       
            foreach ($records as $rowIndex => $rowData) {
               
                $paddedRowData = array_pad($rowData, count($headers), null);
                $record = array_combine($headers, $paddedRowData);

               
                $businessName = trim($record['Business Name'] ?? '');
                $categoryName = trim($record['Category'] ?? '');
                $cityName = trim($record['City'] ?? '');
                $street = trim($record['Street'] ?? '');
                $description = trim($record['Description'] ?? '');
                $phoneNumber = trim($record['Phone Number'] ?? '');
                $email = trim($record['Email'] ?? '');
                $website = trim($record['Website'] ?? '');

                
                if (empty($businessName)) {
                    $this->warn("Skipping row " . ($rowIndex + 2) . " due to empty 'Business Name'.");
                    $bar->advance();
                    continue;
                }
                $normalizedCategoryName = ucwords(strtolower($categoryName));
                $categorySlug = Str::slug($normalizedCategoryName); 

                $normalizedCityName = ucwords(strtolower($cityName));
                $citySlug = Str::slug($normalizedCityName); 
                $businessType = BusinessType::firstOrCreate(
                    ['slug' => $categorySlug], 
                    ['name' => $normalizedCategoryName] 
                );

               
                $businessLocation = BusinessLocation::firstOrCreate(
                    ['slug' => $citySlug], 
                    ['name' => $normalizedCityName] 
                );

               
                $businessSlug = Str::slug($businessName);

                $business = Business::firstOrCreate(
                    ['slug' => $businessSlug], 
                    [
                        'name'               => $businessName,
                        'business_type_id'   => $businessType->id,
                        'business_location_id' => $businessLocation->id,
                        'contact_no'         => !empty($phoneNumber) ? $phoneNumber : null,
                        'email'              => !empty($email) ? $email : '', 
                        'address'            => trim($street . ', ' . $cityName),
                        'website'            => !empty($website) ? $website : null,
                        'description'        => !empty($description) ? $description : null,
                        'is_approved'        => true,
                    ]
                );
                for ($i = 1; $i <= 5; $i++) {
                    $imageColumn = 'Image ' . $i;
                    if (!empty(trim($record[$imageColumn] ?? ''))) {
                       
                        BusinessImage::firstOrCreate(
                            [
                                'business_id' => $business->id,
                                'image_path'  => trim($record[$imageColumn]),
                            ]
                        );
                    }
                }

                $bar->advance();
            }

            $bar->finish();
            $this->info("\nSuccessfully imported {$totalRecords} businesses from '{$filename}'!");
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("\nAn error occurred during import: " . $e->getMessage());
           
            return Command::FAILURE;
        }
    }
}

       