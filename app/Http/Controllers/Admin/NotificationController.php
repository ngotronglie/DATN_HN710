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
        $order = Order::with(['orderDetails.productVariant.product', 'orderDetails.productVariant.size', 'orderDetails.productVariant.color', 'user'])->findOrFail($order_id);

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


    public function deleteAll()
    {
        $user = Auth::user();

        $notification = $user->notifications();

        $notification->delete();


        return redirect()->route('admin.notification')->with('success', 'Đã xóa thành công tất cả');
    }

}
