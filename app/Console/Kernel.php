<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\SubmissionRefresh::class,
        Commands\AttendanceSync::class,
        Commands\EmployeeSync::class,
        Commands\Reminder::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('submission:refresh')->daily()->appendOutputTo(storage_path('logs/submission.log'));
        // $schedule->command('submission:refresh')->dailyAt('18:14')->appendOutputTo(storage_path('logs/submission.log'));
        $schedule->command('reminder:auto')->dailyAt('07:30')->appendOutputTo(storage_path('logs/reminder.log'));
        $schedule->command('employee:sync')->hourly()->appendOutputTo(storage_path('logs/employee.log'));
        $schedule->command('attendance:sync')->hourly()->appendOutputTo(storage_path('logs/attendance.log'));

        // $schedule->command('employee:sync')->dailyAt('08:31')->appendOutputTo(storage_path('logs/employee.log'));
        // $schedule->command('attendance:sync')->dailyAt('08:31')->appendOutputTo(storage_path('logs/attendance.log'));

        // $schedule->command('submission:refresh')->everyFifteenMinutes()->appendOutputTo(storage_path('logs/submission.log'));
        // $schedule->command('employee:sync')->everyFifteenMinutes()->appendOutputTo(storage_path('logs/employee.log'));
        // $schedule->command('attendance:sync')->everyFifteenMinutes()->appendOutputTo(storage_path('logs/attendance.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
