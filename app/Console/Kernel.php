<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        //->everyMinute()
        //->dailyAt('00:00')
        $schedule->command('app:update-voucher-status')->everyMinute()
            ->before(function () {
                Log::info('Bắt đầu kiểm tra voucher hết hạn lúc ' . now());
            })
            ->after(function () {
                Log::info('Hoàn thành kiểm tra voucher hết hạn lúc ' . now());
            });
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
