<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Promoter;
use App\Models\Subcategory;
use App\Services\CartService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        $coupons = Coupon::all();
        $promoters = Promoter::all();

        return view('backend.admin_coupons', compact('coupons', 'promoters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'percent' => 'required|numeric|min:1|max:100',
            'valid_till' => 'required|date',
            'promo_code' => 'required|string|min:5|max:100',
            'comment' => 'nullable|string|max:255',
            'promoter_id' => 'required|numeric|exists:promoters,id',
        ]);

        $promoter = Promoter::findOrFail($request->promoter_id);

        // Start with the provided promo_code
        $code = strtoupper($request->promo_code);

        // Ensure uniqueness
        while (Coupon::where('code', $code)->exists()) {
            $code = $this->generateCode(8); // fallback to random code if duplicate
        }

        $coupon = new Coupon;
        $coupon->promoter_id = $promoter->id;
        $coupon->promoter_name = $promoter->name;
        $coupon->discount_percentage = $request->percent;
        $coupon->valid_till = $request->valid_till;
        $coupon->comment = $request->comment;
        $coupon->code = $code;
        $coupon->save();

        return redirect()->back()->with('success', 'Coupon created successfully!');
    }

    public function update(Request $request) {}

    public function delete(Request $request)
    {

        $coupon = Coupon::find($request->coupon_id);

        if (! $coupon) {
            return back()->with('alert_error', 'Coupon not found!');
        }

        $products = $coupon->products;

        if ($products->count() > 0) {
            return back()->with('alert_error', 'Coupon cannot be deleted because it applied products.');
        } else {
            $coupon->delete();
        }

        return back()->with('alert_success', 'Coupon deleted successfully!');

    }

    public function activate(Request $request)
    {
        $request->validate([
            'coupon_id' => 'required|numeric|exists:coupons,id',
        ]);

        $coupon = Coupon::find($request->coupon_id);

        if ($coupon->active == 1) {
            $coupon->active = 0;
        } else {
            $coupon->active = 1;
        }
        $coupon->save();

        return back()->with('alert_success', 'Status updated successfully!');

    }

    public function couponApplyCategory(Request $request)
    {

        $request->validate([
            'coupon_id' => 'required|numeric|exists:coupons,id',
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

        foreach ($products as $product) {
            $product->coupon_id = $request->coupon_id;
            $product->save();
        }

        return back()->with('alert_success', 'Coupon applied successfully!');

    }

    public function couponApplyProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric|exists:products,id',
            'coupon_id' => 'required|numeric|exists:coupons,id',
        ]);

        $product = Product::where('id', $request->product_id)->first();
        $product->coupon_id = $request->coupon_id;
        $product->save();

        return back()->with('alert_success', 'Coupon Added successfully!');

    }

    public function couponRemoveProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric|exists:products,id',
            'coupon_id' => 'required|numeric|exists:coupons,id',
        ]);

        $product = Product::where('id', $request->product_id)->first();
        $product->coupon_id = null;
        $product->save();

        return back()->with('alert_success', 'Coupon Removed successfully!');

    }

    public function couponRemoveCategory(Request $request)
    {

        $request->validate([
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

        foreach ($products as $product) {
            $product->coupon_id = null;
            $product->save();
        }

        return back()->with('alert_success', 'Coupon Removed successfully!');

    }

    public function useCoupon(Request $request)
    {

        $request->validate([
            'coupon_code' => 'required|string|exists:coupons,code',
        ]);

        $coupon_discount = Coupon::where('code', $request->coupon_code)
            ->with('products')
            ->first();

        if ($coupon_discount->valid_till < now()) {
            return back()->with('alert_error', 'Coupon expired!');
        }

        if ($coupon_discount->active == 0) {
            return back()->with('alert_error', 'Coupon is not active!');
        }

        $cartItems = $this->cart->getCart();

        foreach ($cartItems as $item) {
            // if product has discount and coupon discount is greater .. then apply difference between coupon discount percentage and ordinary discount percentage...

            if ($coupon_discount->use_with_ordinary_discount == 1) {
                // apply coupon only to relevant product
                if ($coupon_discount->products->contains('id', $item->product_id)) {
                    if ($item->product->discount && $item->product->discount->discount_percentage < $coupon_discount->discount_percentage) {
                        $discount = round($item->product->price_before_discount * (($coupon_discount->discount_percentage - $item->product->discount->discount_percentage) / 100), 2);
                        $item->coupon_discount = $discount;
                        $item->product_total = $item->product_price * $item->quantity - $item->coupon_discount * $item->quantity;
                        $item->coupon_id = $coupon_discount->id;
                        $item->save();
                    } else {
                        $discount = round($item->product->price * ($coupon_discount->discount_percentage / 100), 2);
                        $item->coupon_discount = $discount;
                        $item->product_total = $item->product_price * $item->quantity - $item->coupon_discount * $item->quantity;
                        $item->coupon_id = $coupon_discount->id;
                        $item->save();
                    }
                }
            }
        }

        // ================  need for htmx =====================

        $data = $this->cart->getSummary($cartItems);

        $hascoupon = $data['hascoupon'];
        $promo_code = $data['promo_code'];
        $total_coupon_discount = $data['total_coupon_discount'];
        $cities = $data['cities'];
        $total_value = $data['total_value'];
        $total_value_no_discount = $data['total_value_no_discount'];
        $discount_value = $data['discount_value'];
        $shipping_cost = $data['shipping_cost'];
        $grand_total = $data['grand_total'];

        return view('frontend.cart.totals_htmx', compact('grand_total', 'shipping_cost', 'cartItems', 'hascoupon', 'promo_code', 'total_coupon_discount', 'cities', 'total_value', 'discount_value', 'total_value_no_discount'));

    }

    private function generateCode($length = 6)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $sku = '';
        for ($i = 0; $i < $length; $i++) {
            $sku .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $sku;
    }
}
