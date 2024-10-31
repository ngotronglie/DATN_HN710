<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\User;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // Xóa các tài khoản chưa xác thực sau 7 ngày
        // $schedule->call(function () {
        //     $expirationDate = now()->subDays(7); 

        //     User::whereNull('email_verified_at') 
        //         ->where('created_at', '<', $expirationDate) 
        //         ->delete(); //forceDelete()
        // })->daily(); 
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
