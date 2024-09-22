<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('search-history:clear')->daily();
        /*--- Send Txn Details for monitorings addresses --*/
        //$schedule->command('txn-details:cron')->daily();
        //$schedule->command('txn-details:cron')->everyFiveMinutes();
        //$schedule->command('txn-details:cron')->dailyAt('23:00');
        // $schedule->command('telegram:message')->everyFiveSeconds();
        $schedule->command('txn-details:cron')->hourly();
        $schedule->command('investigation-txn-history:cron')->daily();   
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
