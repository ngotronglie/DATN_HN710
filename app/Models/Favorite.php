<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  // Khóa ngoại đến bảng `users`
    ];

    /**
     * Mối quan hệ: Một người dùng có thể có nhiều sản phẩm yêu thích.
     */
    public function user()
    {
        return $this->belongsTo(User::class);  // Mối quan hệ belongsTo với bảng `users`
    }

    /**
     * Mối quan hệ: Một mục yêu thích có thể có nhiều sản phẩm yêu thích (item).
     */
    public function items()
    {
        return $this->hasMany(FavoriteItem::class);  // Mối quan hệ hasMany với bảng `favorite_items`
    }
}
