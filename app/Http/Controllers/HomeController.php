<?php

namespace App\Http\Controllers;

use App\Models\CategoryOrder;
use App\Models\Faq;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends BaseController
{
    public function index(Request $request)
    {

        if ($this->site_settings->show_only_categories_on_main == 1) {
            return to_route('categories');
        }

        $formain = $this->formain;
        $formain_products = $this->formain_products;
        //        dd($formain);
        $banners = $this->banners;
        $featured_products = $this->featured_products;
        $site_settings = Cache::get('site_settings');

        //        $cartItems = new CartService()->getCart();
        //
        //        if ($cartItems->contains('product_id', $product->id)) {
        //            $in_cart = true;
        //        } else {
        //            $in_cart = false;
        //        }

        return view('index', compact('formain', 'featured_products', 'banners', 'site_settings', 'formain_products'));

    }

    public function changeOrder(Request $request)
    {

        $request->validate([
            'record_id' => 'required|exists:category_orders,id',
            'order' => 'required|integer|min:1',
        ]);

        $record = CategoryOrder::find($request->record_id);
        $record->order = $request->order;
        $record->save();

        return back()->with('alert_success', 'Order updated successfully');

    }

    public function faqs(Request $request)
    {

        $faqs = Faq::all()->groupBy('subject');
        $banners = $this->banners;

        return view('frontend.faqs', compact('faqs', 'banners'));
    }
}
