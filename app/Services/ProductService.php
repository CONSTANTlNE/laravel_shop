<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function store($request, $mainLocale, $locales)
    {

        $request->validate([
            'product_name_'.$mainLocale->abbr => 'required|string|max:255',
            'description_'.$mainLocale->abbr => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
            'category_id' => 'required|integer|min:1',
            'category_slug' => 'required|string|max:150',
            //            'subcategory_id' => 'nullable|exists:subcategories,id',
            'sku' => 'nullable|string|max:150',
            'files' => 'required|array',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5024',
        ]);

        if ($request->filled('video')) {
            $url = $request->input('video');
            $host = parse_url($url, PHP_URL_HOST);

            if (! in_array($host, ['www.youtube.com', 'youtube.com', 'youtu.be'])) {
                return back()->withErrors(['video' => 'The video must be a valid YouTube link.']);
            }

            // Parse query string from URL
            parse_str(parse_url($url, PHP_URL_QUERY), $query);

            // Get the video ID
            $videoId = $query['v'] ?? null;
        } else {
            $videoId = null;
        }

        $findcategory = Category::where('id', $request->input('category_id'))
            ->where('slug', $request->input('category_slug'))
            ->first();
        if ($findcategory) {
            $category = $findcategory;
            $subcategory = null;
        } else {
            $findsubcategory = Subcategory::where('id', $request->input('category_id'))
                ->where('slug', $request->input('category_slug'))
                ->first();
            if ($findsubcategory) {
                $category = $findsubcategory->category;
                $subcategory = $findsubcategory->id;
            } else {
                return back()->with('alert_error', 'Category or Subcategory not found');
            }
        }

        $product = new Product;

        foreach ($locales as $locale) {
            $cleaned = preg_replace('/\s+/', ' ', $request->input('product_name_'.$locale->abbr));
            $trimmed = trim($cleaned);
            $cleaned_descr = preg_replace('/\s+/', ' ', $request->input('description_'.$locale->abbr));
            $trimmed_descr = trim($cleaned_descr);
            $product->setTranslation('name', $locale->abbr, $trimmed);
            $product->setTranslation('description', $locale->abbr, $trimmed_descr);
        }

        $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $historyEntry = [
            'id' => $code,
            'update_date' => now()->toDateTimeString(),
            'price' => $request->price,
            'user_id' => auth()->id(),
            'discount_id' => '',
            'discount%' => '',
            'reason' => 'Initial Price',
        ];

        $history = $product->price_history ?? [];
        $history[] = $historyEntry;

        $product->price_history = $history;
        $product->sku = $request->input('sku');
        $product->subcategory_id = $subcategory;
        $product->category_id = $category->id;
        $product->stock = $request->input('stock');
        $product->featured = 0;
        $product->price = $request->input('price');
        $product->embed_video = $videoId;
        $product->admin_id = auth('admin')->id();

        $product->save();
        $product->categories()->attach($category->id);

        $uploadedFile = $request->file('files');

        foreach ($uploadedFile as $file) {
            //            $thumbnail = new Conversion()->thumbnail($file);
            //            $mainImage = new Conversion()->convert($file);
            //            // save thumbnail
            //            Storage::disk('public')->put($product->slug.'.webp', $thumbnail);
            //            $product->addMedia(storage_path('app/public/'.$product->slug.'.webp'))->toMediaCollection('product_thumbnail');
            //            Storage::disk('public')->delete($product->slug.'.webp');
            //
            //            // save main image
            //            Storage::disk('public')->put($product->slug.'.webp', $mainImage);
            //            $product->addMedia(storage_path('app/public/'.$product->slug.'.webp'))->toMediaCollection('product_image');
            //            Storage::disk('public')->delete($product->slug.'.webp');

            $product
                ->addMedia($file) // ORIGINAL file
                ->toMediaCollection('product_image');
        }
    }

    public function priceUpdate($request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->input('product_id'));

        // 4-digit numeric, with leading zeros allowed (e.g. "0042")
        $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        // Prepare history entry
        $historyEntry = [
            'id' => $code,
            'update_date' => now()->toDateTimeString(),
            'price' => $request->input('price'),
            'user_id' => auth()->id(),
            'discount_id' => '',
            'discount%' => '',
            'reason' => 'manual update',
        ];

        // Get current history or start with empty array
        $history = $product->price_history ?? [];

        // Append new entry
        $history[] = $historyEntry;

        // Update product
        $product->price = $request->input('price');
        $product->price_history = $history;
        $product->save();

    }

    public function inStock($request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->input('product_id'));

        if (! $product) {
            return back()->with('alert_error', 'Product not found');
        }

        if ($product->in_stock == 1) {
            $product->in_stock = 0;
        } else {
            if ($product->stock === 0) {
                return back()->with('alert_error', 'Product with 0 quantity cant be in stock');
            }
            $product->in_stock = 1;
        }

        $product->save();
    }

    public function addImage($request)
    {

        $request->validate([
            'files' => 'required|array',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5024',
        ]);

        $product = Product::findOrFail($request->input('product_id'));

        if ($product) {
            $uploadedFile = $request->file('files');
            foreach ($uploadedFile as $file) {
                //                $thumbnail = new Conversion()->thumbnail($file);
                $mainImage = new Conversion()->convert($file);
                //                // save thumbnail
                //                Storage::disk('public')->put($product->slug.'.webp', $thumbnail);
                //                $product->addMedia(storage_path('app/public/'.$product->slug.'.webp'))->toMediaCollection('product_thumbnail');
                //                Storage::disk('public')->delete($product->slug.'.webp');
                //                // save main image
                Storage::disk('public')->put($product->slug.'.webp', $mainImage);
                $product->addMedia(storage_path('app/public/'.$product->slug.'.webp'))->toMediaCollection('product_image');
                Storage::disk('public')->delete($product->slug.'.webp');

            }

            return back()->with('alert_success', 'Images added successfully');
        }
    }
}
