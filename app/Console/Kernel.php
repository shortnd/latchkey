<?php

namespace App\Console;

use App\Console\Commands\AddLateFee;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\DailyChildCheckins;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\DailyChildCheckins::class,
        \App\Console\Commands\AddLateFee::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(DailyChildCheckins::class)->weekdays()->daily();
        $schedule->command(AddLateFee::class)->weekdays()->between('18:00', '18:30')->everyTenMinutes();
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
