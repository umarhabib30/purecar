<?php

namespace App\Console\Commands;

use App\Models\Business;
use App\Models\BusinessType;
use App\Models\BusinessLocation;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateSlugs extends Command
{
    protected $signature = 'slugs:generate';
    protected $description = 'Generate slugs for existing businesses, business types, and locations';

    public function handle()
    {
      
        $businesses = Business::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($businesses as $business) {
            if ($business->name) {
                $business->slug = Str::slug($business->name);
                $business->save();
                $this->info("Generated slug for business: {$business->name} ({$business->slug})");
            } else {
                $this->warn("Skipped business ID {$business->id}: Missing name");
            }
        }

      
        $businessTypes = BusinessType::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($businessTypes as $type) {
            if ($type->name) {
                $type->slug = Str::slug($type->name);
                $type->save();
                $this->info("Generated slug for business type: {$type->name} ({$type->slug})");
            } else {
                $this->warn("Skipped business type ID {$type->id}: Missing name");
            }
        }

     
        $businessLocations = BusinessLocation::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($businessLocations as $location) {
            if ($location->name) {
                $location->slug = Str::slug($location->name);
                $location->save();
                $this->info("Generated slug for business location: {$location->name} ({$location->slug})");
            } else {
                $this->warn("Skipped business location ID {$location->id}: Missing name");
            }
        }

        $this->info('Slug generation completed!');
    }
}