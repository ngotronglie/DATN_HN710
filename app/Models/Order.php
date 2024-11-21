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
        'discount',
        'total_amount',
        'payment_method',
        'payment_status',
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
    // Không cho phép chuyển trạng thái nếu là thanh toán online và trạng thái thanh toán là chưa thanh toán hoặc không thành công hoặc hoàn tiền
    public function canProceed()
    {
        return !($this->payment_method === 'online' && in_array($this->payment_status, ['unpaid', 'failed','refunded']));
    }
     // Chỉ cho phép hoàn tiền nếu đơn hàng đã thanh toán và không ở trạng thái hoàn tiền

    // public function canRefund(){
    // return $this->payment_status === 'paid' && $this->status !== 6; 
//}
}
