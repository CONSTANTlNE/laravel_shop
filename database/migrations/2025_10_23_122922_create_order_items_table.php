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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->string('order_token')->index();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('product_id')->constrained('products');
            $table->float('coupon_discount')->nullable();
            $table->foreignId('coupon_id')->nullable();
            $table->float('product_price')->nullable();
            $table->integer('quantity');
            $table->nullableMorphs('owner');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade');
            $table->string('coupon_code')->nullable();
            $table->float('product_total')->nullable();
            $table->float('purchase_price')->nullable();
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
