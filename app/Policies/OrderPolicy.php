<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    public function viewAny(User $user)
    {
        // Chỉ cho phép role 1 và 2
        return in_array($user->role, [1, 2]);
    }

    public function view(User $user, Order $order)
    {
        // Xem chi tiết đơn hàng
        return in_array($user->role, [1, 2]);
    }

    public function confirm(User $user, Order $order)
    {
        // Xác nhận đơn hàng
        return in_array($user->role, [1, 2]);
    }

    public function ship(User $user, Order $order)
    {
        // Xác nhận giao hàng
        return in_array($user->role, [1, 2]);
    }

    public function confirmShipping(User $user, Order $order)
    {
        // Xác nhận đã giao hàng
        return in_array($user->role, [1, 2]);
    }

    public function cancel(User $user, Order $order)
    {
        // Hủy đơn hàng
        return in_array($user->role, [1, 2]);
    }

    public function print(User $user, Order $order)
    {
        // In hóa đơn
        return in_array($user->role, [1, 2]) && in_array($order->status, [2, 4]);
    }
}
