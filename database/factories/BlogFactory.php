<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence, // Tiêu đề ngẫu nhiên
            'slug' => $this->faker->slug, // Slug ngẫu nhiên
            'content' => $this->faker->paragraphs(3, true), // Nội dung ngẫu nhiên
            'is_active' => $this->faker->boolean(80), // 80% có thể là active
            'view' => $this->faker->numberBetween(0, 1000), // Lượt xem ngẫu nhiên
            'user_id' => \App\Models\User::factory(), // Liên kết đến User, dùng UserFactory
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
