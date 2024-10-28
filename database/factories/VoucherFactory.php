<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->lexify('??????')),
            'discount' => fake()->randomFloat(2, 5, 50),
            'start_date' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'end_date' => fake()->dateTimeBetween('+1 month', '+6 months'),
            'quantity' => fake()->numberBetween(1, 1000),
            'min_money' => fake()->randomFloat(2, 10, 100),
        ];
    }
}
