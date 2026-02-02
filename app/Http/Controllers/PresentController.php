<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PresentController extends Controller
{
    public function addPresent(Request $request)
    {

        $product = Product::where('id', $request->product_id)->first();
        $product->presents()->sync($request->present_ids);
    }

    public function removePresent(Request $request)
    {

        $product = Product::where('id', $request->product_id)->first();

        $product->presents()->sync($request->present_ids);

    }

    public function isPresent(Request $request)
    {

        $product = Product::where('id', $request->product_id)->first();

        if (! $product) {
            return response()->noContent();
        }

        if ($product->is_present == 1) {
            $product->is_present = 0;

            // Remove this product from all other products that have it as a present
            $product->presentToProducts()->detach();
        } else {
            $product->is_present = 1;
        }

        $product->save();

        return response()
            ->view('backend.htmx.messages_htmx')
            ->header('HX-Trigger', json_encode([
                'showSuccess' => [
                    'icon' => 'success',
                    'message' => __('Updated successfully'),
                ],
            ]));

    }

    public function presentProducts(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);

        // Get all products marked as presents
        $presentProducts = Product::where('is_present', 1)->with('media')->get();

        // Get IDs of already attached presents for this product
        $attachedPresentIds = $product->presents()->pluck('present_id')->toArray();

        return view('backend.htmx.present_products', compact('presentProducts', 'product', 'attachedPresentIds'));
    }

    public function togglePresent(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'present_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $presentId = $validated['present_id'];

        // Check if the present is already attached
        if ($product->presents()->where('present_id', $presentId)->exists()) {
            // Detach the present
            $product->presents()->detach($presentId);

            return response()
                ->view('backend.htmx.messages_htmx')
                ->header('HX-Trigger', json_encode([
                    'showSuccess' => [
                        'icon' => 'success',
                        'message' => __('Present removed successfully'),
                    ],
                ]));
        } else {
            // Attach the present
            $product->presents()->attach($presentId);

            return response()
                ->view('backend.htmx.messages_htmx')
                ->header('HX-Trigger', json_encode([
                    'showSuccess' => [
                        'icon' => 'success',
                        'message' => __('Present added successfully'),
                    ],
                ]));
        }

    }
}
