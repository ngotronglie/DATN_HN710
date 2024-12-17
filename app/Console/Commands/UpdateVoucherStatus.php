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
        $today = Carbon::today();

        // Cập nhật các voucher hết hạn
        $updated = Voucher::whereDate('end_date', '<', $today)
            ->where('is_active', true) // Chỉ cập nhật những voucher đang hoạt động
            ->update(['is_active' => false]);

        $activatedVouchers = Voucher::whereDate('start_date', '=', $today)
            ->where('is_active', false) // Chỉ cập nhật những voucher chưa hoạt động
            ->update(['is_active' => true]);

        // Hiển thị thông báo trong console
        $this->info("Đã cập nhật trạng thái cho {$updated} voucher(s) hết hạn.");
        $this->info("Đã kích hoạt {$activatedVouchers} voucher(s) bắt đầu hiệu lực.");

        $expiredUserVouchers = UserVoucher::whereHas('voucher', function ($query) use ($today) {
            $query->whereDate('end_date', '<', $today); // Kiểm tra voucher đã hết hạn
        })
            ->where('status', 'not_used') // Chỉ cập nhật các user_voucher chưa sử dụng
            ->update(['status' => 'expired']); // Đặt trạng thái status thành 'expired'

        $this->info("Đã cập nhật trạng thái cho {$expiredUserVouchers} user voucher(s) sang 'expired'.");
    }
}
