<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class; // Đảm bảo bạn đã khai báo model

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(), 
            'slug' => $this->faker->slug(),
            'img_thumb' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence(), 
            'view' => $this->faker->numberBetween(0, 100),
            'category_id' => 1, 
            'is_active' => $this->faker->boolean(90),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}