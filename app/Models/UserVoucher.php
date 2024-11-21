<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu không theo convention của Laravel
    protected $table = 'user_vouchers';

    // Các thuộc tính có thể mass-assign
    protected $fillable = [
        'user_id',
        'voucher_id',
        'status',
    ];

    // Thiết lập mối quan hệ ngược lại với model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Thiết lập mối quan hệ ngược lại với model Voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
