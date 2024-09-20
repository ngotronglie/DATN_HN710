<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'discount', 'start_date', 'end_date', 'quantity', 'min_money', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        // 'start_date' => 'datetime',
        // 'end_date' => 'datetime',
    ];

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
}