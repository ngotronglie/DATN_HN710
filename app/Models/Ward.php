<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'district_code',  // Cột khóa ngoại để liên kết với quận huyện
    ];

    protected $table = 'wards';

    // Quan hệ với bảng District
    public function district()
    {
        return $this->belongsTo(District::class, 'district_code'); // 'district_code' là khóa ngoại trong bảng wards
    }
}
