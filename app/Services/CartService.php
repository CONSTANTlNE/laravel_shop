<?php

namespace App\Services;

namespace App\Services;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    protected $sessionKey = 'cart';

    protected function getToken()
    {
        return request()->cookie('cart_token');
    }

    protected function getCartOwner()
    {
        foreach (['web', 'admin'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
        return null; // no authenticated owner
    }

//    public function add($productId, $quantity = 1)
//    {
//
//        // --- DB Cart ---
//        if (Auth::check()) {
//            // Logged in user
//            CartItem::updateOrCreate(
//                ['user_id' => Auth::id(), 'product_id' => $productId],
//                ['quantity' => DB::raw("quantity + $quantity"), 'cart_token' => $this->getToken()]
//            );
//
//        } else {
//            // Guest user
//            $cartItem = CartItem::firstOrCreate(
//                [
//                    'cart_token' => $this->getToken(),
//                    'user_id' => null,
//                    'product_id' => $productId
//                ],
//                ['quantity' => 0] // Start with 0 for new records
//            );
//
//            $cartItem->increment('quantity', $quantity);
//        }
//    }

    public function add($productId, $quantity = 1)
    {
        $owner = $this->getCartOwner();

        if ($owner) {
            // Logged in (via web or admin)
            $cartItem = CartItem::where('owner_id', $owner->id)
                ->where('owner_type', get_class($owner))
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
            } else {
                $owner->cartItems()->create([
                    'product_id' => $productId,
                    'quantity'   => $quantity,
                    'cart_token' => $this->getToken(),
                ]);
            }

        } else {
            // Guest user (cart_token only)
            $cartItem = CartItem::firstOrCreate(
                [
                    'cart_token' => $this->getToken(),
                    'owner_id'   => null,
                    'owner_type' => null,
                    'product_id' => $productId,
                ],
                ['quantity' => 0]
            );

            $cartItem->increment('quantity', $quantity);
        }
    }





    public function remove($productId, $quantity = 1)
    {

        // --- DB Cart ---
        if (Auth::check()) {
            // Logged in user
            CartItem::updateOrCreate(
                ['user_id' => Auth::id(), 'product_id' => $productId],
                ['quantity' => DB::raw("quantity + $quantity"), 'cart_token' => $this->getToken()]
            );

        } else {
            // Guest user
            $cartItem = CartItem::firstOrCreate(
                [
                    'cart_token' => $this->getToken(),
                    'user_id' => null,
                    'product_id' => $productId
                ],
                ['quantity' => 0] // Start with 0 for new records
            );

            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity', $quantity);
            } else {
                $cartItem->delete();
            }
        }
    }

    public function deleteItem($productId)
    {
        // DB
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->where('product_id', $productId)->delete();
        } else {
            CartItem::where('cart_token', $this->getToken())->where('product_id', $productId)->delete();
        }
    }

    public function getCart()
    {
        if (Auth::check()) {
            return CartItem::with('product')->where('user_id', Auth::id())->get();
        } else {
            return CartItem::with('product.media')->where('cart_token', $this->getToken())->get();
        }
    }


    // Merge guest cart into user cart after login
    public function mergeGuestCart()
    {
        $token = $this->getToken();
        if (!$token) return;

        // Determine authenticated owner (web/admin)
        $owner = null;
        foreach (['web', 'admin'] as $guard) {
            if (Auth::guard($guard)->check()) {
                $owner = Auth::guard($guard)->user();
                break;
            }
        }

        if (!$owner) return; // no logged-in owner, nothing to merge

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

        // 2️⃣ Update ALL of the user's existing cart items to use the current token
        CartItem::where('owner_id', $owner->id)
            ->where('owner_type', get_class($owner))
            ->update(['cart_token' => $token]);

        // 3️⃣ Clear session cart if needed
        session()->forget($this->sessionKey);
    }

}
