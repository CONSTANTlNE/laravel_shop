<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Models\CategoryOrder;
use App\Models\Subcategory;

class ChangeCategoryMain
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function changeMain($request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);

        if ($request->input('category_id')) {
            $category = Category::where('id', $request->input('category_id'))->first();
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

        if ($request->input('subcategory_id')) {
            $subcategory = Subcategory::where('id', $request->input('subcategory_id'))->first();
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
    }
}
