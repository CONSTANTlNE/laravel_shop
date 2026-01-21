<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $discounts = Discount::all();

        return view('backend.admin_discounts', compact('discounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'valid_till' => 'required',
            'percent' => 'required|numeric',
            'comment' => 'nullable|string',
        ]);

        $discount = new Discount;
        $discount->valid_till = $request->valid_till;
        $discount->discount_percentage = $request->percent;
        if ($request->has('increase_price')) {
            $discount->increase_price = 1;
        } else {
            $discount->increase_price = 0;
        }
        $discount->comment = $request->comment;
        $discount->save();

        return back()->with('alert_success', 'Discount Added Successfully');

    }

    public function discountApplyCategory(Request $request)
    {

        $request->validate([
            'discount_id' => 'required|numeric|exists:discounts,id',
            'category_id' => 'required|numeric',
            'category_slug' => 'required|string',
        ]);

        $findcategory = Category::where('id', $request->input('category_id'))
            ->where('slug', $request->input('category_slug'))
            ->first();

        if ($findcategory) {
            $category = $findcategory;
        } else {
            $findsubcategory = Subcategory::where('id', $request->input('category_id'))
                ->where('slug', $request->input('category_slug'))
                ->first();
            if ($findsubcategory) {
                $category = $findsubcategory;
            } else {
                return back()->with('alert_error', 'Category or Subcategory not found');
            }
        }

        $products = $category->products;

        $discount = Discount::find($request->discount_id);

        foreach ($products as $product) {
            if ($product->discounted == 0) {
                $discounted_price = $product->price - round($product->price * $discount->discount_percentage / 100, 2);

                $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
                $historyEntry = [
                    'id' => $code,
                    'update_date' => now()->toDateString(),
                    'price' => $discounted_price,
                    'user_id' => auth()->id(),
                    'discount_id' => $request->discount_id,
                    'discount%' => $discount->discount_percentage,
                    'reason' => 'discounted',
                ];

                $history = $product->price_history ?? [];
                $history[] = $historyEntry;

                $product->price_before_discount = $product->price;
                $product->discount_percentage = $discount->discount_percentage;
                $product->price = $discounted_price;
                $product->price_history = $history;
                $product->discounted = 1;
                $product->discount_id = $discount->id;
                $product->save();
            }
        }

        return back()->with('alert_success', 'Discount Applied Successfully');
    }

    public function discountRemoveCategory(Request $request) {}

    public function discountApplyProduct(Request $request)
    {

        $request->validate([
            'discount_id' => 'required|exists:discounts,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);
        $discount = Discount::find($request->discount_id);

        $discounted_price = $product->price - round($product->price * $discount->discount_percentage / 100, 2);

        $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $historyEntry = [
            'id' => $code,
            'update_date' => now()->toDateString(),
            'price' => $discounted_price,
            'user_id' => auth()->id(),
            'discount_id' => $request->discount_id,
            'discount%' => $discount->discount_percentage,
            'reason' => 'discounted',
        ];

        $history = $product->price_history ?? [];
        $history[] = $historyEntry;

        $product->price_before_discount = $product->price;
        $product->discount_percentage = $discount->discount_percentage;
        $product->price = $discounted_price;
        $product->price_history = $history;
        $product->discounted = 1;
        $product->discount_id = $discount->id;
        $product->save();

        return back()->with('alert_success', 'Discount Applied Successfully');

    }

    public function discountRemoveProduct(Request $request)
    {

        $request->validate([
            'discount_id' => 'required|exists:discounts,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);

        if ($request->has('increase_price')) {

            $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            $historyEntry = [
                'id' => $code,
                'update_date' => now()->toDateString(),
                'price' => $product->price_before_discount,
                'user_id' => auth()->id(),
                'discount_id' => '',
                'discount%' => '',
                'reason' => 'discount removed',
            ];

            $history = $product->price_history ?? [];
            $history[] = $historyEntry;
            $product->price_history = $history;
            $product->price = $product->price_before_discount;
        }

        $product->discount_percentage = null;
        $product->price_before_discount = null;
        $product->discounted = 0;
        $product->discount_id = null;
        $product->save();

        return back()->with('alert_success', 'Discount Applied Successfully');

    }

    public function discountDelete(Request $request) {}
}
