<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function add(Request $request)
    {

        $product=Product::find($request->product_id);
        $this->cart->add($product->id);
        $carttotal = CartItem::where('cart_token',request()->cookie('cart_token'))->sum('quantity');

        return view('frontend.cart.cart_count_htmx',compact('carttotal'));
    }

    public function remove(Request $request)
    {
        $this->cart->remove($request->product_id);
        $carttotal = CartItem::where('cart_token',request()->cookie('cart_token'))->sum('quantity');
//        return response()->noContent();
        return view('frontend.cart.cart_count_htmx',compact('carttotal'));
    }

    public function index()
    {
        $items = $this->cart->getCart();
        return view('cart.index', compact('items'));
    }

    public function delete(Request $request)
    {
        $this->cart->deleteItem($request->product_id);
        $carttotal = CartItem::where('cart_token',request()->cookie('cart_token'))->sum('quantity');
//       return response()->noContent();
        return view('frontend.cart.cart_count_htmx',compact('carttotal'));
    }

    public function cartItems(Request $request){

        $cartItems = $this->cart->getCart();
        $total_value = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });



        return view('frontend.cart.cart_items_htmx',compact('cartItems','total_value'));
    }

}
