<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\ShippingPrice;
use App\Services\CartService;
use Illuminate\Http\Request;

class ShippingPriceController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        $cities = City::all();
        $prices = ShippingPrice::with('city')->get();

        return view('backend.admin_shipping_prices', compact('cities', 'prices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'rate' => 'required|numeric',
            'upper_range' => 'nullable|numeric',
        ]);

        $new_price = new ShippingPrice;
        $new_price->city_id = $request->city_id;
        $new_price->rate = $request->rate;
        $new_price->upper_range = $request->upper_range;
        $new_price->save();

        return back();

    }

    public function update(Request $request)
    {

        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'rate' => 'required|numeric',
            'upper_range' => 'nullable|numeric',
        ]);

        $price = ShippingPrice::find($request->id);
        $price->city_id = $request->city_id;
        $price->rate = $request->rate;
        $price->upper_range = $request->upper_range;
        $price->save();

        return back();

    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:shipping_prices,id',
        ]);

        $price = ShippingPrice::find($request->id);
        $price->delete();

        return back();

    }

    public function getPrice(Request $request)
    {

        $cartItems = $this->cart->getCart();

        $data = $this->cart->getSummary($cartItems, $request->city_id);
        $hascoupon = $data['hascoupon'];
        $promo_code = $data['promo_code'];
        $total_coupon_discount = $data['total_coupon_discount'];
        $cities = $data['cities'];
        $total_value = $data['total_value'];
        $total_value_no_discount = $data['total_value_no_discount'];
        $discount_value = $data['discount_value'];
        $shipping_cost = $data['shipping_cost'];
        $grand_total = $data['grand_total'];

        foreach ($cartItems as $cartItem) {
            $cartItem->city_id = $request->city_id;
            $cartItem->save();
        }

        return view('frontend.cart.totals_htmx', compact('grand_total', 'shipping_cost', 'cartItems', 'hascoupon', 'promo_code', 'total_coupon_discount', 'cities', 'total_value', 'total_value_no_discount', 'discount_value', 'total_value_no_discount', 'shipping_cost'));

    }
}
