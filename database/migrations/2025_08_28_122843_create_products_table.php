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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable()->index();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained()->ondelete('set null');
            $table->jsonb('name')->index();
            $table->integer('stock')->default(5);
            $table->jsonb('description')->index();
            $table->integer('order')->nullable();
            $table->boolean('in_stock')->default(1);
            $table->boolean('show_in_similar')->default(1);
            $table->boolean('show_in_main')->default(1);
            $table->boolean('active')->default(1);
            $table->boolean('featured')->default(0);
            $table->float('price')->index();
            $table->float('discount_percentage')->nullable();
            $table->jsonb('price_history')->default([]);
            $table->string('slug')->unique()->index();
            $table->string('embed_video')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
