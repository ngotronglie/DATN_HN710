<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::inRandomOrder()->first()->id, 
            'product_variant_id' => ProductVariant::inRandomOrder()->first()->id ?? null,
            'product_name' => fake()->word(),
            'size_name' => fake()->randomElement(['S', 'M', 'L', 'XL']),
            'color_name' => fake()->randomElement(['Red', 'Blue', 'Green']),
            'quantity' => fake()->numberBetween(1, 10),
            'price' => fake()->randomFloat(2, 10, 500),
        ];
    }
}
