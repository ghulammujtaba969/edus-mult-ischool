<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Automatically generate fee invoices on the 1st of every month
        $schedule->command('fees:generate')->monthlyOn(1, '00:00');

        // Send daily attendance SMS alerts at 10:00 AM
        $schedule->command('attendance:send-alerts')->dailyAt('10:00');

        // Verify custom domains every hour
        $schedule->command('domains:verify')->hourly();
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
