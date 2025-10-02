<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryOrder;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Services\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
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

    public function index()
    {
        $categories = Category::with(['subcategories.media', 'categoryOrder'])
            ->orderBy('order')
            ->get();

        $categoriesCount = $categories->count();

        return view('frontend.categories.frontend_categories', compact('categories', 'categoriesCount'));
    }

    public function category(Request $request, $locale, $slug)
    {
        // Try to resolve a Category by slug first (with subcategories for the view)
        $category = Category::where('slug', $slug)
            ->with(['subcategories' => function ($query) {
                $query->with('media', 'categoryOrder')->orderBy('order');
            }])
            ->first();

        $category_orders = CategoryOrder::orderBy('order')->get();
        $categoriesCount = Subcategory::count();

        // Extract optional filters from query string
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $sortDir = strtolower($request->query('sort', 'asc')) === 'desc' ? 'desc' : 'asc';

        // Normalize numeric inputs if provided
        $minPrice = is_numeric($minPrice) ? (float) $minPrice : null;
        $maxPrice = is_numeric($maxPrice) ? (float) $maxPrice : null;
        if (! is_null($minPrice) && $minPrice < 0) {
            $minPrice = 0;
        }
        if (! is_null($maxPrice) && $maxPrice < 0) {
            $maxPrice = 0;
        }
        if (! is_null($minPrice) && ! is_null($maxPrice) && $minPrice > $maxPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        if ($category) {
            // We are on a category page: provide its subcategories collection
            $subcategories = $category->subcategories;
            $productsCount = $category->products()->count();

            // Build products query for the category with filters
            $productsQuery = $category->products()->with('media');
            if (! is_null($minPrice)) {
                $productsQuery->where('price', '>=', $minPrice);
            }
            if (! is_null($maxPrice)) {
                $productsQuery->where('price', '<=', $maxPrice);
            }
            if ($request->has('sort')) {
                $productsQuery->orderBy('price', $sortDir);
            }
            // Attach the filtered/sorted products to the model for the view
            $category->setRelation('products', $productsQuery->get());

        } else {

            // Fallback: resolve a Subcategory by slug
            $subcategory = Subcategory::where('slug', $slug)
                ->with(['category', 'categoryOrder'])
                ->first();

            if (! $subcategory) {
                return back()->with('alert_error', 'Category not found');
            }

            $productsCount = $subcategory->products()->count();

            // Build products query for the subcategory with filters
            $productsQuery = $subcategory->products()->with('media');
            if (! is_null($minPrice)) {
                $productsQuery->where('price', '>=', $minPrice);
            }
            if (! is_null($maxPrice)) {
                $productsQuery->where('price', '<=', $maxPrice);
            }
            if ($request->has('sort')) {
                $productsQuery->orderBy('price', $sortDir);
            }

            $subcategory->setRelation('products', $productsQuery->get());
            // Ensure view safety for subcategory by providing an empty subcategories collection
            $subcategory->setRelation('subcategories', collect());

            $category = $subcategory; // Keep variable name expected by the view
            $subcategories = collect();
        }

        $settings = $this->settings;

        return view('frontend.categories.category_single', compact('productsCount', 'categoriesCount', 'category_orders', 'category', 'settings', 'subcategories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'category_name_'.$this->mainLocale->abbr => 'required|string|max:255',
            'files' => 'required|array',
            'files.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5024',
        ]);

        $category = new Category;
        $category_order = new CategoryOrder;
        $category_order->save();

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

        return back();
    }

    public function update(Request $request)
    {

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'category_name_'.$this->mainLocale->abbr => 'required|string|max:255',
            'files' => 'nullable|array',
            'order' => 'required|integer',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif|max:5024',
        ]);

        $category = Category::findOrFail($request->input('category_id'));

        $category_order = $category->categoryOrder?->first();

        if ($category_order && ! $request->has('for_main')) {
            $category_order->active = 0;
            $category_order->save();
        } elseif ($category_order) {
            $category_order->active = 1;
            $category_order->save();
        }

        foreach ($this->locales as $locale) {
            $cleaned = preg_replace('/\s+/', ' ', $request->input('category_name_'.$locale->abbr));
            $trimmed = trim($cleaned);
            $category->setTranslation('name', $locale->abbr, $trimmed);
        }

        $category->order = $request->order;
        $category->save();

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

        $category = Category::findOrFail($request->category_id);
        $category->delete();

        return back();
    }

    public function changeMain(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);

        if ($request->category_id) {
            $category = Category::where('id', $request->category_id)->first();
            $catorder = CategoryOrder::where('id', $category->category_order_id)->first();
            if ($catorder) {
                $catorder->delete();
            } else {
                $newcatorder = new CategoryOrder;
                $newcatorder->save();
                $category->category_order_id = $newcatorder->id;
                $category->save();
            }
        }

        if ($request->subcategory_id) {
            $subcategory = Subcategory::where('id', $request->subcategory_id)->first();
            $catorder = CategoryOrder::where('id', $subcategory->category_order_id)->first();
            if ($catorder) {
                $catorder->delete();
            } else {
                $newcatorder = new CategoryOrder;
                $newcatorder->save();
                $subcategory->category_order_id = $newcatorder->id;
                $subcategory->save();
            }
        }

        return back()->with('alert_success', 'updated successfully');

    }
}
