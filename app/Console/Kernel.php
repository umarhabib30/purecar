<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function schedule(Schedule $schedule)
{
    $schedule->command('emails:send-expiry')->everyMinute();
    $schedule->command('sitemap:generate')->daily();
    $schedule->command('adverts:auto-renew')->everyMinute();
    $schedule->command('dealer:process-feed')->daily()->at('00:00');
     $schedule->command('dealer:process-api')->daily()->at('00:00');
    $schedule->command('cars:optimize')->hourly();
}
}


