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
            'user_id' => User::factory(), 
            'user_name' => $this->faker->name,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_phone' => $this->faker->phoneNumber,
            'user_address' => $this->faker->address,
            'voucher_id' => $this->faker->boolean(50) ? Voucher::factory() : null, 
            'total_amount' => $this->faker->numberBetween(100000, 500000), 
            'status' => '1',
            'payment_method' => $this->faker->randomElement(['cod', 'vnpay', 'momo']),
            'payment_status' => $this->faker->randomElement(['unpaid', 'paid', 'failed', 'refunded']),
            'order_code' => 'ORD-' . Str::random(8),
            'note' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
