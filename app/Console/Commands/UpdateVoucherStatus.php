<?php

namespace App\Console\Commands;

use App\Models\UserVoucher;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateVoucherStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-voucher-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhật trạng thái voucher hết hạn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Lấy ngày hiện tại
        $now = Carbon::now();

        // Cập nhật các voucher hết hạn
        $updated = Voucher::where('end_date', '<', $now)
            ->update(['is_active' => false]);

        // Hiển thị thông báo trong console
        $this->info("Đã cập nhật trạng thái cho {$updated} voucher(s) hết hạn.");

        $expiredUserVouchers = UserVoucher::whereHas('voucher', function ($query) use ($now) {
            $query->where('end_date', '<', $now); // Kiểm tra voucher đã hết hạn
        })
            ->where('status', 'not_used') // Chỉ cập nhật các user_voucher chưa sử dụng
            ->update(['status' => 'expired']); // Đặt trạng thái status thành 'expired'

        $this->info("Đã cập nhật trạng thái cho {$expiredUserVouchers} user voucher(s) sang 'expired'.");
    }
}
