<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign key to products table
            $table->text('content'); // Comment content
            $table->unsignedBigInteger('parent_id')->nullable(); // Parent comment (for nested comments)
            $table->boolean('is_active')->default(true); // Comment status
            $table->softDeletes(); // Soft delete column
            $table->timestamps(); // Created at and updated at

            // If parent_id should reference the same table (comments), you can add the foreign key:
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}