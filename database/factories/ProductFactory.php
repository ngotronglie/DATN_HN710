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
            'name' => $this->faker->word(), // Tên sản phẩm
            'slug' => $this->faker->slug(), // Slug cho sản phẩm
            'img_thumb' => $this->faker->imageUrl(640, 480, 'products', true),
            'view' => $this->faker->numberBetween(0, 1000), // Lượt xem giả lập từ 0 đến 1000
            'category_id' => $this->faker->numberBetween(1, 5), 
            'description' => $this->faker->text(200), // Mô tả sản phẩm
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}