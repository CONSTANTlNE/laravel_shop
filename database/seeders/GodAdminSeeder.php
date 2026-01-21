<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class GodAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'God Admin',
            'email' => 'constantine@gmail.com',
            'password' => '$2y$12$Uin32gBpitgzQVtpCfyCA.JJJlu1Q1v2UJq7NyxHAwY312p.0RMrW',
            'mobile' => '551507697',
            'god_admin' => 1,
        ]);
    }
}
