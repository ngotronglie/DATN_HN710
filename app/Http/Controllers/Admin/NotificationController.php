<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Order;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function notification()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->get();
        //$unreadNotifications = $user->unreadNotifications()->get();

        return view('admin.layout.notifications', compact('notifications'));
    }

    public function detailNotication($order_id, $id)
    {
        $user = Auth::user();
        $order = Order::with(['user', 'voucher', 'orderDetails'])->findOrFail($order_id);

        $address = $order->user_address;

        $addressParts = explode(',', $address);

        $addressData = [
            'province' => isset($addressParts[3]) ? Province::where('code', trim($addressParts[3]))->value('full_name') : null,
            'district' => isset($addressParts[2]) ? District::where('code', trim($addressParts[2]))->value('full_name') : null,
            'ward' => isset($addressParts[1]) ? Ward::where('code', trim($addressParts[1]))->value('full_name') : null,
            'addressDetail' => isset($addressParts[0]) ? $addressParts[0] : null,
        ];

        $notification = $user->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        return view('admin.layout.order.notificationOrder', compact('order', 'addressData'));
    }

    public function delete($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($id);
        $notification->delete();
        return redirect()->route('admin.notification')->with('success', 'Xóa thành công');
    }


    public function deleteAllNotiRead()
    {
        $user = Auth::user();
        $readNotifications = $user->notifications()->whereNotNull('read_at');
        if ($readNotifications->exists()) {
            $readNotifications->delete();
            return redirect()->route('admin.notification')->with('success', 'Đã xóa thành công tất cả thông báo đã đọc.');
        } else {
            return redirect()->route('admin.notification')->with('error', 'Không có thông báo nào để xóa.');
        }
    }


    public function deleteAllNoti()
    {
        $user = Auth::user();
        $notification = $user->notifications();
        $notification->delete();
        return redirect()->route('admin.notification')->with('success', 'Đã xóa thành công tất cả');
    }

}
