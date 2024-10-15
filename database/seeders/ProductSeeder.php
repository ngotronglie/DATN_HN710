<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Tạo 20 sản phẩm giả
        Product::factory()->count(20)->create();
    }
}