<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'province_code',  // Cột khóa ngoại để liên kết với tỉnh
    ];

    protected $table = 'districts';

    // Quan hệ với bảng Province
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code'); // province_code là khóa ngoại
    }

    // Quan hệ với bảng Wards
    public function wards()
    {
        return $this->hasMany(Ward::class, 'district_code'); // 'district_code' là khóa ngoại trong bảng wards
    }
}
