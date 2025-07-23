<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Agenda a execução do comando todos os dias às 10h
       // $schedule->command('instagram:post')->dailyAt('10:00');
        $schedule->command('instagram:post')->everyMinute(); //test

    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
