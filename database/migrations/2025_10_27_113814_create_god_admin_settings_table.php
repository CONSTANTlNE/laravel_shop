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
        Schema::create('god_admin_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('use_payments')->default(true);
            $table->boolean('use_bog')->default(true);
            $table->boolean('use_tbc')->default(false);
            $table->boolean('use_flitt')->default(false);
            $table->boolean('use_sms')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('god_admin_settings');
    }
};
