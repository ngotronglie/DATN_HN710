<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Color>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, int2: 6), // Giả định có 10 người dùng
            'product_id' => $this->faker->numberBetween(1, int2: 20), // Giả định có 20 sản phẩm
            'content' => $this->faker->text(200), // Nội dung comment
            'is_active' => $this->faker->numberBetween(1, 2), // Trạng thái hoạt động
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}