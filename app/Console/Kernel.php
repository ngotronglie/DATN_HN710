<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Voucher; // Thêm dòng này để sử dụng model Voucher
use App\Models\User;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Thêm tác vụ định kỳ để cập nhật trạng thái voucher hàng ngày
        $schedule->call(function () {
            $now = now();
            
            // Vô hiệu hóa các voucher mà end_date trước hoặc bằng ngày hiện tại
            Voucher::where('end_date', '<=', $now)
                   ->update(['is_active' => false]);

            // Kích hoạt các voucher mà start_date trước hoặc bằng ngày hiện tại và end_date sau hoặc bằng ngày hiện tại
            Voucher::where('start_date', '<=', $now)
                   ->where('end_date', '>=', $now)
                   ->update(['is_active' => true]);
        })->daily(); // Chạy scheduler hàng ngày
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
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}