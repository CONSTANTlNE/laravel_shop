<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SmsVerificationController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\UserController;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

Route::post('/login/htmx', [MainController::class, 'loginHtmx'])->name('login.htmx');
Route::post('/register/htmx', [MainController::class, 'registerHtmx'])->name('register.htmx');

Route::prefix('{locale?}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization', 'cartToken'])
    ->group(function () {

        Route::controller(HomeController::class)->group(function () {
            Route::get('/', 'index')->name('home');
            Route::get('/faq', 'faqs')->name('faqs');
        });

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('/categories/{category}', [CategoryController::class, 'category'])->name('category.single');

        Route::controller(ProductController::class)->group(function () {
            Route::get('/products', 'index')->name('products');
            Route::get('/products/discounted', 'discounted')->name('products.discounted');
            Route::get('/products/{product}', 'show')->name('product.single');
            Route::post('/products/search', 'searchHtmx')->name('product.search.htmx');
        });

        Route::controller(SmsVerificationController::class)->group(function () {
            Route::post('/mobile/store', 'storeMobile')->name('store.mobile.htmx');
            Route::post('/mobile/change', 'changeMobile')->name('mobile.change.htmx');
            Route::post('/code/resend', 'codeResend')->name('sms.resend');
            Route::post('/mobile/verify', 'verify')->name('sms.verify.htmx');
        });

    });

Route::prefix('{locale?}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization', 'cartToken', 'auth:web'])
    ->group(function () {

        Route::post('/purchase/test', [PurchaseController::class, 'testCallback'])->name('purchase.test')
            ->middleware('user.lock');

        Route::controller(OrderController::class)->group(function () {
            Route::get('/user/orders', 'index')->name('customer.orders');
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('/user/profile', 'index')->name('customer.profile');
            Route::get('/user/profile/htmx', 'profileHtmx')->name('customer.profile.htmx');
            Route::post('/user/profile/update', 'updateProfile')->name('customer.profile.update');

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

    $products = Product::where('price_history', '=', '"{}"')->get();
    //    dd($products);
    foreach ($products as $product) {
        $product->price_history = [];
        $product->save();
    }
});

route::get('codetest', function () {
    return strtoupper(substr(md5(uniqid()), 0, 6));
});

route::get('/lock', function () {
    return view('lock');
});

route::post('/lock/test', function (Request $request) {
    //    $user = auth('web')->user();
    //    $userId = $user ? $user->id : $request->ip();
    //    $routeName = $request->route()?->getName() ?? $request->path();

    //    $key = "lock:user:{$userId}:{$routeName}";

    //
    //

    $key = $request->idempotency_key;
    //
    //    // Check if this exact key was already used (global)
    //    if (Cache::has("form_processed_{$key}")) {
    //        return response('Already processed.' . $key );
    //    }

    \Log::info("Processing safely for {$key}");

    // Mark as processed globally (cross-session)
    //    Cache::put("form_processed_{$key}", true, 86400); // 24 hours

    // Simulate your DB insert or heavy work
    sleep(3);

    return response('Operation completed.');

})->name('locktest')->middleware('user.lock');

// ->middleware('user.lock');

// Google Auth

Route::controller(SocialiteController::class)->group(function () {
    Route::get('auth/google/redirect', 'googleredirect')->name('google.login');
    Route::get('auth/google/callback', 'googlecallback');
});

Route::get('mail/test', function () {

    Mail::to('gmta.constantine@gmail.com')->send(new \App\Mail\TestMail);

    return 'sent';
});

Route::fallback(function () {
    return to_route('home')->with('alert_error', __('Session expired'));
});
