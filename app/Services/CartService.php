<?php

namespace App\Services;

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ShippingPrice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    protected $sessionKey = 'cart';

    protected function getToken()
    {
        return request()->cookie('cart_token');
    }

    public function getCartOwner()
    {
        foreach (['web', 'admin'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }

        return null; // no authenticated owner
    }

    public function add($productId, $quantity = 1)
    {
        $owner = $this->getCartOwner();
        $product = Product::find($productId);
        if ($owner) {
            // Logged in (via web or admin)
            $cartItem = CartItem::where('owner_id', $owner->id)
                ->where('owner_type', get_class($owner))
                ->where('product_id', $productId)
                ->first();

            $city_id = CartItem::where('owner_id', $owner->id)
                ->where('owner_type', get_class($owner))
                ->first()?->city_id;

            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
                $cartItem->product_total = $cartItem->product_price * $cartItem->quantity - $cartItem->coupon_discount * $cartItem->quantity;
                $cartItem->save();

            } else {
                $owner->cartItems()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'cart_token' => $this->getToken(),
                    'city_id' => $city_id,
                    'product_price' => $product->price,
                    'product_total' => $product->price,
                ]);
            }

        } else {
            // Guest customer (cart_token only)
            $cartItem = CartItem::firstOrCreate(
                [
                    'cart_token' => $this->getToken(),
                    'owner_id' => null,
                    'owner_type' => null,
                    'product_id' => $productId,
                    'product_price' => $product->price,
                ],
                ['quantity' => 0]
            );

            $cartItem->increment('quantity', $quantity);
            $cartItem->product_total = $cartItem->quantity * $cartItem->product->price;
            $cartItem->save();
        }

        return $cartItem;

    }

    public function remove($productId, $quantity = 1)
    {

        //        dd($productId);
        $owner = $this->getCartOwner();

        // --- DB Cart ---
        if (Auth::guard('admin')->check() || Auth::guard('web')->check()) {
            // Logged in customer
            $cartItem = CartItem::where('owner_id', $owner->id)
                ->where('product_id', $productId)
                ->first();
        } else {
            // Guest customer
            $cartItem = CartItem::where('owner_id', null)
                ->where('product_id', $productId)
                ->where('cart_token', $this->getToken())
                ->first();
        }

        if ($cartItem) {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity', $quantity);
                $cartItem->product_total = $cartItem->product_price * $cartItem->quantity - $cartItem->coupon_discount * $cartItem->quantity;
                $cartItem->save();

                return $cartItem->fresh(); // Reload from DB (updated quantity)
            } else {
                $cartItem->delete();

                return null; // Because it's deleted
            }
        }

        return null;

    }

    public function deleteItem($productId)
    {
        $owner = $this->getCartOwner();
        // DB
        if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
            CartItem::where('owner_id', $owner->id)->where('product_id', $productId)->delete();
        } else {
            CartItem::where('cart_token', $this->getToken())->where('product_id', $productId)->delete();
        }
    }

    public function getCart()
    {
        $owner = $this->getCartOwner();
        if ($owner) {
            return CartItem::where('owner_id', $owner->id)->where('owner_type', get_class($owner))
                ->with('product.coupon', 'product.discount', 'product.presents')
                ->get();
        } else {
            return CartItem::with('product.media')->where('cart_token', $this->getToken())
                ->where('owner_id', null)
                ->with('product.coupon', 'product.presents')
                ->get();
        }
    }

    public function couponIds()
    {
        return $this->getCart()
            ->pluck('coupon_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();
    }

    // Merge guest cart into customer cart after login
    public function mergeGuestCart()
    {
        $token = $this->getToken();
        if (! $token) {
            return;
        }

        // Determine authenticated owner (web/admin)
        $owner = null;
        foreach (['web', 'admin'] as $guard) {
            if (Auth::guard($guard)->check()) {
                $owner = Auth::guard($guard)->user();
                break;
            }
        }

        if (! $owner) {
            return;
        } // no logged-in owner, nothing to merge

        // 1️⃣ Merge guest cart items
        $guestCart = CartItem::where('cart_token', $token)
            ->whereNull('owner_id')
            ->get();

        foreach ($guestCart as $item) {
            $existing = CartItem::where('product_id', $item->product_id)
                ->where('owner_id', $owner->id)
                ->where('owner_type', get_class($owner))
                ->first();

            if ($existing) {
                $existing->quantity += $item->quantity;
                $existing->cart_token = $token; // override token
                $existing->save();
                $item->delete(); // remove duplicate guest item
            } else {
                $item->owner()->associate($owner);
                $item->cart_token = $token; // override token
                $item->save();
            }
        }

        // 2️⃣ Update ALL of the customer's existing cart items to use the current token
        CartItem::where('owner_id', $owner->id)
            ->where('owner_type', get_class($owner))
            ->update(['cart_token' => $token]);

        // 3️⃣ Clear session cart if needed
        session()->forget($this->sessionKey);
    }

    public function getSummary($cartItems = null, $city_id = null)
    {
        if ($cartItems === null) {
            $cartItems = $this->getCart();
        }

        // --- Totals ---
        $total_value = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity
        );

        $total_value_no_discount = $cartItems->sum(function ($item) {
            $price = $item->product->price_before_discount ?? $item->product->price;

            return $price * $item->quantity;
        });

        $discount_value = $cartItems->sum(function ($item) {
            if ($item->product->price_before_discount) {
                return ($item->product->price_before_discount - $item->product->price) * $item->quantity;
            }

            return 0;
        });

        // --- Coupon Handling ---
        $hascoupon = false;
        $promo_code = null;
        $total_coupon_discount = 0;

        if ($cartItems->contains(fn ($item) => $item->product->coupon && $item->product->coupon->id)) {
            $hascoupon = true;

            $couponItem = $cartItems->first(fn ($item) => $item->product->coupon && $item->coupon_id);
            $promo_code = $couponItem->product->coupon->code ?? null;

            $total_coupon_discount = $cartItems->sum(fn ($item) => $item->quantity * ($item->coupon_discount ?? 0)
            );

            $total_value -= $total_coupon_discount;
        }

        // ============  Shipping  =============

        $shipping_prices = ShippingPrice::where('is_active', 1)
            ->with('city')
            ->get();

        $cities = $shipping_prices->pluck('city')->unique('id')->values();

        if ($city_id == null) {
            $city_id = $cartItems->first()?->city_id;
        }

        $shipping_calc = $shipping_prices
            ->filter(fn ($item) => $item->city_id == $city_id &&
                $item->upper_range <= $total_value
            )
            ->sortByDesc('upper_range')
//            ->sortBy('upper_range')
            ->first();

        if ($shipping_calc == null) {
            $shipping_cost = round($shipping_prices->where('city_id', $city_id)->last()?->rate);
        } else {
            $shipping_cost = round($shipping_calc->rate);
        }

        $grand_total = $total_value + $shipping_cost;

        // dd($shipping_cost,$shipping_calc?->rate);
        // --- Return everything in a clean structure ---
        return [
            'total_value' => $total_value,
            'total_value_no_discount' => $total_value_no_discount,
            'discount_value' => $discount_value,
            'hascoupon' => $hascoupon,
            'promo_code' => $promo_code,
            'total_coupon_discount' => $total_coupon_discount,
            'shipping_prices' => $shipping_prices,
            'cities' => $cities,
            'shipping_cost' => $shipping_cost,
            'grand_total' => $grand_total,
            'cart_token' => $cartItems->first()?->cart_token,
            'cart_items' => $cartItems,
            'first_cart_item' => $cartItems->first(),
        ];
    }
}
