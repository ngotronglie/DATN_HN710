<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'link',
        'description',
        'user_id',
        'updated_by',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id'); // Người tạo
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by'); // Người sửa cuối cùng
    }
}
