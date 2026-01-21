<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\Category\ChangeCategoryMain;
use App\Services\Category\ShowSingleCategory;
use App\Services\Category\StoreCategory;
use App\Services\Category\UpdateCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::with(['subcategories.media', 'categoryOrder'])
            ->orderBy('order')
            ->get();
        $cacheTime = 600; // seconds

        $featured_products = Cache::remember('homepage:featured_products', $cacheTime, function () {
            return Product::where('featured', 1)->get();
        });
        $banners = $this->banners;
        $categoriesCount = $categories->count();

        return view('frontend.categories.frontend_categories', compact('banners', 'categories', 'categoriesCount', 'featured_products'));
    }

    public function category(Request $request, $locale, $slug)
    {

        $data = new ShowSingleCategory()->showSingle($request, $locale, $slug);
        $productsCount = $data['productsCount'];
        $categoriesCount = $data['categoriesCount'];
        $category_orders = $data['category_orders'];
        $subcategories = $data['subcategories'];
        $category = $data['category'];

        $settings = $this->site_settings;
        $banners = $this->banners;

//        dd($settings);

        return view('frontend.categories.category_single', compact('banners', 'productsCount', 'categoriesCount', 'category_orders', 'category', 'settings', 'subcategories'));
    }

    public function store(Request $request)
    {

        new StoreCategory()->store($request, $this->locales, $this->mainLocale);

        return back();
    }

    public function update(Request $request)
    {

        new UpdateCategory($request, $this->locales, $this->mainLocale);

        return back();
    }

    public function delete(Request $request)
    {

        $category = Category::findOrFail($request->input('category_id'));
        $category->delete();

        return back();
    }

    public function changeMain(Request $request)
    {
        new ChangeCategoryMain()->changeMain($request);

        return back()->with('alert_success', 'updated successfully');

    }
}
