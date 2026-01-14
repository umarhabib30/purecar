<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
class GenerateCarSlugs extends Command
{
    protected $signature = 'cars:generate-slugs';
    protected $description = 'Generate slugs for existing cars';

    public function handle()
    {
        $this->info('Generating slugs for cars...');

        $cars = Car::whereNull('slug')->orWhere('slug', '')->get();
        $count = 0;

        foreach ($cars as $car) {
            $car->slug = Car::generateSlug($car);
            $car->save();
            $count++;
        }

        $this->info("Generated slugs for {$count} cars.");
    }
}
