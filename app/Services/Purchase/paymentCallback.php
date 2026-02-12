<?php

namespace App\Services\Purchase;

use App\Events\OutOfStockEvent;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class paymentCallback
{
    protected $request;

    // 1. You need this to "catch" the $request from the controller
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function __invoke(): Response
    {
        $data = $this->request->body;

        if ($data['order_status']['key'] === 'completed') {

            try {

                $cart_items = CartItem::where('cart_token', $data['external_order_id'])
                    ->where('owner_type', $data['buyer']['email'])
                    ->where('owner_id', $data['buyer']['phone_number'])
                    ->with(['product.media', 'product.presents'])
                    ->get();

                if ($cart_items !== null) {
                    $shipping_cost = $cart_items->first()->shipping_price;
                    $google_map = $cart_items->first()->google_maps;
                    $product_details = [];
                    $presents = [];

                    foreach ($cart_items as $cart_item) {
                        $product = $cart_item->product;

                        foreach ($product->presents as $present) {
                            $presents[] = [
                                'present_id' => $present->id,
                                'product_id' => $product->id,
                                'product_name' => $product->name,
                                'name' => $present->name,
                                'slug' => $present->slug,
                                'price' => $present->price,
                                'image' => $present->getMedia('product_image')->first()?->getUrl('thumbnail'),
                                'quantity' => $cart_item->quantity,
                            ];
                        }

                        $product_details[] = [
                            'id' => $cart_item->product_id,
                            'sku' => $product->sku,
                            'name' => $cart_item->product->name,
                            'price' => $cart_item->product_price,
                            'quantity' => $cart_item->quantity,
                            'coupon_discount' => $cart_item->coupon_discount,
                            'coupon_id' => $cart_item->coupon_id,
                            'product_total' => $cart_item->product_price * $cart_item->quantity - $cart_item->coupon_discount * $cart_item->quantity,
                            'image' => $cart_item->product->getMedia('product_image')->first()?->getUrl('thumbnail'),
                            'presents' => $product->presents->map(fn ($p) => [
                                'id' => $p->id,
                                'name' => $p->name,
                                'slug' => $p->slug,
                                'price' => $p->price,
                                'image' => $p->getMedia('product_image')->first()?->getUrl('thumbnail'),
                                'quantity' => $cart_item->quantity,
                            ])->toArray(),
                        ];
                    }

                    $outOfStockProducts = collect();

                    //                DB::transaction(function () use ($cart_items,$data,$request) {

                    $code = strtoupper(substr(md5(uniqid()), 0, 5));

                    $order = Order::create([
                        'order_token' => $code,
                        'city_id' => $cart_items->first()->city_id,
                        'bank' => 'BOG',
                        'bank_order_id' => $data['order_id'],
                        'address' => $data['buyer']['full_name'],
                        'total_price' => (float) ($data['purchase_units']['request_amount'] ?? 0),
                        'grand_total' => (float) ($data['purchase_units']['request_amount'] ?? 0) + (float) $shipping_cost,
                        'callback_data' => $this->request->getContent(),
                        'owner_type' => $data['buyer']['email'],
                        'owner_id' => (int) $data['buyer']['phone_number'],
                        'shipping_cost' => (float) $shipping_cost,
                        'products_details' => $product_details,
                        'google_map' => $google_map,
                        'presents' => $presents,
                    ]);

                    foreach ($cart_items as $cart_item) {
                        $product = $cart_item->product;

                        $order_item = new OrderItem;
                        $order_item->order_token = $code;
                        $order_item->user_id = $cart_item->owner_id;
                        $order_item->product_id = $cart_item->product_id;
                        $order_item->quantity = $cart_item->quantity;
                        $order_item->coupon_id = $cart_item->coupon_id;
                        $order_item->coupon_discount = $cart_item->coupon_discount;
                        $order_item->product_price = $cart_item->product_price;
                        $order_item->owner_id = (int) $data['buyer']['phone_number'];
                        $order_item->owner_type = $data['buyer']['email'];
                        $order_item->order_id = $order->id;
                        $order_item->product_total = $cart_item->quantity * $cart_item->product_price;
                        $order_item->purchase_price = $product->purchase_price;
                        $order_item->save();

                        if ($product->stock - $order_item->quantity == 0) {
                            $product->in_stock = 0;
                            $outOfStockProducts->push($product);
                        }
                        $product->stock = $product->stock - $order_item->quantity;
                        $product->save();

                        $cart_item->delete();
                    }

                    if ($outOfStockProducts->isNotEmpty()) {
                        event(new OutOfStockEvent($outOfStockProducts));
                    }

                } else {

                    Log::channel('bog')->error('payment Success but Cart Item Not Found', [
                        'Cart Token' => $data['external_order_id'],
                        'body' => $this->request->all(),
                    ]);
                }

            } catch (\Exception  $e) {

                Log::channel('bog')->error('BOG callback Status Completed but Exception Occured', [
                    'cart_token' => $data['external_order_id'] ?? null,
                    'exception' => $e, // Monolog will format it
                ]);
            }

        }

        if ($data['order_status']['key'] === 'rejected') {
            Log::channel('bog')->error('Payment rejected', [
                'Cart Token' => $data['external_order_id'],
                'body' => $this->request->all(),
            ]);
        }

        return response('', 200);
    }
}
