<?php

namespace App\Http\Controllers;

use App\Events\OutOfStockEvent;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function payment(Request $request)
    {

        $request->validate([
            'address' => 'string|required|max:255',
            'city_id' => 'integer|exists:cities,id',
        ]);

        $data = $this->cart->getSummary();

        if (empty($data)) {
            return to_route('home')->with('alert_error', __('Empty Cart'));
        }

        if (! isset($data['cart_items'][0]['cart_token'])) {
//            return to_route('home')->with('alert_error', __('Empty Cart'));
            return to_route('home');
        }

        $grand_total = $data['grand_total'];
        $cart_token = $data['cart_token'];
        $items = $data['cart_items'];
        $owner_type = $items['0']->owner_type;
        $owner_id = $items['0']->owner_id;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product->quantity <= $item['quantity']) {
                return back()->with('alert_error', $product->name.' Only '.$product->quantity.' items left in stock, please decrease purchase quantity');
            }
        }

        $basket = $items->map(function ($item) {
            return [
                'quantity' => $item->quantity,
                'unit_price' => $item->product->price,
                'product_id' => $item->product->id,
                'total_price' => $item->product->price * $item->quantity,
            ];
        })->values()->toArray();

        if (env('TEST')) {
            $fail = 'https://local2.ews.ge/ka/checkout?bank_error';
            $success = 'https://local2.ews.ge/ka/checkout?payment_success';
            $callback = 'https://local2.ews.ge/api/bog/callback';
        } else {
            $fail = 'https://carbidpro.com/ka/checkout?bank_error';
            $success = 'https://carbidpro.com/ka/checkoutn?payment_success';
            $callback = 'https://carbidpro.com/api/bog/callback';
        }

        $response = Http::withBasicAuth(config('credentials.BOG_CLIENT_ID'), config('credentials.BOG_CLIENT_SECRET'))
            ->asForm()
            ->withHeaders([
                'Origin' => 'https://webmenu.ge',
                'Referer' => 'https://webmenu.ge',
            ])
            ->post('https://oauth2.bog.ge/auth/realms/bog/protocol/openid-connect/token', [
                'grant_type' => 'client_credentials',
            ]);

        $auth_data = $response->json();
        //        dd($fail,$success,$callback,$data);

        if (! $response->successful()) {
            Log::channel('bog')->error('error during authorization', ['response' => $response->json()]);

        } else {
            return back()->with('alert_error', 'Error during Authorization');
        }

        $request_payment = Http::withToken($auth_data['access_token'])
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept-Language' => 'ka',
                //                    'Origin'          => 'https://webmenu.ge',
                //                    'Referer'         => 'https://webmenu.ge',
            ])
            ->post('https://api.bog.ge/payments/v1/ecommerce/orders', [
                'payment_method' => ['card'],
                'capture' => 'automatic',
                'callback_url' => $callback,
                'external_order_id' => $cart_token,
                'buyer' => [
                    'full_name' => $request->address,
                    'masked_email' => $owner_type,
                    'masked_phone' => $owner_id,
                ],
                'purchase_units' => [
                    'delivery' => [
                        'amount' => $data['shipping_cost'],
                    ],
                    'currency' => 'GEL',
                    'total_amount' => $grand_total,
                    'basket' => $basket,
                ],
                'redirect_urls' => [
                    'fail' => $fail,
                    'success' => $success,
                ],
            ]);

        if ($request_payment->successful()) {
            $json = $request_payment->json();
            $link = $json['_links']['redirect']['href'];

            //                $response = Http::withToken($data['access_token'])
            //                    ->get($json['_links']['details']['href']);
            //
            //                dd($response->json());

            return redirect()->away($link);

        } else {
            Log::channel('bog')->error('full error response', ['request' => $request_payment->json()]);

            return back()->with('alert_error', __('Error from Bank side'));
        }

    }

    public function callback(Request $request)
    {
        $data = $request->body;
        Log::channel('bog')->info('full bank response', [
            'Cart Token' => $data['external_order_id'],
            'body' => $request->all(),
        ]);

        if ($data['order_status']['key'] === 'completed') {

            $cart_items = CartItem::where('cart_token', $data['external_order_id'])
                ->where('owner_type', $data['buyer']['email'])
                ->where('owner_id', $data['buyer']['phone_number'])
                ->get();

            if ($cart_items) {

                $code = strtoupper(substr(md5(uniqid()), 0, 5));
                $product_details = [];
                foreach ($cart_items as $cart_item) {
                    $product_details[] = [
                        'id' => $cart_item->product_id,
                        'name' => $cart_item->product->name,
                        'price' => $cart_item->product_price,
                        'quantity' => $cart_item->quantity,
                        'coupon_discount' => $cart_item->coupon_discount,
                        'coupon_id' => $cart_item->coupon_id,
                    ];
                }

                $order = Order::create([
                    'order_token' => $code,
                    'city_id' => $cart_items->first()->city_id,
                    'bank' => 'BOG',
                    'bank_order_id' => $data['order_id'],
                    'address' => $data['buyer']['full_name'],
                    'total_price' => $data['purchase_units']['request_amount'],
                    'callback_data' => json_decode($request->getContent(), true),
                    'owner_type' => $data['buyer']['email'],
                    'owner_id' => $data['buyer']['phone_number'],
                    'shipping_cost' => $data['purchase_units']['delivery']['amount'],
                    'product_details' => $product_details,
                ]);

                foreach ($cart_items as $cart_item) {

                    $order_item = new OrderItem;
                    $order_item->order_token = $code;
                    $order_item->user_id = $cart_item->user_id;
                    $order_item->product_id = $cart_item->product_id;
                    $order_item->quantity = $cart_item->quantity;
                    $order_item->coupon_id = $cart_item->coupon_id;
                    $order_item->coupon_discount = $cart_item->coupon_discount;
                    $order_item->product_price = $cart_item->product_price;
                    $order_item->owner_id = $data['buyer']['email'];
                    $order_item->owner_type = $data['buyer']['phone'];
                    $order_item->order_id = $order->id;
                    $order_item->save();

                    $cart_item->delete();
                }

            } else {
                Log::channel('bog')->error('Cart Item Not Found', [
                    'Cart Token' => $data['external_order_id'],
                    'body' => $request->all(),
                ]);
            }
        } else {
            Log::channel('bog')->error('Payment Failed', [
                'Cart Token' => $data['external_order_id'],
                'body' => $request->all(),
            ]);
        }

        return response('', 200);
    }

    public function testCallback(Request $request)
    {

        $request->validate([
            'address' => 'string|required|max:255',
            'city_id' => 'required|integer|exists:cities,id',
        ]);

        $data = new CartService()->getSummary();

        if (empty($data)) {
            return to_route('home')->with('alert_error', 'Empty Cart');
        }

        if (! isset($data['cart_items'][0]['cart_token'])) {
            return to_route('home')->with('alert_error', 'Empty Cart');
        }

        $cart_items = CartItem::where('cart_token', $data['cart_items'][0]['cart_token'])
            ->with('product')
            ->where('owner_id', auth('web')->user()->id)
            ->get();

        if ($cart_items) {

            $code = strtoupper(substr(md5(uniqid()), 0, 5));

            $product_details = [];
            foreach ($cart_items as $cart_item) {
                $product = $cart_item->product;

                if ($product->stock < $cart_item->quantity) {
                    return back()->with(
                        'error',
                        "{$product->name} Only {$product->stock} items left in stock, please decrease purchase quantity"
                    );
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
                    'image'=>$cart_item->product->getMedia('product_image')->first()?->getUrl('thumbnail'),
                ];
            }

            $order = Order::create([
                'order_token' => $code,
                'city_id' => $cart_items->first()->city_id,
                'bank' => 'BOG',
                'bank_order_id' => 'test_order_id',
                'address' => $request->address,
                'total_price' => $data['total_value'],
                'callback_data' => json_encode([
                    'status' => 'success',
                    'transaction_id' => 'TEST123456',
                    'amount' => 100.50,
                    'currency' => 'GEL',
                ]),
                'owner_type' => $cart_items->first()->owner_type,
                'owner_id' => $cart_items->first()->owner_id,
                'shipping_cost' => $data['shipping_cost'],
                'total_coupon_discount' => $data['total_coupon_discount'],
                'products_details' => $product_details,
                'grand_total' => $data['grand_total'],
            ]);

            $outOfStockProducts = collect();

            DB::transaction(function () use ($cart_items, $code,$data,$order,$outOfStockProducts) {
                foreach ($cart_items as $cart_item) {
                    $product = $cart_item->product;

                    $order_item = new OrderItem;
                    $order_item->order_token = $code;
                    $order_item->user_id = $cart_item->owner_id;
                    $order_item->product_id = $cart_item->product_id;
                    $order_item->quantity = $cart_item->quantity;
                    $order_item->product_price = $cart_item->product_price;
                    $order_item->coupon_id = $cart_item->coupon_id;
                    $order_item->coupon_discount = $cart_item->coupon_discount;
                    $order_item->coupon_code = $data['promo_code'];
                    $order_item->owner_id = $cart_item->owner_id;
                    $order_item->owner_type = $cart_item->owner_type;
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
            });


            if ($outOfStockProducts->isNotEmpty()) {
                event(new OutOfStockEvent($outOfStockProducts));
            }
        }

        return to_route('home')->with('alert_success', __('Payment Successful'));
    }
}
