<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Enable extension (safe to run multiple times)
        DB::statement('CREATE EXTENSION IF NOT EXISTS "pgcrypto";');

        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->nullable()->after('id');
        });

        // Auto-generate UUID for new records
        DB::statement(
            'ALTER TABLE users ALTER COLUMN uuid SET DEFAULT gen_random_uuid();'
        );

        // Backfill existing users
        DB::statement(
            'UPDATE users SET uuid = gen_random_uuid() WHERE uuid IS NULL;'
        );

        // Make column NOT NULL
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
