<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CancelMail;
use App\Models\UserVoucher;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Gate::denies('viewAny', Order::class)) {
            return back()->with('warning', 'Bạn không có quyền!');
        }

        $query = Order::with(['user', 'voucher', 'orderDetails.productVariant.product'])
            ->orderBy('id', 'desc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $order = $query->get();
        $statusCounts = [
            'all' => Order::all()->count(),
            'pending' => Order::where('status', 1)->count(),
            'processing' => Order::where('status', 2)->count(),
            'shipping' => Order::where('status', 3)->count(),
            'completed' => Order::where('status', 4)->count(),
            'pending_cancel' => Order::where('status', 5)->count(),
            'canceled' => Order::where('status', 6)->count(),
        ];
        return view('admin.layout.order.index', compact('order', 'statusCounts'));
    }

    public function detail($order_id)
    {
        $order = Order::with(['user', 'voucher', 'orderDetails'])->findOrFail($order_id);

        if (Gate::denies('view', $order)) {
            return back()->with('warning', 'Bạn không có quyền xem đơn hàng này!');
        }

        $address = $order->user_address;

        $addressParts = explode(',', $address);

        $addressData = [
            'province' => isset($addressParts[3]) ? Province::where('code', trim($addressParts[3]))->value('full_name') : null,
            'district' => isset($addressParts[2]) ? District::where('code', trim($addressParts[2]))->value('full_name') : null,
            'ward' => isset($addressParts[1]) ? Ward::where('code', trim($addressParts[1]))->value('full_name') : null,
            'addressDetail' => isset($addressParts[0]) ? $addressParts[0] : null,
        ];

        return view('admin.layout.order.detail', compact('order', 'addressData'));
    }

    public function confirmOrder($order_id)
    {
        $order = Order::findOrFail($order_id);

        if (Gate::denies('confirm', $order)) {
            return back()->with('warning', 'Bạn không có quyền xác nhận đơn hàng này!');
        }
        $timeDifference = Carbon::now()->diffInMinutes($order->created_at);

        if ($timeDifference < 10) {
            $remainingTime = 10 - $timeDifference;
            return back()->with('warning', 'Bạn chỉ có thể xác nhận đơn hàng sau ' . $remainingTime . ' phút nữa.');
        }

        $staff_id = auth()->user()->id;

        if ($order->status == 1) {

            foreach ($order->orderDetails as $detail) {
                $productVariant = $detail->productVariant;
                if ($productVariant) {
                    if ($productVariant->quantity < $detail->quantity) {
                        return back()->with('error', 'Số lượng trong kho không đủ cho sản phẩm');
                    }
                } else {
                    return back()->with('error', 'Không tìm thấy biến thể sản phẩm: ' . $detail->product_variant_id);
                }
            }
               foreach ($order->orderDetails as $detail) {
                $productVariant = $detail->productVariant;
                if ($productVariant) {
                    $productVariant->quantity -= $detail->quantity;
                    $productVariant->save();
                }
            }
            $order->status = 2; // Chuyển sang "Chờ lấy hàng"
            $order->staff_id = $staff_id;
            $order->save();
            return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận');
        } else {
            return redirect()->back()->with('error', 'Không thể xác nhận đơn hàng với trạng thái hiện tại');
        }
    }

    public function shipOrder($order_id)
    {
        $order = Order::findOrFail($order_id);

        if (Gate::denies('ship', $order)) {
            return back()->with('warning', 'Bạn không có quyền giao hàng cho đơn hàng này!');
        }

        if ($order->status == 2) {
            $order->status = 3; // Chuyển sang "Đang giao hàng"
            $order->save();
            return redirect()->back()->with('success', 'Đơn hàng đang được giao');
        } else {
            return redirect()->back()->with('error', 'Không thể giao hàng với trạng thái hiện tại');
        }
    }

    public function confirmShipping($order_id)
    {
        $order = Order::findOrFail($order_id);

        if (Gate::denies('confirmShipping', $order)) {
            return back()->with('warning', 'Bạn không có quyền xác nhận giao hàng!');
        }

        $user = User::where('id', $order->user_id)->first();

        if ($user) {
            $pointsToAdd = floor($order->total_amount / 100000) * 10;
            $user->points += $pointsToAdd;
            $user->save();
        }

        if ($order->status == 3) {
            $order->status = 4; // Chuyển sang "Giao hàng thành công"
            $order->payment_status = 'paid';
            $order->save();
            return redirect()->back()->with('success', 'Đơn hàng đã được giao thành công');
        } else {
            return redirect()->back()->with('error', 'Không thể xác nhận giao hàng thành công với trạng thái hiện tại');
        }
    }

    public function cancelOrder($order_id)
    {
        $order = Order::find($order_id);

        if (Gate::denies('cancel', $order)) {
            return back()->with('warning', 'Bạn không có quyền hủy đơn hàng này!');
        }

        if ($order->voucher_id != '') {
            $voucher = UserVoucher::where('voucher_id', $order->voucher_id)->first();

            if ($voucher) {
                $now = Carbon::now(); 
                $endDate = Carbon::parse($voucher->voucher->end_date);
                if ($now <= $endDate)  {
                    $voucher->status = 'not_used';
                } else {
                    $voucher->status = 'expired';
                }
                $voucher->save(); 
                $message = 'Đơn hàng đã được hủy thành công và trạng thái mã giảm giá đã được cập nhật.';
            }
        }

        if ($order->status == 1) {
            $order->status = 5;
            $order->save();
            Mail::to($order->user_email)->send(new CancelMail($order));
            return redirect()->back()->with('success', isset($message) ? $message : 'Đơn hàng đã bị hủy.');

        } else {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng với trạng thái hiện tại');
        }
    }

    public function print_order($checkout_code)
    {
        $order = Order::with(['user', 'voucher', 'orderDetails'])
            ->where('order_code', $checkout_code)
            ->firstOrFail();

        if (Gate::denies('print', $order)) {
            return back()->with('warning', 'Bạn không có quyền in hóa đơn cho đơn hàng này!');
        }

        $address = $order->user_address;

        $addressParts = explode(',', $address);

        $addressData = [
            'province' => isset($addressParts[3]) ? Province::where('code', trim($addressParts[3]))->value('full_name') : null,
            'district' => isset($addressParts[2]) ? District::where('code', trim($addressParts[2]))->value('full_name') : null,
            'ward' => isset($addressParts[1]) ? Ward::where('code', trim($addressParts[1]))->value('full_name') : null,
            'addressDetail' => isset($addressParts[0]) ? $addressParts[0] : null,
        ];
         $fulladdress =implode(', ', array_filter([
            $addressData['addressDetail'],
            $addressData['ward'],
            $addressData['district'],
            $addressData['province']
        ], function($value) {
            return !is_null($value) && $value !== '';
        }));

        $order['user_address'] = $fulladdress;

        if ($order->status == 2 || $order->status == 4) {
            $data = [
                'title' => "Hóa đơn chi tiết",
                'date' => date('d/m/Y'),
                'order' => $order
            ];

            $pdf = Pdf::loadView('admin.layout.order.invoice', $data);
            return $pdf->stream();
        } else {
            return redirect()->back()->with('error', 'Không hợp lệ');
        }
    }
}
