<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class GenerateEventSlugs extends Command
{
    protected $signature = 'events:generate-slugs';
    protected $description = 'Generate slugs for existing events';

    public function handle()
    {
        $this->info('Generating slugs for events...');

        $events = Event::whereNull('slug')->orWhere('slug', '')->get();
        $count = 0;

        foreach ($events as $event) {
            $event->slug = Event::generateSlug($event);
            $event->save();
            $count++;
        }

        $this->info("Generated slugs for {$count} events.");
    }
}