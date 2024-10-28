<?php

namespace Database\Factories;

use App\Models\Category;
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
            'name' => fake()->word(), 
            'slug' => fake()->unique()->slug(),
            'img_thumb' => fake()->imageUrl(640, 480, 'product', true),
            'description' => fake()->paragraph(), 
            'category_id' => Category::inRandomOrder()->first()->id, 
            'view' => fake()->numberBetween(0, 1000),
        ];
    }
}