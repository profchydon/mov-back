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
        $schedule->command('upcoming-asset-maintenance')->daily();
        $schedule->command('overdue-asset-maintenance')->daily();

        $schedule->command('upcoming-return-asset:days')->daily();
        $schedule->command('asset-return-overdue')->daily();
        $schedule->command('app:deactivate-expired-subscription')->daily();
        $schedule->command('app:update-assets-score')->daily();

        $schedule->command('companies:send-weekly-summary')->weekly()->saturdays()->at('12:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
