<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'content',
        'parent_id'
    ];

    // Quan hệ với bảng User (mỗi bình luận thuộc về một người dùng)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng Product (mỗi bình luận thuộc về một sản phẩm)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
