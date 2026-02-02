<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function add(Request $request)
    {

        $item = $this->cart->add($request->product_id);

        $owner = $this->cart->getCartOwner();

        // --- DB Cart ---
        if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
            $query = CartItem::where('cart_token', request()->cookie('cart_token'))
                ->where('owner_id', $owner->id);
            $carttotal = $query->sum('quantity');

        } else {
            $query = CartItem::where('cart_token', request()->cookie('cart_token'))
                ->where('owner_id', null);
            $carttotal = $query->sum('quantity');

        }

        // ============================     ==============================

        $data = $this->cart->getSummary();

        $hascoupon = $data['hascoupon'];
        $promo_code = $data['promo_code'];
        $total_coupon_discount = $data['total_coupon_discount'];
        $cities = $data['cities'];
        $total_value = $data['total_value'];
        $total_value_no_discount = $data['total_value_no_discount'];
        $discount_value = $data['discount_value'];
        $shipping_cost = $data['shipping_cost'];
        $grand_total = $data['grand_total'];

        $is_cart = $request->is_cart;
        $product_id = $request->product_id;

        return view('frontend.cart.cart_count_htmx', compact('grand_total', 'carttotal', 'is_cart', 'item', 'product_id', 'discount_value', 'total_value', 'total_value_no_discount', 'hascoupon', 'promo_code', 'total_coupon_discount', 'cities', 'shipping_cost'));
    }

    public function addSingle(Request $request)
    {

        $this->cart->add($request->product_id);

        $owner = $this->cart->getCartOwner();

        if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
            $query = CartItem::where('cart_token', request()->cookie('cart_token'))
                ->where('owner_id', $owner->id);
            $carttotal = $query->sum('quantity');

        } else {
            $query = CartItem::where('cart_token', request()->cookie('cart_token'))
                ->where('owner_id', null);
            $carttotal = $query->sum('quantity');

        }
        $product = $request->product_id;

        return view('frontend.cart.cart_count_product_single', compact('carttotal', 'owner', 'product'));
    }

    public function remove(Request $request)
    {
        $item = $this->cart->remove($request->product_id);

        $owner = $this->cart->getCartOwner();
        // --- DB Cart ---
        if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
            $query = CartItem::where('cart_token', request()->cookie('cart_token'))
                ->where('owner_id', $owner->id);
            $carttotal = $query->sum('quantity');

        } else {
            $query = CartItem::where('cart_token', request()->cookie('cart_token'))
                ->where('owner_id', null);
            $carttotal = $query->sum('quantity');
        }

        $is_cart = $request->is_cart;

        // ================================================================

        $data = $this->cart->getSummary();

        $hascoupon = $data['hascoupon'];
        $promo_code = $data['promo_code'];
        $total_coupon_discount = $data['total_coupon_discount'];
        $cities = $data['cities'];
        $total_value = $data['total_value'];
        $total_value_no_discount = $data['total_value_no_discount'];
        $discount_value = $data['discount_value'];
        $shipping_cost = $data['shipping_cost'];
        $grand_total = $data['grand_total'];

        if ($item == null) {
            return response()
                ->view('frontend.cart.cart_count_htmx', compact('grand_total', 'carttotal', 'is_cart', 'item', 'total_value', 'total_value_no_discount', 'discount_value', 'hascoupon', 'promo_code', 'total_coupon_discount', 'cities', 'shipping_cost'))
                ->withHeaders([
                    'hx-trigger' => json_encode(['remove_cart_item' => ['id' => $request->cart_id]]),
                ]);
        }

        return view('frontend.cart.cart_count_htmx', compact('grand_total', 'carttotal', 'item', 'is_cart', 'total_value', 'total_value_no_discount', 'discount_value', 'hascoupon', 'promo_code', 'total_coupon_discount', 'cities', 'shipping_cost'));
    }

    public function delete(Request $request)
    {

        $this->cart->deleteItem($request->product_id);

        $owner = $this->cart->getCartOwner();
        // --- DB Cart ---
        if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
            $query = CartItem::where('cart_token', request()->cookie('cart_token'))
                ->where('owner_id', $owner->id);
            $carttotal = $query->sum('quantity');
            $item = $query->first();
        } else {
            $query = CartItem::where('cart_token', request()->cookie('cart_token'))
                ->where('owner_id', null);
            $carttotal = $query->sum('quantity');
            $item = $query->first();
        }

        // ================================================================

        $data = $this->cart->getSummary();

        $hascoupon = $data['hascoupon'];
        $promo_code = $data['promo_code'];
        $total_coupon_discount = $data['total_coupon_discount'];
        $cities = $data['cities'];
        $total_value = $data['total_value'];
        $total_value_no_discount = $data['total_value_no_discount'];
        $discount_value = $data['discount_value'];
        $shipping_cost = $data['shipping_cost'];
        $grand_total = $data['grand_total'];

        $is_cart = $request->is_cart;
        $product_id = $request->product_id;

        return view('frontend.cart.cart_count_htmx', compact('grand_total', 'carttotal', 'is_cart', 'item', 'product_id', 'total_value', 'discount_value', 'total_value_no_discount', 'discount_value', 'hascoupon', 'promo_code', 'total_coupon_discount', 'cities', 'shipping_cost'));

    }

    public function cartItems(Request $request)
    {

        $cartItems = $this->cart->getCart();

        $total_value = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $total_value_no_discount = $cartItems->sum(function ($item) {
            // Check if the item has a price_before_discount value
            if ($item->product->price_before_discount) {
                return $item->product->price_before_discount * $item->quantity;
            } else {
                return $item->product->price * $item->quantity;
            }
        });

        $discount_value = $cartItems->sum(function ($item) {
            if ($item->product->price_before_discount) {
                return ($item->product->price_before_discount - $item->product->price) * $item->quantity;
            } else {
                return 0;
            }
        });

        //   needs to be false only for cart modal
        $hascoupon = false;

        return view('frontend.cart.cart_items_htmx', compact('cartItems', 'total_value', 'discount_value', 'total_value_no_discount', 'hascoupon'));
    }

    public function checkout(Request $request)
    {
        $cartItems = $this->cart->getCart();

        if ($cartItems->isEmpty()) {
            return to_route('home')->with('alert_error', 'Cart is empty');
        }

        $data = $this->cart->getSummary($cartItems);

        // if set min purchase and cart value is less than min purchase return back
        $min_purchase = Setting::first();

        if ($min_purchase->min_order_amount > $data['total_value']) {
            return back()->withInput()->with('alert_error', __('Minimum purchase amount is').' '.$min_purchase->min_order_amount.' ₾');
        }

        $hascoupon = $data['hascoupon'];
        $promo_code = $data['promo_code'];
        $total_coupon_discount = $data['total_coupon_discount'];
        $cities = $data['cities'];
        $total_value = $data['total_value'];
        $total_value_no_discount = $data['total_value_no_discount'];
        $discount_value = $data['discount_value'];
        $shipping_cost = $data['shipping_cost'];
        $grand_total = $data['grand_total'];

        return view('frontend.checkout', compact('grand_total', 'shipping_cost', 'cartItems', 'total_value', 'hascoupon', 'total_coupon_discount', 'promo_code', 'discount_value', 'total_value_no_discount', 'cities'));
    }

    public function carts(Request $request)
    {
        $perPage = (int) $request->query('per_page', 30);
        if ($perPage <= 0) {
            $perPage = 30;
        }

        $sortBy = in_array($request->query('sort_by'), ['created_at', 'order_token', 'grand_total', 'address', 'bank_order_id'])
            ? $request->query('sort_by')
            : 'created_at';
        $sortDir = strtolower($request->query('sort_dir')) === 'asc' ? 'asc' : 'desc';

        $cartsQuery = CartItem::with(['product', 'owner', 'couponDiscount'])
            ->select('cart_token')
            ->selectRaw('SUM(product_total) as product_total')
            ->selectRaw('MAX(id) as id')
            ->selectRaw('MAX(product_id) as product_id')
            ->selectRaw('MAX(owner_id) as owner_id')          // Polymorphic ID
            ->selectRaw('MAX(owner_type) as owner_type')      // Polymorphic Type (CRITICAL)
            ->selectRaw('MAX(coupon_id) as coupon_id')
            ->selectRaw('MAX(created_at) as created_at')
            ->groupBy('cart_token');

        // Search across amount (grand_total), address, and bank order id
        if ($q = trim((string) $request->query('q', ''))) {
            $cartsQuery->where(function ($builder) use ($q) {
                $builder->where('address', 'like', "%{$q}%")
                    ->orWhere('bank_order_id', 'like', "%{$q}%")
                    ->orWhere('order_token', 'like', "%{$q}%");
                // If query is numeric, try matching grand_total approximately
                if (is_numeric(str_replace([','], ['.'], $q))) {
                    $num = (float) str_replace([','], ['.'], $q);
                    $builder->orWhere('grand_total', $num)
                        ->orWhere('grand_total', 'like', "%{$q}%");
                } else {
                    $builder->orWhere('grand_total', 'like', "%{$q}%");
                }
            });
        }

        $carts = $cartsQuery
            ->orderBy($sortBy === 'created_at' ? 'created_at' : $sortBy, $sortDir)
            ->paginate($perPage)
            ->appends(request()->query());

        return view('backend.admin_carts', compact('carts', 'sortBy', 'sortDir'));
    }

    public function getProducts(Request $request)
    {

        $products = CartItem::with('product')
            ->where('cart_token', $request->query('cart_token'))
            ->get();

        dd($products);

    }
}
