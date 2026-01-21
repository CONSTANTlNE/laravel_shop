<?php

namespace App\Http\Controllers;

use App\Models\CategoryOrder;
use App\Models\Faq;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index(Request $request)
    {

        if ($this->site_settings->show_only_categories_on_main == 1) {
            return to_route('categories');
        }

        $formain = $this->formain;
        $banners = $this->banners;
        $featured_products = $this->featured_products;

        return view('index', compact('formain', 'featured_products', 'banners'));

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
