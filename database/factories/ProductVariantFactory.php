<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductVariant;
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
            'product_id' => Product::factory(),
            'size_id' => Size::factory(), 
            'color_id' => Color::factory(), 
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->numberBetween(50000, 300000), 
            'price_sale' => $this->faker->numberBetween(40000, 250000), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
