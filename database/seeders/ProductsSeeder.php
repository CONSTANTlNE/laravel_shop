<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryOrder;
use App\Models\Product;
use App\Models\Subcategory;
use App\Services\Conversion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $homecategory = new Category;
        $homecategory->setTranslation('name', 'en', 'For Home');
        $homecategory->setTranslation('name', 'ka', 'სახლისთვის');
        $homecategory->save();

        $category_order1 = new CategoryOrder;
        $category_order1->save();
        $decor = new Subcategory;
        $decor->category_id = $homecategory->id;
        $decor->category_order_id = $category_order1->id;
        $decor->setTranslation('name', 'en', 'Home Decor');
        $decor->setTranslation('name', 'ka', 'სახლის დეკორი');
        $decor->save();

        $artpieces = new Product;
        $artpieces->subcategory_id = $decor->id;
        $artpieces->category_id = $homecategory->id;
        $artpieces->setTranslation('name', 'en', 'Art Pieces');
        $artpieces->setTranslation('name', 'ka', 'დეკორაცია');
        $artpieces->setTranslation('description', 'en', 'Art Pieces');
        $artpieces->setTranslation('description', 'ka', 'დეკორაცია');
        $artpieces->stock = 5;
        $artpieces->price = 55;
        $artpieces->admin_id = 1;
        $artpieces->sku = str()->random(10);
        $artpieces->save();

        $storagePath1 = base_path('seeding_images/home/home_decor/1');
        $files1 = File::files($storagePath1);

        foreach ($files1 as $file1) {
            $path1 = $file1->getRealPath(); // or $file1->getPathname()
            $thumbnail1 = new Conversion()->thumbnail($path1);
            $mainImage1 = new Conversion()->convert($path1);
            // save thumbnail
            Storage::disk('public')->put($artpieces->slug.'.webp', $thumbnail1);
            $artpieces->addMedia(storage_path('app/public/'.$artpieces->slug.'.webp'))->toMediaCollection('product_thumbnail');
            Storage::disk('public')->delete($artpieces->slug.'.webp');

            // save main image
            Storage::disk('public')->put($artpieces->slug.'.webp', $mainImage1);
            $artpieces->addMedia(storage_path('app/public/'.$artpieces->slug.'.webp'))->toMediaCollection('product_image');
            Storage::disk('public')->delete($artpieces->slug.'.webp');
        }

        //        ====================  Kitchen subcategory =========================

        $category_order2 = new CategoryOrder;
        $category_order2->save();
        $kitchen = new Subcategory;
        $kitchen->category_order_id = $category_order2->id;
        $kitchen->category_id = $homecategory->id;
        $kitchen->setTranslation('name', 'en', 'Kitchen');
        $kitchen->setTranslation('name', 'ka', 'სამზარეულო');
        $kitchen->save();

    }
}
