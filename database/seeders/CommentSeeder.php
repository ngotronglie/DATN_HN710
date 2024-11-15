<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        // Tạo 10 comment cha
        Comment::factory(10)->create()->each(function ($comment) {
            // Tạo 3 comment con cho mỗi comment cha
            Comment::factory(3)->create([
                'product_id' => $comment->product_id, // Giữ cùng product_id
                'parent_id' => $comment->id, // Liên kết với comment cha
            ]);
        });
    }
}
