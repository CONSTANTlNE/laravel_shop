<?php

namespace App\Services;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminService
{
    /**
     * Create a new class instance.
     */
    public function allProducts($request)
    {

        $perPage = (int) $request->query('per_page', 20);
        if ($perPage < 1) {
            $perPage = 10;
        }
        if ($perPage > 100) {
            $perPage = 100;
        }

        $sortBy = $request->query('sort_by', 'id');
        $sortDir = strtolower($request->query('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSorts = [
            'created_at',
            'name',
            'category_name',
            'subcategory_name',
            'stock',
            'price',
            'in_stock',
            'show_in_main',
            'id',
        ];
        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'id';
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
            $query->where('products.category_id', (int) $request->query('category_id'));
        }
        if ($request->filled('subcategory_id')) {
            $query->where('products.subcategory_id', (int) $request->query('subcategory_id'));
        }
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        if (is_numeric($minPrice)) {
            $query->where('products.price', '>=', (float) $minPrice);
        }
        if (is_numeric($maxPrice)) {
            $query->where('products.price', '<=', (float) $maxPrice);
        }

        // Date range filter
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        if (! empty($dateFrom)) {
            try {
                $from = Carbon::parse($dateFrom)->startOfDay();
                $query->where('products.created_at', '>=', $from);
            } catch (\Throwable $e) {
                // ignore invalid date
            }
        }
        if (! empty($dateTo)) {
            try {
                $to = Carbon::parse($dateTo)->endOfDay();
                $query->where('products.created_at', '<=', $to);
            } catch (\Throwable $e) {
                // ignore invalid date
            }
        }

        // Search
        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $like = '%'.$search.'%';
            $query->where(function ($q) use ($like, $locale, $search) {
                $q->where('products.sku', 'ILIKE', $like)
                    ->orWhere('products.slug', 'ILIKE', $like)
                    ->orWhere(DB::raw("products.name ->> '{$locale}'"), 'ILIKE', $like)
                    ->orWhere(DB::raw("products.description ->> '{$locale}'"), 'ILIKE', $like)
                    ->orWhere(DB::raw("categories.name ->> '{$locale}'"), 'ILIKE', $like)
                    ->orWhere(DB::raw("subcategories.name ->> '{$locale}'"), 'ILIKE', $like)
                    ->orWhere('products.id', (int) $search);
            });
        }

        // Discounts / Coupons filter
        $discountsFilter = $request->query('discounts');
        if ($discountsFilter === 'discounted') {
            $query->whereNotNull('products.discount_id');
        } elseif ($discountsFilter === 'coupons') {
            $query->whereNotNull('products.coupon_id');
        }

        // Sorting
        if ($sortBy) {
            if (in_array($sortBy, ['category_name', 'subcategory_name'], true)) {
                $query->orderBy(DB::raw($sortBy), $sortDir);
            } else {
                $query->orderBy('products.'.$sortBy, $sortDir);
            }
        } else {
            // Default order
            $query->orderBy('products.id', 'desc');
        }

        $products = $query->paginate($perPage)->appends($request->query());

        return [
            'products' => $products,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
        ];

    }

    public function soldProducts($request)
    {
        $perPage = (int) $request->query('per_page', 20);
        if ($perPage < 1) {
            $perPage = 10;
        }
        if ($perPage > 100) {
            $perPage = 100;
        }

        $sortBy = $request->query('sort_by', 'id');
        $sortDir = strtolower($request->query('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSorts = [
            'created_at',       // order_items.created_at
            'product_name',     // products.name (localized)
            'category_name',    // categories.name (localized)
            'subcategory_name', // subcategories.name (localized)
            'quantity',
            'product_price',
        ];
        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }

        $locale = app()->getLocale();

        $query = OrderItem::query()
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->select('order_items.*')
            ->selectRaw("products.name ->> '{$locale}' as product_name")
            ->selectRaw("categories.name ->> '{$locale}' as category_name")
            ->selectRaw("subcategories.name ->> '{$locale}' as subcategory_name")
            ->with(['product.category', 'product.subcategory', 'product.features', 'product.discount', 'order']);

        // Filtering (similar to allProducts)
        if ($request->filled('category_id')) {
            $query->where('products.category_id', (int) $request->query('category_id'));
        }
        if ($request->filled('subcategory_id')) {
            $query->where('products.subcategory_id', (int) $request->query('subcategory_id'));
        }
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        if (is_numeric($minPrice)) {
            $query->where('order_items.product_price', '>=', (float) $minPrice);
        }
        if (is_numeric($maxPrice)) {
            $query->where('order_items.product_price', '<=', (float) $maxPrice);
        }

        // Date range filter (by sold date)
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        if (! empty($dateFrom)) {
            try {
                $from = Carbon::parse($dateFrom)->startOfDay();
                $query->where('order_items.created_at', '>=', $from);
            } catch (\Throwable $e) {
                // ignore invalid date
            }
        }
        if (! empty($dateTo)) {
            try {
                $to = Carbon::parse($dateTo)->endOfDay();
                $query->where('order_items.created_at', '<=', $to);
            } catch (\Throwable $e) {
                // ignore invalid date
            }
        }

        $discountsFilter = $request->query('discounts');
        if ($discountsFilter === 'discounted') {
            $query->whereNotNull('products.discount_id');
        } elseif ($discountsFilter === 'coupons') {
            $query->whereNotNull('products.coupon_id');
        }

        // Search
        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $like = '%'.$search.'%';
            $query->where(function ($q) use ($like, $locale, $search) {
                $q->where('products.sku', 'ILIKE', $like)
                    ->orWhere('products.slug', 'ILIKE', $like)
                    ->orWhere(DB::raw("products.name ->> '{$locale}'"), 'ILIKE', $like)
                    ->orWhere(DB::raw("products.description ->> '{$locale}'"), 'ILIKE', $like)
                    ->orWhere(DB::raw("categories.name ->> '{$locale}'"), 'ILIKE', $like)
                    ->orWhere(DB::raw("subcategories.name ->> '{$locale}'"), 'ILIKE', $like)
                    ->orWhere('order_items.id', (int) $search)
                    ->orWhereHas('order', function ($oq) use ($like, $search) {
                        $oq->where('order_token', 'ILIKE', $like)
                            ->orWhere('id', (int) $search);
                    });
            });
        }

        // Sorting
        if ($sortBy === 'product_name' || $sortBy === 'category_name' || $sortBy === 'subcategory_name') {
            $query->orderBy(DB::raw($sortBy), $sortDir);
        } else {
            $query->orderBy('order_items.'.$sortBy, $sortDir);
        }

        $order_items = $query->paginate($perPage)->appends($request->query());

        return [
            'order_items' => $order_items,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
        ];
    }

    public function allCategories($request)
    {

        $perPage = (int) $request->query('per_page', 20);
        if ($perPage < 1) {
            $perPage = 10;
        }
        if ($perPage > 100) {
            $perPage = 100;
        }

        $sortBy = $request->query('sort_by', 'id');
        $sortDir = strtolower($request->query('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSorts = [
            'created_at',
            'name',
        ];

        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'id';
        }

        $locale = app()->getLocale();

        $subcategoryId = $request->filled('subcategory_id') ? (int) $request->query('subcategory_id') : null;

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
            $query->where('id', (int) $request->query('category_id'));
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

        return [
            'categories' => $categories,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
        ];

    }
}
