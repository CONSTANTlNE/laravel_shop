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
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('removed_from_store')->default(false)->index()->after('active');
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->boolean('removed_from_store')->default(false)->index()->after('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('removed_from_store');
        });

        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropColumn('removed_from_store');
        });
    }
};
