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
        Schema::create('category_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order');
            $table->boolean('active')->default(1);
            $table->foreignId('category_id')
                ->nullable()
                ->constrained() // Defaults to the 'categories' table
                ->onDelete('cascade');

            $table->foreignId('subcategory_id')
                ->nullable()
                ->constrained() // Defaults to the 'subcategories' table
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_orders');
    }
};
