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
        'order_id' => Order::factory(), 
            'product_variant_id' => ProductVariant::factory(), 
            'product_name' => $this->faker->word(),
            'size_name' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'color_name' => $this->faker->randomElement(['Red', 'Blue', 'Green']),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
