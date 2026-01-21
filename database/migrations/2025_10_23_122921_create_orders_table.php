<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_token')->index();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('city_id')->nullable();
            $table->string('address');
            $table->string('bank');
            $table->string('bank_order_id');
            $table->float('total_price');
            $table->float('shipping_cost')->nullable();
            $table->json('callback_data')->nullable();
            $table->nullableMorphs('owner');
            $table->float('grand_total')->default(0);
            $table->boolean('is_delivered')->default(false);
            $table->float('total_coupon_discount')->nullable();
            $table->string('coupon_code')->nullable();
            $table->jsonb('products_details')->nullable();
            $table->boolean('status_canceled')->default(false);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
