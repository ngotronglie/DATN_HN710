<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'discount', 'start_date', 'end_date', 'quantity', 'min_money', 'is_active',
    ];

    
    // protected $casts = [
    //     'is_active' => 'boolean',
    //     'start_date' => 'datetime',
    //     'end_date' => 'datetime',
    // ];

    // /**
    //  * Lấy ngày bắt đầu theo định dạng d/m/Y.
    //  *
    //  * @return string
    //  */
    // public function getStartDateFormattedAttribute()
    // {
    //     return $this->start_date->format('d/m/Y'); // Ngày/tháng/năm
    // }

    // /**
    //  * Lấy ngày kết thúc theo định dạng d/m/Y.
    //  *
    //  * @return string
    //  */
    // public function getEndDateFormattedAttribute()
    // {
    //     return $this->end_date->format('d/m/Y'); // Ngày/tháng/năm
    // }


    /**
     * Kiểm tra xem voucher có đang hoạt động hay không dựa trên ngày hiện tại.
     *
     * @return bool
     */
    public function getIsStatusAttribute()
    {
        $currentDate = now(); // Lấy ngày giờ hiện tại

        // Chuyển đổi start_date và end_date thành đối tượng Carbon nếu cần
        $startDate = \Carbon\Carbon::parse($this->start_date);
        $endDate = \Carbon\Carbon::parse($this->end_date);

        // Kiểm tra trạng thái hoạt động
        if ($currentDate->lt($startDate) || $currentDate->gt($endDate)) {
            return 1; // Không hoạt động
        }

        return 1; // Hoạt động
    }
}