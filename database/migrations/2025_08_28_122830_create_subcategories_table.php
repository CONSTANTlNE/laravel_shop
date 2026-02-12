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
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->jsonb('name')->index();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->integer('order')->nullable();
            $table->boolean('active')->default(1);
            $table->string('slug')->unique()->index();
            $table->boolean('is_slider')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
