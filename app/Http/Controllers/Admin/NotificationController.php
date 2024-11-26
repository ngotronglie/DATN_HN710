<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
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

        $notification = $user->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        return view('admin.layout.order.notificationOrder', compact('order'));
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
