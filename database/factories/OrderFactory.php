<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? null, 
            'user_name' => fake()->name(),
            'user_email' => fake()->safeEmail(),
            'user_phone' => fake()->phoneNumber(),
            'user_address' => fake()->address(),
            'voucher_id' => Voucher::inRandomOrder()->first()->id ?? null,
            'discount' => rand(1, 100),
            'total_amount' => fake()->numberBetween(100000, 500000), 
            'status' => fake()->randomElement(['1', '2', '3', '4']),
            'payment_method' => fake()->randomElement(['cod', 'online']),
            'payment_status' => fake()->randomElement(['unpaid', 'paid', 'failed', 'refunded']),
            'order_code' => 'ORD-' . strtoupper(Str::random(8)),
            'note' => fake()->optional()->sentence(),
        ];
    }
}
