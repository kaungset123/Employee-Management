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
        $schedule->command('app:notify-task-deadlineover')->everyMinute();
        $schedule->command('app:remind-deadline')->dailyAt('09:00');
        $schedule->command('app:remind-project-deadline')->dailyAt('09:00');
        $schedule->command('app:notify-project-deadline-over')->dailyAt('09:00');
        $schedule->command('app:notify-salary-created')->lastDayOfMonth();
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
