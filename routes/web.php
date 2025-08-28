<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;




Route::get('/', function (Request $request) {

    // Guest user logic
    $tempUserId = $request->cookie('temp_user_id');

    if (!$tempUserId) {
        $tempUserId = Str::uuid()->toString();
        $cookie = cookie('temp_user_id', $tempUserId, 60 * 24 * 7); // 7 days

        // Add item to cart linked with this tempUserId
        // Cart::addItem($tempUserId, $productId);

        return response()->view('index')
            ->cookie($cookie);
    } else {
        return view('index');
    }

})->name('home');

Route::get('/product-single', function () {
    return view('frontend.product-single.index');
})->name('product-single');

Route::get('/cart', function () {
    return view('frontend.cart.index');
})->name('cart');

Route::get('/category', function () {
    return view('frontend.categories.index');
})->name('category');



