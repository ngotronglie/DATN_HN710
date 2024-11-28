<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $table = 'provinces';

    // Quan hệ với bảng Districts
    public function districts()
    {
        return $this->hasMany(District::class, 'province_code'); // 'province_code' là khóa ngoại trong bảng districts
    }

    // Quan hệ với bảng Wards
    public function wards()
    {
        return $this->hasManyThrough(Ward::class, District::class, 'province_code', 'district_code');
    }
}
