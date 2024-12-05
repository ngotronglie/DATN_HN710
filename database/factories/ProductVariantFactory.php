<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'size_id' => Size::inRandomOrder()->first()->id, 
            'color_id' => Color::inRandomOrder()->first()->id, 
            'quantity' => fake()->numberBetween(1, 100),
            'price' => fake()->numberBetween(50000, 300000), 
            'price_sale' => fake()->numberBetween(40000, 250000), 
        ];
    }
}
