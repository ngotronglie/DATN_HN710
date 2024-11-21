<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\User;
use App\Models\UserVoucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    //  protected function schedule(Schedule $schedule): void
    //  {
    //     // $schedule->command('inspire')->hourly();

    //     // Xóa các tài khoản chưa xác thực sau 7 ngày
    //     // $schedule->call(function () {
    //     //     $expirationDate = now()->subDays(7); 

    //     //     User::whereNull('email_verified_at') 
    //     //         ->where('created_at', '<', $expirationDate) 
    //     //         ->delete(); //forceDelete()
    //     // })->daily(); 
    //}
    
    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->call(function () {
    //         // Cập nhật trạng thái "expired" cho các voucher đã hết hạn
    //         UserVoucher::whereHas('voucher', function ($query) {
    //             // Kiểm tra ngày hết hạn của voucher
    //             $query->where('end_date', '<', Carbon::now()); // Ngày hết hạn trước ngày hiện tại
    //         })
    //         ->where('status', '!=', 'expired') // Kiểm tra nếu trạng thái chưa phải là "expired"
    //         ->update(['status' => 'expired']); // Cập nhật trạng thái thành "expired"
    //     })->daily(); // Chạy mỗi ngày
    // }
    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
