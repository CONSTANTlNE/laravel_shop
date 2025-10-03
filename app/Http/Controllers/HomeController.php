<?php

namespace App\Http\Controllers;

use App\Models\CategoryOrder;
use App\Models\Faq;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index(Request $request)
    {

        $formain = CategoryOrder::with([
            'category.products' => function ($q) {
                $q->where('show_in_main', 1)->with('media');
            },
            'subcategory.products' => function ($q) {
                $q->where('show_in_main', 1)->with('media');
            },
        ])
            ->where('active', 1)
            ->orderBy('order')
            ->get();

        $featured_products = Product::where('featured', 1)->get();

        return view('index', compact('formain', 'featured_products'));

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

        return view('frontend.faqs', compact('faqs'));
    }
}
