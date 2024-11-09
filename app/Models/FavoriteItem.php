<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'favorite_id',  // Khóa ngoại đến bảng `favorites`
        'product_variant_id',  // Khóa ngoại đến bảng `product_variants`
    ];

    /**
     * Mối quan hệ: Một sản phẩm yêu thích thuộc về một mục yêu thích.
     */
    public function favorite()
    {
        return $this->belongsTo(Favorite::class);  // Mối quan hệ belongsTo với bảng `favorites`
    }

    /**
     * Mối quan hệ: Một sản phẩm yêu thích thuộc về một biến thể sản phẩm.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);  // Mối quan hệ belongsTo với bảng `product_variants`
    }
}
