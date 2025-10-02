<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryOrder;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Services\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
{
    protected $locales;

    protected $mainLocale;

    public $settings;

    public function __construct()
    {
        // Initialize the variable once for all methods
        $this->locales = Language::all();
        $this->mainLocale = Language::where('main', 0)->first();
        $this->settings = Setting::first();
    }

    //    public function index()
    //    {
    //
    //        $categories = Category::with('subcategories.media')->get();
    //
    //        return view('frontend.categories.index', compact('categories'));
    //    }
    //
    //    public function category($locale,$slug)
    //    {
    //        $category=Category::where('slug',$slug)
    //            ->with('products.media')
    //            ->first();
    //        $settings=$this->settings;
    //
    //        return view('frontend.categories.category_single',compact('category','settings'));
    //    }

    public function store(Request $request)
    {

        //    dd($request->all());

        $request->validate([
            'category_name_'.$this->mainLocale->abbr => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'files' => 'required|array',
            'files.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5024',
        ]);

        DB::transaction(function () use ($request) {
            $category = new Subcategory;
            $category->category_id = $request->category_id;

            $category_order = new CategoryOrder;
            $category_order->save();

            $mainCategory = Category::findOrFail($request->category_id);
            $mainCategory->categoryOrder()->delete();

            foreach ($this->locales as $locale) {
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
            $thumbnail = new Conversion()->thumbnail($uploadedFile);
            $mainImage = new Conversion()->convert($uploadedFile);

            // save thumbnail
            Storage::disk('public')->put($category->slug.'.webp', $thumbnail);
            $category->addMedia(storage_path('app/public/'.$category->slug.'.webp'))->toMediaCollection('category_thumbnail');
            Storage::disk('public')->delete($category->slug.'.webp');

            // save main image
            Storage::disk('public')->put($category->slug.'.webp', $mainImage);
            $category->addMedia(storage_path('app/public/'.$category->slug.'.webp'))->toMediaCollection('category_image');
            Storage::disk('public')->delete($category->slug.'.webp');

        });

        return back();
    }

    public function update(Request $request)
    {

        $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'category_name_'.$this->mainLocale->abbr => 'required|string|max:255',
            'files' => 'nullable|array',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif|max:5024',
        ]);

        $category = Subcategory::findOrFail($request->input('subcategory_id'));

        foreach ($this->locales as $locale) {
            $cleaned = preg_replace('/\s+/', ' ', $request->input('category_name_'.$locale->abbr));
            $trimmed = trim($cleaned);
            $category->setTranslation('name', $locale->abbr, $trimmed);
        }

        $category->order = $request->order;
        $category->save();

        $category_order = $category->categoryOrder->first();

        if (! $request->has('for_main')) {
            $category_order->active = 0;
            $category_order->save();
        } else {
            $category_order->active = 1;
            $category_order->save();
        }

        if ($request->has('files') && $request->file('files')[0]) {
            $category->clearMediaCollection('category_image');
            $category->clearMediaCollection('category_thumbnail');

            $uploadedFile = $request->file('files')[0];
            $thumbnail = new Conversion()->thumbnail($uploadedFile);
            $mainImage = new Conversion()->convert($uploadedFile);

            // save thumbnail
            Storage::disk('public')->put($category->slug.'.webp', $thumbnail);
            $category->addMedia(storage_path('app/public/'.$category->slug.'.webp'))->toMediaCollection('category_thumbnail');
            Storage::disk('public')->delete($category->slug.'.webp');

            // save main image
            Storage::disk('public')->put($category->slug.'.webp', $mainImage);
            $category->addMedia(storage_path('app/public/'.$category->slug.'.webp'))->toMediaCollection('category_image');
            Storage::disk('public')->delete($category->slug.'.webp');
        }

        return back();
    }

    public function delete(Request $request)
    {

        $subcategory = Subcategory::findOrFail($request->category_id);
        $category = $subcategory->category;
        $subcategory->delete();

        if ($category->subcategories()->count() === 0) {
            $category_order = new CategoryOrder;
            $category_order->save();
            $category->category_order_id = $category_order->id;
            $category->save();
            $category_orders = CategoryOrder::with('subcategory', 'category')->get();
            foreach ($category_orders as $category_order) {
                if ($category_order->subcategory->first() === null && $category_order->category()->first() === null) {
                    $category_order->delete();
                }
            }
        }

        return back();
    }
}
