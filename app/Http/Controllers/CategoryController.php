<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryOrder;
use App\Models\Product;
use App\Models\Subcategory;
use App\Services\Category\ChangeCategoryMain;
use App\Services\Category\ShowSingleCategory;
use App\Services\Category\StoreCategory;
use App\Services\Category\UpdateCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::where('removed_from_store', false)
            ->with(['subcategories' => function ($query) {
                $query->where('removed_from_store', false)->with('media');
            }, 'categoryOrder'])
            ->orderBy('order')
            ->get();
        $cacheTime = 600; // seconds

        $featured_products = Cache::remember('homepage:featured_products', $cacheTime, function () {
            return Product::where('featured', 1)
                ->where('removed_from_store', false)
                ->get();
        });
        $banners = $this->banners;
        $categoriesCount = $categories->count();

        return view('frontend.categories.frontend_categories', compact('banners', 'categories', 'categoriesCount', 'featured_products'));
    }

    public function category(Request $request, $locale, $slug)
    {

        $data = new ShowSingleCategory()->showSingle($request, $locale, $slug);

        if ($data instanceof RedirectResponse) {
            return $data;
        }

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
        (new UpdateCategory)($request, $this->locales, $this->mainLocale);

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

    public function removed(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);

        if ($request->filled('category_id')) {
            $category = Category::findOrFail($request->input('category_id'));
            $category->removed_from_store = ! $category->removed_from_store;
            $category->save();

            $category->products()->update([
                'removed_from_store' => $category->removed_from_store,
            ]);

            $category_order = CategoryOrder::where('category_id', $category->id)->first();
            $category_order->active = ! $category->removed_from_store;
            $category_order->save();

            $message = $category->removed_from_store
                ? __('Category removed from store.')
                : __('Category restored to store.');
        } elseif ($request->filled('subcategory_id')) {
            $subcategory = Subcategory::findOrFail($request->input('subcategory_id'));
            $subcategory->removed_from_store = ! $subcategory->removed_from_store;
            $subcategory->save();

            $subcategory->products()->update([
                'removed_from_store' => $subcategory->removed_from_store,
            ]);

            $category_order = CategoryOrder::where('subcategory_id', $subcategory->id)->first();
            $category_order->active = ! $subcategory->removed_from_store;
            $category_order->save();

            $message = $subcategory->removed_from_store
                ? __('Subcategory removed from store.')
                : __('Subcategory restored to store.');
        } else {
            return back()->with('alert_error', __('Invalid request.'));
        }

        return back()->with('alert_success', $message);
    }

    public function categorySlider(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);

        if ($request->input('category_id')) {
            $category = Category::where('id', $request->input('category_id'))->first();
            if ($category->is_slider == true) {
                $category->is_slider = false;
            } else {
                $category->is_slider = true;
            }
            $category->save();
        }

        if ($request->input('subcategory_id')) {
            $subcategory = Subcategory::where('id', $request->input('subcategory_id'))->first();
            if ($subcategory->is_slider == true) {
                $subcategory->is_slider = false;
            } else {
                $subcategory->is_slider = true;
            }
            $subcategory->save();
        }
        //             dd($category->name);

        //        return  view('frontend.htmx.htmx_notification')->with('alert_success',__('Updated successfully'));

        return back()->with('alert_success', __('Updated successfully'));

    }
}
