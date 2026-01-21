<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'permission_store',
            'permission_delete',
            'permission_update',
            'product_store',
            'product_update',
            'product_delete',
            'discount_store',
            'discount_update',
            'discount_delete',
            'discount_apply',
            'promo_code_store',
            'promo_code_update',
            'promo_code_delete',
            'promo_code_apply',
            'admin_store',
            'admin_update',
            'admin_delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
