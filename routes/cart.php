<?php

use App\Http\Controllers\CartController;

Route::controller(CartController::class)->group(function () {
    Route::post('/cart/add', 'add')->name('cart.add');
    Route::post('/cart/remove', 'remove')->name('cart.remove');
    Route::post('/cart/delete', 'delete')->name('cart.delete');
    Route::post('/cart', 'cartItems')->name('cart.get.items');
});
