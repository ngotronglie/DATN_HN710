<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'favorite_id',
        'product_id',
    ];

    /**
     * Mối quan hệ với model Favorite.
     */
    public function favorite()
    {
        return $this->belongsTo(Favorite::class);
    }

    /**
     * Mối quan hệ với model Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
