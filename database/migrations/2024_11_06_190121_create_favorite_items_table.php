<?php

use App\Models\Favorite;
use App\Models\Product;
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
        Schema::create('favorite_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Favorite::class)->constrained()->onDelete('cascade'); // Mối quan hệ với bảng `favorites`
            $table->foreignIdFor(Product::class)->constrained()->onDelete('cascade'); // Mối quan hệ với sản phẩm
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_items');
    }
};
