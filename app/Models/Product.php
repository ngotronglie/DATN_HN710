<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'img_thumb',
        'description',
        'view',
        'category_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getTotalQuantityAttribute()
    {
        return $this->variants()
            ->whereHas('color', function ($query) {
                $query->whereNull('deleted_at'); // Chỉ tính các màu chưa bị xóa mềm
            })
            ->whereHas('size', function ($query) {
                $query->whereNull('deleted_at'); // Chỉ tính các kích thước chưa bị xóa mềm
            })
            ->sum('quantity'); // Tính tổng số lượng của các biến thể
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
