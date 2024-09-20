<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('title'); // Tiêu đề của blog
            $table->string('slug')->unique(); // Đường dẫn thân thiện (slug)
            $table->text('content'); // Nội dung của blog
            $table->boolean('is_active')->default(true); // Trạng thái (1: active, 0: inactive)
            $table->integer('view')->default(0); // Số lượt xem
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign Key liên kết với bảng users
            $table->softDeletes(); // Soft delete
            $table->timestamps(); // Tự động tạo cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}