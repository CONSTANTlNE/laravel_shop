<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Support\Facades\File;

Route::prefix('{locale?}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization','cartToken'])
    ->group(function () {

        Route::controller(HomeController::class)->group(function () {
            Route::get('/', 'index')->name('home');
            Route::get('/faq', 'faqs')->name('faqs');
        });


        Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('/categories/{category}', [CategoryController::class, 'category'])->name('category.single');

        Route::controller(ProductController::class)->group(function () {
            Route::get('/products', 'index')->name('products');
            Route::get('/products/{product}', 'show')->name('product.single');
        });

        Route::controller(CartController::class)->group(function () {

        });
    });



route::get('/role', function () {
    $user = Admin::find(1);
    $user->assignRole('admin');
});

route::get('/php', function () {
    return phpinfo();
});

route::get('/test', function () {

    $storagePath1 = base_path('seeding_images/home/home_decor/1');
    $files1 = File::files($storagePath1);
    dd($files1);
});

route::get('/pricehistory', function () {

    $products=Product::where('price_history','=','"{}"')->get();
//    dd($products);
    foreach ($products as $product) {
        $product->price_history=[];
        $product->save();
    }
});


