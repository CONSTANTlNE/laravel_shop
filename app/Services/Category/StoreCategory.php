<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Models\CategoryOrder;
use App\Services\Conversion;
use Illuminate\Support\Facades\Storage;

class StoreCategory
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store($request, $locales, $mainLocale)
    {

        $request->validate([
            'category_name_'.$mainLocale->abbr => 'required|string|max:255',
            'files' => 'required|array',
            'files.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5024',
        ]);

        $category = new Category;
        $category_order = new CategoryOrder;
        $category_order->save();

        foreach ($locales as $locale) {
            $cleaned = preg_replace('/\s+/', ' ', $request->input('category_name_'.$locale->abbr));
            $trimmed = trim($cleaned);
            $category->setTranslation('name', $locale->abbr, $trimmed);
        }

        $category->category_order_id = $category_order->id;
        $category->save();

        if ($request->has('for_main')) {
            $category_order->active = 1;
            $category_order->save();
        }

        $uploadedFile = $request->file('files')[0];
        //        $thumbnail = new Conversion()->scaleDown($uploadedFile);
        $mainImage = new Conversion()->convert($uploadedFile);

        // save thumbnail
        //        Storage::disk('public')->put($category->slug.'_thumb_'.'.webp', $thumbnail);
        //        $category->addMedia(storage_path('app/public/'.$category->slug.'_thumb_'.'.webp'))->toMediaCollection('category_thumbnail');
        //        Storage::disk('public')->delete($category->slug.'_thumb_'.'.webp');

        // save main image
        Storage::disk('public')->put($category->slug.'.webp', $mainImage);
        $category->addMedia(storage_path('app/public/'.$category->slug.'.webp'))->toMediaCollection('category_image');
        Storage::disk('public')->delete($category->slug.'.webp');
    }
}
