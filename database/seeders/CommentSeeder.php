<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run()
    {
        // $faker = Faker::create();

        // for ($i = 0; $i < 10; $i++) { // Tạo 50 comment
        //     DB::table('comments')->insert([
        //         'user_id' => $faker->numberBetween(1, 10), // Giả định có 10 người dùng
        //         'product_id' => $faker->numberBetween(1, 20), // Giả định có 20 sản phẩm
        //         'content' => $faker->text(200), // Nội dung comment
        //         'is_active' => $faker->numberBetween(1, 2),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }

        Comment::factory()->count(10)->create();
    }
}