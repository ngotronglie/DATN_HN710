<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_phone',
        'user_address',
        'voucher_id',
        'total_amount',
        'payment_method',
        'payment_status',
        'name',
        'email',
        'address',
        'phone',
        'order_code',
        'note'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Thiết lập quan hệ với voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    // Thiết lập quan hệ với chi tiết đơn hàng (OrderDetail)
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
