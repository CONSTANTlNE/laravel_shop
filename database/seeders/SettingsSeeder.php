<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'use_sku' => true,
            'use_stock' => true,
            'show_discounted' => true,
            'show_discount_percent' => false,
            'show_faq' => true,
            'use_categories' => true,
            'min_order_amount' => 0,
            'use_transportation' => true,
            'use_email_notification' => true,
            'sms_notification' => true,
            'dark_theme' => false,
            'use_main_banner' => true,
            'use_sms_verification' => true,
            'show_only_categories_on_main' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
