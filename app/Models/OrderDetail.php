<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_variant_id',
        'quantity',
    ];

    // Thiết lập quan hệ với đơn hàng (Order)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Thiết lập quan hệ với biến thể sản phẩm (ProductVariant)
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    
}
