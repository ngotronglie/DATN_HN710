<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->id(); // Tạo cột id với kiểu dữ liệu BIGINT AUTO_INCREMENT
            $table->string('name'); // Thay đổi độ dài của cột name nếu cần thiết
            $table->softDeletes(); // Tạo cột deleted_at cho soft deletes
            $table->timestamps(); // Tạo cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes'); // Xóa bảng sizes nếu rollback
    }
};
