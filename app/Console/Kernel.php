<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\FetchNimbusShipmentsJob;


class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\CompressProductFeaturedImages::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
       $schedule->job(new FetchNimbusShipmentsJob)->everyTwoHours();

        $schedule->command('contracts:send-expiry-reminders')->dailyAt('09:00');
       
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
