<?php

namespace App\Console;

use App\Http\Controllers\EvaluationController;
use App\Jobs\RappelJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        /* $schedule->call(function () {
            $controller = new EvaluationController();
            $controller->checkAllNotesEval();
        //     $controller->saisirNote (587 , "eleveA", 1);
        })->everyMinute(); */
        //$schedule->job(new RappelJob)->daily();
        $schedule->call("App\Http\Controllers\EvaluationController@checkAllNotesEval")->everyMinute();
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
