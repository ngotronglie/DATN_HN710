<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller{

    public function notification()
    {
        $user = Auth::user();

        if ($user && $user->role == '2') {
            $notifications = $user->notifications()->get();
            //$unreadNotifications = $user->unreadNotifications()->get();
        }
        

        return view('admin.layout.notifications', compact('notifications'));
    }

    public function detailNotication($order_id, $id)
    {
        $user = Auth::user();
        $order = Order::with(['orderDetails.productVariant.product', 'orderDetails.productVariant.size', 'orderDetails.productVariant.color', 'user'])->findOrFail($order_id);
        if ($user && $user->role == '2') {
            $notification = $user->notifications()->find($id);
            if ($notification) {
                $notification->markAsRead();
            }
        }else{
            return abort(403);
        }

        return view('admin.layout.order.notificationOrder', compact('order'));
    }

}
