<?php

namespace Database\Factories;

use App\Models\CategoryBlog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(),
            'img_avt' => fake()->imageUrl(),
            'content' => fake()->paragraphs(3, true),
            'view' => fake()->numberBetween(0, 1000),
            'category_blog_id' => CategoryBlog::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
