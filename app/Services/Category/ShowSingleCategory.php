<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Models\CategoryOrder;
use App\Models\Subcategory;

class ShowSingleCategory
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function showSingle($request, $locale, $slug)
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
                // Use reorder to override default orderBy from relationship (e.g., 'order')
                $productsQuery->reorder('price', $sortDir);
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
                // Override default relationship ordering when sorting by price
                $productsQuery->reorder('price', $sortDir);
            }

            $subcategory->setRelation('products', $productsQuery->get());
            // Ensure view safety for subcategory by providing an empty subcategories collection
            $subcategory->setRelation('subcategories', collect());

            $category = $subcategory; // Keep variable name expected by the view
            $subcategories = collect();
        }

        return [
            'category' => $category,
            'subcategories' => $subcategories,
            'productsCount' => $productsCount,
            'categoriesCount' => $categoriesCount,
            'category_orders' => $category_orders,
        ];
    }
}
