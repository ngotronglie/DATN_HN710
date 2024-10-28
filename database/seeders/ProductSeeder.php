<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Product::factory(10)->create()->each(function ($product) {
            ProductVariant::factory(5)->create(['product_id' => $product->id]);
            ProductGallery::factory(3)->create(['product_id' => $product->id]);
        });
    }
}