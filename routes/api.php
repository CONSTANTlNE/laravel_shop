<?php

use App\Http\Controllers\ChatwootController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/customer', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/bog/callback', [PurchaseController::class, 'callback']);

Route::post('/chatwoot/webhook', [ChatwootController::class, 'webhook']);
