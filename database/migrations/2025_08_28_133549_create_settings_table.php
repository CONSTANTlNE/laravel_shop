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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('use_sku')->default(1);
            $table->boolean('use_stock')->default(1);
            $table->boolean('show_discounted')->default(true);
            $table->boolean('show_discount_percent')->default(false);
            $table->boolean('show_faq')->default(true);
            $table->boolean('use_categories')->default(true);
            $table->float('min_order_amount')->default(0);
            $table->boolean('use_transportation')->default(true);
            $table->boolean('use_email_notification')->default(true);
            $table->boolean('sms_notification')->default(true);
            $table->boolean('dark_theme')->default(false);
            $table->boolean('use_main_banner')->default(true);
            $table->boolean('use_sms_verification')->default(true);
            $table->boolean('show_only_categories_on_main')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
