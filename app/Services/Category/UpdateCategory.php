<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Models\CategoryOrder;
use App\Services\Conversion;
use Illuminate\Support\Facades\Storage;

class UpdateCategory
{
    public function __invoke($request, $locales, $mainLocale): void
    {

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'category_name_'.$mainLocale->abbr => 'required|string|max:255',
            'files' => 'nullable|array',
            'files.*' => 'image|mimes:jpeg,webp,png,jpg,gif|max:5024',
        ]);

        //        dd($request->all());
        $category = Category::findOrFail($request->input('category_id'));

        $category_order = CategoryOrder::where('category_id', $category->id)->first();

        if ($request->has('for_main')) {
            if ($category_order == null) {
                $newcatorder = new CategoryOrder;
                $newcatorder->active = 1;
                $newcatorder->category_id = $category->id;
                $newcatorder->save();
            } else {
                $category_order->active = 1;
                $category_order->save();
            }
        } else {
            if ($category_order != null) {
                $category_order->active = 0;
                $category_order->save();
            }
        }

        foreach ($locales as $locale) {
            $cleaned = preg_replace('/\s+/', ' ', $request->input('category_name_'.$locale->abbr));
            $trimmed = trim($cleaned);
            $category->setTranslation('name', $locale->abbr, $trimmed);
        }

        // musnt be null so checking if its sent or not
        if ($request->input('order')) {
            $category->order = $request->input('order');
        }
        $category->save();

        if ($request->has('files') && $request->file('files')[0]) {
            $category->clearMediaCollection('category_image');
            $category->clearMediaCollection('thumbnail');

            $uploadedFile = $request->file('files')[0];
            //            $thumbnail = new Conversion()->scaleDown($uploadedFile);
            $mainImage = new Conversion()->convert($uploadedFile);

            // save thumbnail
            //            Storage::disk('public')->put($category->slug.'_thumb_'.'.webp', $thumbnail);
            //            $category->addMedia(storage_path('app/public/'.$category->slug.'_thumb_'.'.webp'))->toMediaCollection('category_thumbnail');
            //            Storage::disk('public')->delete($category->slug.'_thumb_'.'.webp');

            // save main image
            Storage::disk('public')->put($category->slug.'.webp', $mainImage);
            $category->addMedia(storage_path('app/public/'.$category->slug.'.webp'))->toMediaCollection('category_image');
            Storage::disk('public')->delete($category->slug.'.webp');
        }
    }
}
