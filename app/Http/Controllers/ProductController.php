<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Services\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    protected $locales;

    protected $mainLocale;

    public $settings;

    public function __construct()
    {
        // Initialize the variable once for all methods
        $this->locales = Language::all();
        $this->mainLocale = Language::where('main', 1)->first();
        $this->settings = Setting::first();
    }

    public function store(Request $request)
    {

        $request->validate([
            'product_name_'.$this->mainLocale->abbr => 'required|string|max:255',
            'description_'.$this->mainLocale->abbr => 'required|string|max:255',
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
            $url = $request->video;
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

        foreach ($this->locales as $locale) {
            $cleaned = preg_replace('/\s+/', ' ', $request->input('product_name_'.$locale->abbr));
            $trimmed = trim($cleaned);
            $cleaned_descr = preg_replace('/\s+/', ' ', $request->input('description_'.$locale->abbr));
            $trimmed_descr = trim($cleaned_descr);
            $product->setTranslation('name', $locale->abbr, $trimmed);
            $product->setTranslation('description', $locale->abbr, $trimmed_descr);
        }

        $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $historyEntry = [
            'id'=>$code,
            'update_date' => now()->toDateTimeString(),
            'price' => $request->price,
            'user_id' => auth()->id(),
            'discount_id'=> '',
            'discount%'=> '',
            'reason'=>'Initial Price'
        ];

        $history = $product->price_history ?? [];
        $history[] = $historyEntry;

        $product->price_history = $history;
        $product->sku = $request->sku;
        $product->subcategory_id = $subcategory;
        $product->category_id = $category->id;
        $product->stock = $request->stock;
        $product->featured = 0;
        $product->price = $request->price;
        $product->embed_video = $videoId;
        $product->admin_id = auth('admin')->id();

        $product->save();
        $product->categories()->attach($category->id);

        $uploadedFile = $request->file('files');

        foreach ($uploadedFile as $file) {
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

        return back()->with('alert_success', 'Product created successfully.');
    }

    public function show($locale, $slug)
    {
        $product = Product::where('slug', $slug)
            ->with([
                'features' => function ($query) {
                    $query->orderBy('id'); // order by id ascending
                },
                'media', // keep media as usual
            ])
            ->first();

        if (! $product) {
            return back()->with('alert_error', 'Product not found');
        }

        $settings = $this->settings;

        $main_image = Media::where('model_id', $product->id)
            ->where('collection_name', 'product_image')
            ->where('main', 1)
            ->first();

        $similar_products = Product::where('category_id', $product->category_id)
            ->inRandomOrder()
            ->take(10)
            ->get();


        return view('frontend.product-single.product_single', compact('product', 'settings', 'main_image','similar_products'));
    }

    public function mainImage(Request $request)
    {
        $productmedia = Media::where('model_id', $request->product_id)->get();

        foreach ($productmedia as $media) {
            $media->main = 0;
            $media->save();
        }

        $media = Media::find($request->media_id);

        if ($media) {
            if ($media->main == 1) {
                $media->main = 0;
            } else {
                $media->main = 1;
            }
            $media->save();

            return back()->with('alert_success', 'Main image updated successfully');
        }

        return back()->with('alert_error', 'Media not found');

    }

    public function deleteImage(Request $request)
    {
        // thumbnail
        $media = Media::find($request->media_id);
        // main image
        $media2 = Media::find($request->media_id - 1);

        if ($media && $media2) {
            $media->delete();
            $media2->delete();

            return back()->with('alert_success', 'Image deleted successfully');
        }

        return back()->with('alert_error', 'Media not found');

    }

    public function addImage(Request $request)
    {

        $request->validate([
            'files' => 'required|array',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5024',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product) {
            $uploadedFile = $request->file('files');
            foreach ($uploadedFile as $file) {
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
        }

        return back()->with('alert_success', 'Images added successfully');

    }

    public function priceUpdate(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->product_id);

        // 4-digit numeric, with leading zeros allowed (e.g. "0042")
        $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        // Prepare history entry
        $historyEntry = [
            'id'=>$code,
            'update_date' => now()->toDateTimeString(),
            'price' => $request->price,
            'user_id' => auth()->id(),
            'discount_id'=> '',
            'discount%'=> '',
            'reason'=>'manual update'
        ];

        // Get current history or start with empty array
        $history = $product->price_history ?? [];

        // Append new entry
        $history[] = $historyEntry;

        // Update product
        $product->price = $request->price;
        $product->price_history = $history;
        $product->save();

        return back()->with('alert_success', 'Price updated successfully');
    }

    public function inStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);

        if (! $product) {
            return back()->with('alert_error', 'Product not found');
        }

        if ($product->in_stock == 1) {
            $product->in_stock = 0;
        } else {
            $product->in_stock = 1;
        }

        $product->save();

        return back()->with('alert_success', 'In stock updated successfully');

    }

    public function descriptionUpdate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'description_'.$this->mainLocale->abbr => 'required|string|max:255',
        ]);
        $product = Product::findOrFail($request->product_id);
        foreach ($this->locales as $locale) {
            $cleaned_descr = preg_replace('/\s+/', ' ', $request->input('description_'.$locale->abbr));
            $trimmed_descr = trim($cleaned_descr);
            $product->setTranslation('description', $locale->abbr, $trimmed_descr);
        }

        $product->save();

        return back()->with('alert_success', 'Description updated successfully');
    }

    public function nameUpdate(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_name_'.$this->mainLocale->abbr => 'required|string|max:255',
        ]);
        $product = Product::findOrFail($request->product_id);
        foreach ($this->locales as $locale) {
            $cleaned_descr = preg_replace('/\s+/', ' ', $request->input('product_name_'.$locale->abbr));
            $trimmed_descr = trim($cleaned_descr);
            $product->setTranslation('name', $locale->abbr, $trimmed_descr);
        }

        $product->save();

        return to_route('product.single', [app()->getLocale(), $product->slug])
            ->with('alert_success', 'Name updated successfully');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->order = $request->order;
        $product->save();

        return back()->with('alert_success', 'Order updated successfully');
    }

    public function updateMain(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Build query for products in the same category/subcategory
        $query = Product::query();

        if ($product->subcategory_id) {
            $query->where('subcategory_id', $product->subcategory_id);
        } else {
            $query->where('category_id', $product->category_id);
        }

        $mainCount = $query->where('show_in_main', 1)->count();

        // ✅ Only check when turning ON
        if ($product->show_in_main == 0) {
            if ($mainCount >= 6) {
                return back()->with('alert_error', 'You can only have 6 products in main for this ' .
                    ($product->subcategory_id ? 'subcategory' : 'category') . '.');
            }
            $product->show_in_main = 1;
        } else {
            $product->show_in_main = 0;
        }

        $product->save();

        return back()->with('alert_success', 'Product updated successfully');
    }

    public function updateVideo(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'video' => 'required|string|max:100',
        ]);

        $url = $request->video;
        $host = parse_url($url, PHP_URL_HOST);

        if (! in_array($host, ['www.youtube.com', 'youtube.com', 'youtu.be'])) {
            return back()->withErrors(['video' => 'The video must be a valid YouTube link.']);
        }

        // Parse query string from URL
        parse_str(parse_url($url, PHP_URL_QUERY), $query);

        // Get the video ID
        $videoId = $query['v'] ?? null;

        $product = Product::find($request->product_id);
        $product->embed_video = $videoId;
        $product->save();

        return back()->with('alert_success', 'Video updated successfully');
    }

    public function deleteVideo(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);
        $product->embed_video = null;
        $product->save();

        return back()->with('alert_success', 'Video deleted successfully');
    }

    public function featured(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product=Product::find($request->product_id);
        if($product->featured == 1){
            $product->featured = 0;
        }else{
            $product->featured = 1;
        }
        $product->save();
        return back()->with('alert_success', 'Featured updated successfully');
    }
}
