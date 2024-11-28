<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function redeemVoucher(Request $request)
    {
        $user = Auth::user();

        // Tìm mã giảm giá và kiểm tra điều kiện
        $voucher = Voucher::where('id', $request->id)
            ->where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->firstOrFail();

        if ($voucher->quantity == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Mã giảm giá này đã hết lượt đổi',
            ]);
        }

        if ($user->points < $voucher->points_required) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không đủ điểm để đổi mã giảm giá này',
            ]);
        }

        // Kiểm tra nếu người dùng đã nhận mã giảm giá này rồi
        $userVoucher = UserVoucher::where('user_id', $user->id)
            ->where('voucher_id', $voucher->id)
            ->exists(); // Chỉ cần kiểm tra sự tồn tại, không cần tải dữ liệu

        if ($userVoucher) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn đã nhận mã giảm giá này rồi',
            ]);
        }

        // Cập nhật số lượng mã giảm giá và điểm của người dùng
        $voucher->decrement('quantity'); // Giảm số lượng mã giảm giá
        $user->decrement('points', $voucher->points_required); // Giảm điểm người dùng

        // Tạo bản ghi UserVoucher mới
        UserVoucher::create([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'status' => 'not_used',
        ]);

        // Lấy lại số điểm của người dùng sau khi trừ đi
        $point = $user->points;

        // Lấy danh sách các mã giảm giá của người dùng
        $vouchers = UserVoucher::with('voucher')->where('user_id', $user->id)->get();
        $countVoucher = $voucher->quantity;

        // Tạo HTML cho danh sách mã giảm giá
        $html = $this->html($vouchers);

        return response()->json([
            'status' => true,
            'message' => 'Đã đổi mã giảm giá thành công',
            'countVoucher' => $countVoucher,
            'point' => $point,
            'html' => $html,
        ]);
    }


    private function html($uservouchers)
    {
        $html = '';

        foreach ($uservouchers as $uservoucher) {

            $minMoney = $uservoucher->voucher->min_money;
            $maxMoney = $uservoucher->voucher->max_money;
            $formattedMinMoney = $minMoney >= 1_000_000
                ? number_format($minMoney / 1_000_000, 0, ',', '') . 'tr'
                : number_format($minMoney / 1_000, 0, ',', '') . 'k';
            $formattedMaxMoney = $maxMoney >= 1_000_000
                ? number_format($maxMoney / 1_000_000, 0, ',', '') . 'tr'
                : number_format($maxMoney / 1_000, 0, ',', '') . 'k';

            $html .= '
                <div class="col-md-4 mb-3 voucher-card" data-status="' . $uservoucher->status . '">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="voucher-icon text-primary me-3" style="font-size: 24px;">
                                <i class="fa fa-tags"></i>
                            </div>
                            <div class="voucher-details flex-grow-1">
                                <small class="text-muted">Giảm giá: ' . ($uservoucher->voucher->discount ?? 0) . '%</small>
                                <br>
                                <small>Áp dụng: ' . $formattedMinMoney . ' - ' . $formattedMaxMoney . '</small>
                                <br>
                                <small>HSD: ' . \Carbon\Carbon::parse($uservoucher->voucher->end_date)->format('d/m/Y') . '</small>
                                <br>
                                <span class="badge ' .
                ($uservoucher->status === 'used' ? 'bg-success' :
                    ($uservoucher->status === 'not_used' ? 'bg-primary' :
                        ($uservoucher->status === 'expired' ? 'bg-danger' : ''))) . '">
                                    ' .
                ($uservoucher->status === 'used' ? 'Đã dùng' :
                    ($uservoucher->status === 'not_used' ? 'Chưa dùng' :
                        ($uservoucher->status === 'expired' ? 'Hết hạn' : ''))) . '
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        return $html;
    }


}
