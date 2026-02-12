<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ShippingPriceController;

Route::prefix('{locale?}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization'])
    ->group(function () {

        Route::controller(CartController::class)->group(function () {
            Route::post('/cart/add', 'add')->name('cart.add');
            Route::post('/cart/remove', 'remove')->name('cart.remove');
            Route::post('/cart/delete', 'delete')->name('cart.delete');
            Route::post('/cart', 'cartItems')->name('cart.get.items');
            Route::post('/cart/add/single', 'addSingle')->name('cart.add.single');
        });

    });
Route::prefix('{locale?}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization', 'cartToken', 'auth:web,admin'])
    ->group(function () {

        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

        Route::controller(ShippingPriceController::class)->group(function () {
            Route::post('shipping/price/get', 'getPrice')->name('shippingprice.price.get');
        });

        Route::controller(CouponController::class)->group(function () {
            Route::post('/use/coupon', 'useCoupon')->name('coupon.use');
        });

    });

Route::middleware(['cartToken', 'auth:web,admin'])
    ->group(function () {
        Route::controller(PurchaseController::class)->group(function () {
            Route::post('/purchase', 'payment')->name('purchase');
            Route::post('/purchase/nawilnawil', 'nawilNawili')->name('nawilnawili');
            Route::post('/purchase/test', 'testCallback')->name('purchase.test');

        });

    });
