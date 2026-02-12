<?php

namespace App\Http\Controllers;

use App\Events\OutOfStockEvent;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Services\CartService;
use App\Services\Purchase\paymentCallback;
use App\Services\Purchase\paymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Str;

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
            'address' => 'string|required|max:500',
            'city_id' => 'required|integer|exists:cities,id',
            'google_map' => 'nullable|string|max:500',
        ]);

        $data = new CartService()->getSummary();

        if (empty($data)) {
            return to_route('home')->with('alert_error', 'Empty Cart');
        }

        if (! isset($data['cart_items'][0]['cart_token'])) {
            return to_route('home')->with('alert_error', 'Empty Cart');
        }

        // if set min purchase and cart value is less than min purchase return back
        $min_purchase = Setting::first();

        if ($min_purchase->min_order_amount > $data['total_value']) {
            return back()->withInput()->with('alert_error', __('Minimum purchase amount is').' '.$min_purchase->min_order_amount);
        }

        return new paymentService()->payment($data, $request);

    }

    public function callback(Request $request)
    {
        return new paymentCallback($request)();
    }

    public function testCallback(Request $request)
    {

        $request->validate([
            'address' => 'string|required|max:500',
            'city_id' => 'required|integer|exists:cities,id',
            'google_map' => 'nullable|string|max:500',
        ]);

        $data = new CartService()->getSummary();

        if (empty($data)) {
            return to_route('home')->with('alert_error', 'Empty Cart');
        }

        if (! isset($data['cart_items'][0]['cart_token'])) {
            return to_route('home')->with('alert_error', 'Empty Cart');
        }

        // if set min purchase and cart value is less than min purchase return back
        $min_purchase = Setting::first();

        if ($min_purchase->min_order_amount > $data['total_value']) {
            return back()->withInput()->with('alert_error', __('Minimum purchase amount is').' '.$min_purchase->min_order_amount);
        }

        $owner_type = 'App\Models\User';
        $test_user = User::where('email', 'test@test.com')->first();

        $cart_items = CartItem::where('cart_token', $data['cart_items'][0]['cart_token'])
            ->where('owner_id', $test_user->id)
            ->with(['product.media', 'product.presents'])
            ->get();

        if ($cart_items) {

            $code = strtoupper(substr(md5(uniqid()), 0, 5));

            $product_details = [];
            $presents = [];
            foreach ($cart_items as $cart_item) {
                $product = $cart_item->product;

                if ($product->stock < $cart_item->quantity) {
                    return back()->with(
                        'error',
                        "{$product->name} Only {$product->stock} items left in stock, please decrease purchase quantity"
                    );
                }

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

            DB::transaction(function () use ($cart_items, $code, $data, $request, $outOfStockProducts, $product_details, $presents, $owner_type, $test_user) {

                $callback_data = [
                    'status' => 'success',
                    'transaction_id' => 'TEST123456',
                    'amount' => 1,
                    'currency' => 'GEL',
                ];

                $order = Order::create([
                    'order_token' => $code,
                    'city_id' => $request->input('city_id'),
                    'bank' => 'BOG',
                    'bank_order_id' => 'test_order_id',
                    'address' => $request->address,
                    'total_price' => $data['total_value'],
                    'callback_data' => json_encode($callback_data),
                    'owner_type' => $owner_type,
                    'owner_id' => $test_user->id,
                    'shipping_cost' => $data['shipping_cost'],
                    'total_coupon_discount' => $data['total_coupon_discount'],
                    'products_details' => $product_details,
                    'grand_total' => $data['grand_total'],
                    'google_map' => $request->input('google_map'),
                    'presents' => $presents,
                ]);

                foreach ($cart_items as $cart_item) {
                    $product = $cart_item->product;

                    $order_item = new OrderItem;
                    $order_item->order_token = $code;
                    $order_item->user_id = $test_user->id;
                    $order_item->product_id = $cart_item->product_id;
                    $order_item->quantity = $cart_item->quantity;
                    $order_item->product_price = $cart_item->product_price;
                    $order_item->coupon_id = $cart_item->coupon_id;
                    $order_item->coupon_discount = $cart_item->coupon_discount;
                    $order_item->coupon_code = $data['promo_code'];
                    $order_item->owner_id = $test_user->id;
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

    public function nawilNawili(Request $request)
    {

        $site_settings = Setting::first();
        Log::channel('bog')->info('method called');
        $rules = [
            'payment_method' => 'required|string|in:card,bnpl',
        ];

        if ($site_settings->use_transportation == 1) {
            $rules['address'] = 'string|required|max:255';
            $rules['city_id'] = 'integer|required|exists:cities,id';
        }

        $request->validate($rules);

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
            if ($product->stock <= $item['quantity']) {
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
            $fail = 'https://shopz.ge/ka/checkout?bank_error';
            $success = 'https://shopz.ge/ka/checkoutn?payment_success';
            $callback = 'https://shopz.ge/api/bog/callback';
        }

        $response = Http::withBasicAuth(config('credentials.BOG_CLIENT_ID'), config('credentials.BOG_CLIENT_SECRET'))
            ->asForm()
            ->post('https://oauth2.bog.ge/auth/realms/bog/protocol/openid-connect/token', [
                'grant_type' => 'client_credentials',
            ]);

        $auth_data = $response->json();
        //        dd($fail,$success,$callback,$data);

        if (! $response->successful()) {
            Log::channel('bog')->error('unsacessfull token call', ['response' => $response->json()]);

            return back()->with('alert_error', 'unsacessfull token call');
        }

        $payment_method = $request->input('payment_method');

        $request_payment = Http::withToken($auth_data['access_token'])
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept-Language' => 'ka',
                //                    'Origin'          => 'https://webmenu.ge',
                //                    'Referer'         => 'https://webmenu.ge',
            ])->post('https://installment.bog.ge/v1/installment/checkout', [
                'payment_method' => [$payment_method],
                'capture' => 'automatic',
                'callback_url' => $callback,
                'external_order_id' => $cart_token,
                'buyer' => [
                    'full_name' => $request->address ?? auth('web')->user()->name ?? 'Customer',
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
            Log::channel('bog')->error('Error during payment initialization', ['request' => $request_payment->json()]);

            return back()->with('alert_error', __('Error from Bank side'));
        }

    }

    public function refund(Request $request): RedirectResponse
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $order = Order::findOrFail($request->input('order_id'));

        if (empty($order->bank_order_id) || ! Str::isUuid($order->bank_order_id)) {
            return back()->with('alert_error', __('Bank order ID not found for this order'));
        }

        try {
            $response = Http::withBasicAuth(config('credentials.BOG_CLIENT_ID'), config('credentials.BOG_CLIENT_SECRET'))
                ->asForm()
                ->post('https://oauth2.bog.ge/auth/realms/bog/protocol/openid-connect/token', [
                    'grant_type' => 'client_credentials',
                ]);

            if (! $response->successful()) {
                Log::channel('bog')->error('BOG token request failed for refund', ['response' => $response->json()]);

                return back()->with('alert_error', __('Failed to authenticate with bank'));
            }

            $auth_data = $response->json();

            $refundResponse = Http::withToken($auth_data['access_token'])
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post("https://api.bog.ge/payments/v1/payment/refund/{$order->bank_order_id}", [
                    'amount' => (string) $request->input('amount'),
                ]);

            if ($refundResponse->successful()) {

                $order->refunded = true;
                if ($request->input('amount') == $order->grand_total) {
                    foreach ($order->orderItems as $item) {
                        $product = $item->product;
                        if ($product) {
                            $product->stock = $product->stock + $item->quantity;
                            if ($product->stock > 0) {
                                $product->in_stock = 1;
                            }
                            $product->save();
                        }
                    }
                    $order->status_canceled = true;
                    $order->refund_details = $request->getContent();
                } else {
                    $order->partial_refund_amount = $request->input('amount');
                }

                $order->save();

                return back()->with('alert_success', __('Refund processed successfull'));
            } else {
                Log::channel('bog')->error('Refund failed', [
                    'order_id' => $order->order_token,
                    'bank_order_id' => $order->bank_order_id,
                    'response' => $refundResponse->json(),
                ]);

                return back()->with('alert_error', __('Refund failed: ').$refundResponse->json()['message'] ?? __('Unknown error'));
            }

        } catch (\Exception $e) {
            Log::channel('bog')->error('Refund exception', [
                'order_id' => $order->order_token,
                'message' => $e->getMessage(),
            ]);

            return back()->with('alert_error', __('Error processing refund'));
        }
    }
}
