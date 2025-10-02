<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function allProducts(Request $request)
    {
        $perPage = (int)$request->query('per_page', 20);
        if ($perPage < 1) {
            $perPage = 10;
        }
        if ($perPage > 100) {
            $perPage = 100;
        }

        $sortBy = $request->query('sort_by', 'created_at');
        $sortDir = strtolower($request->query('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSorts = [
            'created_at',
            'name',
            'category_name',
            'subcategory_name',
            'stock',
            'price',
            'in_stock',
            'show_in_main'
        ];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }

        $locale = app()->getLocale();

        $query = Product::query()
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->select('products.*')
            ->selectRaw("categories.name ->> '{$locale}' as category_name")
            ->selectRaw("subcategories.name ->> '{$locale}' as subcategory_name")
            ->with(['category', 'subcategory', 'features', 'discount']);

        // Filtering
        if ($request->filled('category_id')) {
            $query->where('products.category_id', (int)$request->query('category_id'));
        }
        if ($request->filled('subcategory_id')) {
            $query->where('products.subcategory_id', (int)$request->query('subcategory_id'));
        }
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        if (is_numeric($minPrice)) {
            $query->where('products.price', '>=', (float)$minPrice);
        }
        if (is_numeric($maxPrice)) {
            $query->where('products.price', '<=', (float)$maxPrice);
        }

        // Sorting
        if ($sortBy) {
            if (in_array($sortBy, ['category_name', 'subcategory_name'], true)) {
                $query->orderBy(DB::raw($sortBy), $sortDir);
            } else {
                $query->orderBy('products.' . $sortBy, $sortDir);
            }
        } else {
            // Default order
            $query->orderBy('products.id', 'desc');
        }

        $products = $query->paginate($perPage)->appends($request->query());

        $categories = Category::orderBy('order')->get(['id', 'name']);
        $subcategories = Subcategory::orderBy('order')->get(['id', 'name', 'category_id']);
        $discounts = Discount::where('active', 1)->get();
        $count = Product::count();

        return view('backend.admin_products', compact('products', 'categories', 'subcategories', 'sortBy', 'sortDir', 'count', 'discounts'));
    }

    public function allCategories(Request $request)
    {
        $perPage = (int)$request->query('per_page', 20);
        if ($perPage < 1) {
            $perPage = 10;
        }
        if ($perPage > 100) {
            $perPage = 100;
        }

        $sortBy = $request->query('sort_by', 'created_at');
        $sortDir = strtolower($request->query('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSorts = [
            'created_at',
            'name',
        ];

        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }

        $locale = app()->getLocale();

        $subcategoryId = $request->filled('subcategory_id') ? (int)$request->query('subcategory_id') : null;


        $query = Category::query()
            ->with(['subcategories.categoryOrder', 'subcategories' => function ($q) use ($subcategoryId) {
                if ($subcategoryId) {
                    $q->where('id', $subcategoryId);
                }
                $q->withCount('products');
            }])
            ->with('categoryOrder')
            ->select('categories.*')
            ->selectRaw("name ->> '{$locale}' as category_name")
            ->withCount('subcategories')
            ->withCount('products');

        // Filtering
        if ($request->filled('category_id')) {
            $query->where('id', (int)$request->query('category_id'));
        }
        if ($subcategoryId) {
            $query->whereHas('subcategories', function ($q) use ($subcategoryId) {
                $q->where('id', $subcategoryId);
            });
        }

        // Sorting
        if ($sortBy === 'name' || $sortBy === 'category_name') {
            $query->orderBy(DB::raw("name ->> '{$locale}'"), $sortDir);
        } else {
            $query->orderBy($sortBy, $sortDir);
        }

        $categories = $query->paginate($perPage)->appends($request->query());
        $subcategories = Subcategory::orderBy('order')->get(['id', 'name', 'category_id']);
        $discounts = Discount::where('active', 1)->get();
        $count = Category::count();
        $settings=Setting::first();

        return view('backend.admin_categories', compact('categories', 'settings','count', 'subcategories', 'sortBy', 'sortDir', 'discounts'));
    }
}
