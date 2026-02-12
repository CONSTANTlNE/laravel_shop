<?php

namespace App\Services\Purchase;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class paymentService
{
    public function payment($data, $request)
    {
        $data['first_cart_item']->google_maps = $request->input('google_map');
        $data['first_cart_item']->shipping_price = $data['shipping_cost'];
        $data['first_cart_item']->save();

        $cart_token = $data['cart_token'];
        $items = $data['cart_items'];
        $owner_type = $items['0']->owner_type;
        $owner_id = $items['0']->owner_id;

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product->stock <= $item['quantity']) {
                return back()->with('alert_error', $product->name.' Only '.$product->stock.' items left in stock, please decrease purchase quantity');
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
            $grand_total = 0.1;
            $fail = 'https://local2.ews.ge/ka/checkout?bank_error';
            $success = 'https://local2.ews.ge/ka/user/orders?payment_success';
            $callback = 'https://local2.ews.ge/api/bog/callback';
            //  $grand_total=0.1;
        } else {
            $grand_total = $data['grand_total'];
            $fail = 'https://shopz.ge/ka/checkout?bank_error';
            $success = 'https://shopz.ge/ka/checkoutn?payment_success';
            $callback = 'https://shopz.ge/api/bog/callback';
        }

        try {
            $response = Http::withBasicAuth(config('credentials.BOG_CLIENT_ID'), config('credentials.BOG_CLIENT_SECRET'))
                ->asForm()
                ->post('https://oauth2.bog.ge/auth/realms/bog/protocol/openid-connect/token', [
                    'grant_type' => 'client_credentials',
                ]);
        } catch (\Exception $e) {
            Log::channel('bog')->error('BOG token request problem', ['message' => $e->getMessage()]);

            return back()->with('error', __('Error occurred from bank side'));
        }

        $auth_data = $response->json();
        //        dd($fail,$success,$callback,$data);

        if (! $response->successful()) {
            Log::channel('bog')->error('unsacessfull token call', ['response' => $response->json()]);

            return back()->with('alert_error', 'unsacessfull token call');
        }

        try {
            $request_payment = Http::withToken($auth_data['access_token'])
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept-Language' => 'ka',
                    //  'Origin'          => 'https://webmenu.ge',
                    //  'Referer'         => 'https://webmenu.ge',
                ])->post('https://api.bog.ge/payments/v1/ecommerce/orders', [
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
                            'amount' => (float) ($data['shipping_cost'] ?? 0),
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
        } catch (\Exception $e) {
            Log::channel('bog')->error('BOG Order Problem', ['message' => $e->getMessage()]);

            return back()->with('error', __('Error occurred from bank side'));
        }

        if ($request_payment->successful()) {
            $json = $request_payment->json();
            $link = $json['_links']['redirect']['href'];

            return redirect()->away($link);

        } else {
            Log::channel('bog')->error('Error during payment initialization', ['request' => $request_payment->json()]);

            return back()->with('alert_error', __('Error from Bank side'));
        }
    }
}
