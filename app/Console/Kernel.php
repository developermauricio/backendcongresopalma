<?php

namespace App\Console;

use App\Console\Commands\SyncLoginUsersEntries;
use App\Console\Commands\SyncPoints;
use App\Console\Commands\SyncUsersEntries;
use App\Console\Commands\SyncConference;
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
        SyncUsersEntries::class,
        SyncLoginUsersEntries::class,
        SyncPoints::class,
        SyncConference::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('sync:usersentries')->everyMinute()->withoutOverlapping();
        $schedule->command('sync:loginuser')->everyMinute()->withoutOverlapping();
        $schedule->command('sync:points')->everyMinute()->withoutOverlapping();
        $schedule->command('sync:conference')->everyMinute()->withoutOverlapping();
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
