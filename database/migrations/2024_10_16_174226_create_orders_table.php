<?php

use App\Models\User;
use App\Models\Voucher;
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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('restrict'); 
        $table->string('user_name');
        $table->string('user_email');
        $table->string('user_phone');
        $table->string('user_address');
        $table->foreignIdFor(Voucher::class)->nullable()->constrained()->onDelete('restrict');
        $table->integer('discount')->nullable();
        $table->bigInteger('total_amount');
        $table->string('status')->default('1');
        $table->enum('payment_method', ['cod', 'online'])->default('cod'); 
        $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');//Đơn hàng chưa thanh toán, Đơn hàng đã thanh toán, Hoàn tiền
        $table->string('order_code')->unique();
        $table->text('note')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
