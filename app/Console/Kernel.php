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
        \App\Console\Commands\PaymentPlanC::class,
        \App\Console\Commands\ApprovePlanC::class,
        \App\Console\Commands\NulifeA::class,
        \App\Console\Commands\GeneratePin::class,
        \App\Console\Commands\DevelPassword::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        ini_set('memory_limit', '128M');

        $schedule->command('planc:payment-check')
                    ->cron('0,15,30,45 * * * *')
                    ->withoutOverlapping()
                    ->appendOutputTo(storage_path('logs/planc-check.log'));
        $schedule->command('planc:approve')
                    ->cron('5,20,35,50 * * * *')
                    ->withoutOverlapping()
                    ->appendOutputTo(storage_path('logs/planc-approve.log'));
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
