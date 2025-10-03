<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryOrder;
use App\Models\Product;
use App\Models\Subcategory;
use App\Services\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExcelUploadController extends Controller
{
    public function index()
    {

        return view('excel');
    }

    public function uploadCategories(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:xlsx|max:2048',
        ]);

        $file = $request->file('file');
        $data = Excel::toArray([], $file);
        $categories = $data[0];
        $subcategories = $data[1];
        $products = $data[2];

        DB::transaction(function () use ($categories, $subcategories, $products) {
            $loop = 0;
            foreach ($categories as $index => $value) {
                if ($loop++ === 0) {
                    continue;
                }
                $category = new Category;
                $category_order = new CategoryOrder;
                $category_order->save();

                $cleaned = preg_replace('/\s+/', ' ', $value[0]);
                $trimmed = trim($cleaned);
                $category->setTranslation('name', 'ka', $trimmed);

                $cleaned2 = preg_replace('/\s+/', ' ', $value[1]);
                $trimmed2 = trim($cleaned2);
                $category->setTranslation('name', 'en', $trimmed2);

                $category->category_order_id = $category_order->id;
                $category->save();
            }

            $loop = 0;
            foreach ($subcategories as $index => $value) {
                if ($loop++ === 0) {
                    continue;
                }
                $trimmed = trim($value[0]);
                $category = Category::where('name->ka', $trimmed)->first();
                $subcategory = new Subcategory;
                $category_order = new CategoryOrder;
                $category_order->save();

                $cleaned = preg_replace('/\s+/', ' ', $value[1]);
                $trimmed = trim($cleaned);
                $subcategory->setTranslation('name', 'ka', $trimmed);

                $cleaned2 = preg_replace('/\s+/', ' ', $value[2]);
                $trimmed2 = trim($cleaned2);
                $subcategory->setTranslation('name', 'en', $trimmed2);

                $subcategory->category_order_id = $category_order->id;
                $subcategory->category_id = $category->id;
                $category->categoryOrder()?->delete();
                $subcategory->save();
            }

            $loop = 0;
            foreach ($products as $index => $value) {
                if ($loop++ === 0) {
                    continue;
                }
                $trimmed = trim($value[0]);
                $category = Category::where('name->ka', $trimmed)->first();
                if ($category) {
                    $category_id = $category->id;
                    $subcategory_id = null;
                    $subcategory = null;
                    $relation = $category;
                } else {
                    $subcategory = Subcategory::where('name->ka', $trimmed)->first();
                    $subcategory_id = $subcategory->id;
                    $category = null;
                    $category_id = $subcategory->category->id;
                    $relation = $subcategory->category;
                }

                $product = new Product;

                $cleanedname1 = preg_replace('/\s+/', ' ', $value[1]);
                $trimmedname1 = trim($cleanedname1);
                $product->setTranslation('name', 'ka', $trimmedname1);

                $cleanedname2 = preg_replace('/\s+/', ' ', $value[2]);
                $trimmedname2 = trim($cleanedname2);
                $product->setTranslation('name', 'en', $trimmedname2);

                $cleaned_descr1 = preg_replace('/\s+/', ' ', $value[3]);
                $trimmed_descr1 = trim($cleaned_descr1);
                $product->setTranslation('description', 'ka', $trimmed_descr1);

                $cleaned_descr2 = preg_replace('/\s+/', ' ', $value[4]);
                $trimmed_descr2 = trim($cleaned_descr2);
                $product->setTranslation('description', 'en', $trimmed_descr2);

                if (! $value[5] === null) {
                    $product->sku = $value[5];
                } else {
                    $product->sku = bin2hex(random_bytes(16));
                }

                $product->subcategory_id = $subcategory_id;
                $product->category_id = $category_id;
                $product->stock = $value[8];
                $product->featured = 0;
                $product->price = $value[6];
                $product->embed_video = $value[7];
                $product->admin_id = auth('admin')->id();

                $product->save();

                $relation->products()->attach($product->id);

            }

        });

        return back();

    }

    public function uploadFolder(Request $request)
    {

        $files = $request->file('files');

        $trimmed = trim($request->input('folder'));
        $product = Product::where('name->ka', $trimmed)->first();

        if (! $product) {
            dd('არ მოიძებნა');
        }

        foreach ($files as $file) {
            $thumbnail = new Conversion()->thumbnail($file);
            $mainImage = new Conversion()->convert($file);
            // save thumbnail
            Storage::disk('public')->put($product->slug.'.webp', $thumbnail);
            $product->addMedia(storage_path('app/public/'.$product->slug.'.webp'))->toMediaCollection('product_thumbnail');
            Storage::disk('public')->delete($product->slug.'.webp');

            // save main image
            Storage::disk('public')->put($product->slug.'.webp', $mainImage);
            $product->addMedia(storage_path('app/public/'.$product->slug.'.webp'))->toMediaCollection('product_image');
            Storage::disk('public')->delete($product->slug.'.webp');
        }

        return back();

    }
}
