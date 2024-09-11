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
            'code' => strtoupper($this->faker->unique()->lexify('??????')), // Generates a unique 6-letter code
            'discount' => $this->faker->randomFloat(2, 5, 50) . '%', // Random percentage discount between 5% and 50%
            'start_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'), // Start date between last month and next month
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+6 months'), // End date between next month and 6 months later
            'quantity' => $this->faker->numberBetween(1, 1000), // Random quantity between 1 and 1000
            'min_money' => $this->faker->randomFloat(2, 10, 100), // Random minimum money between 10 and 100
            'max_money' => $this->faker->randomFloat(2, 100, 1000), // Random maximum money between 100 and 1000
        ];
    }
}
