<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryOrder;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $category = new Category;
        $category_order = new CategoryOrder;
        $category_order->save();

        $category->setTranslation('name', 'ka', 'სხვადასხვა');
        $category->setTranslation('name', 'en', 'Other');

        $category->category_order_id = $category_order->id;
        $category->save();
    }
}
