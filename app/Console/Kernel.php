<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Console\Commands\FirstBatch;
use App\Console\Commands\SecondBatch;
use App\Console\Commands\ThirdBatch;
use App\Console\Commands\FourthBatch;
use App\Console\Commands\FifthBatch;
use App\Console\Commands\UpdateExchangeRates;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateExchangeRates::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('rates:update --force')->hourly();
    }
}
