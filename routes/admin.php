<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ButtonColorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ExcelUploadController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\MainBannerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFeatureController;
use App\Http\Controllers\PromoterController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShippingPriceController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TermController;
use Illuminate\Support\Facades\Route;

Route::prefix('{locale}'.'/admin')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization', 'auth:admin'])
    ->group(function () {

        Route::controller(HomeController::class)->group(function () {
            Route::post('/home/order/change', 'changeOrder')->name('home.order.change');
        });

        Route::controller(AdminController::class)->group(function () {
            Route::get('/products/all', 'allProducts')->name('admin.products.all');
            Route::get('/products/sold', 'soldProducts')->name('admin.products.sold');
            Route::get('/products/removed', 'removedProducts')->name('admin.products.removed');
            Route::get('/products/sold/sum', 'soldSum')->name('admin.products.sold.sum');
            Route::get('/categories/all', 'allCategories')->name('admin.categories.all');
            Route::get('/admins/all', 'allAdmins')->name('admin.admins.all');
            Route::post('/admins/store', 'storeAdmin')->name('admin.admins.store');
            Route::post('/admins/update', 'updateAdmin')->name('admin.admins.update');
            Route::post('/admins/delete', 'deleteAdmin')->name('admin.admins.delete');
            Route::get('/users/all', 'allUsers')->name('admin.users.all');
            Route::post('/users/store', 'storeUser')->name('admin.user.store');
            Route::post('/users/update', 'updateUser')->name('admin.user.update');
            Route::post('/users/delete', 'deleteUser')->name('admin.user.delete');
            Route::post('/user/autologin', 'autoLogin')->name('customer.autologin');
            Route::post('/user/order/items', 'orderItemsHtmx')->name('customer.orderitems.htmx');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::post('/category/store', 'store')->name('category.store');
            Route::post('/category/update', 'update')->name('category.update');
            Route::post('/category/delete', 'delete')->name('category.delete');
            Route::post('/category/change/main', 'changeMain')->name('category.change.main');
        });

        Route::controller(SubCategoryController::class)->group(function () {
            Route::post('/subcategory/store', 'store')->name('subcategory.store');
            Route::post('/subcategory/update', 'update')->name('subcategory.update');
            Route::post('/subcategory/delete', 'delete')->name('subcategory.delete');
        });

        Route::controller(ProductController::class)->group(function () {
            Route::post('/product/store', 'store')->name('product.store');
            Route::post('/product/delete', 'delete')->name('product.delete');
            Route::post('/product/in-stock', 'inStock')->name('product.in-stock');
            Route::post('/product/removed', 'removed')->name('product.removed');
            Route::post('/product/image/main', 'mainImage')->name('product.image.main');
            Route::post('/product/image/delete', 'deleteImage')->name('product.image.delete');
            Route::post('/product/image/add', 'addImage')->name('product.image.add');
            Route::post('/product/price/update', 'priceUpdate')->name('product.price.update');
            Route::post('/product/description/update', 'descriptionUpdate')->name('product.description.update');
            Route::post('/product/name/update', 'nameUpdate')->name('product.name.update');
            Route::post('/product/order/update', 'updateOrder')->name('product.order.update');
            Route::post('/product/main/update', 'updateMain')->name('product.main.update');
            Route::post('/product/video/update', 'updateVideo')->name('product.video.update');
            Route::post('/product/video/delete', 'deleteVideo')->name('product.video.delete');
            Route::post('/product/featured', 'featured')->name('product.featured');
            Route::post('/product/htm/images', 'htmxImages')->name('product.htmx.images');
            Route::post('/product/download/sales/sum', 'salesSumDownload')->name('product.download.sales.sum');

        });

        Route::controller(ProductFeatureController::class)->group(function () {
            Route::post('/product/feature/store', 'store')->name('product.feature.store');
            Route::post('/product/feature/updte', 'update')->name('product.feature.update');
            Route::post('/product/feature/delete', 'delete')->name('product.feature.delete');
        });

        Route::controller(TermController::class)->group(function () {
            Route::get('terms', 'index')->name('admin.terms');
            Route::post('terms/store', 'store')->name('admin.terms.store');
            Route::post('terms/update', 'update')->name('admin.terms.update');
        });

        Route::controller(FaqController::class)->group(function () {
            Route::get('faqs', 'index')->name('admin.faqs');
            Route::post('faqs/store', 'store')->name('faqs.store');
            Route::post('faqs/update', 'update')->name('faqs.update');
            Route::post('faqs/delete', 'delete')->name('faqs.delete');
        });

        Route::controller(DiscountController::class)->group(function () {
            Route::get('discount/all', 'index')->name('discount.all');
            Route::post('/discount/store', 'store')->name('discount.store');
            Route::post('/discount/apply/category', 'discountApplyCategory')->name('discount.apply.category');
            Route::post('/discount/apply/product', 'discountApplyProduct')->name('discount.apply.product');
            Route::post('/discount/remove/product', 'discountRemoveProduct')->name('discount.remove.product');
            Route::post('/discount/delete', 'discountDelete')->name('discount.delete');
        });

        Route::controller(CouponController::class)->group(function () {
            Route::get('coupons', 'index')->name('coupons');
            Route::post('coupons/store', 'store')->name('coupon.store');
            Route::post('coupons/update', 'update')->name('coupon.update');
            Route::post('coupons/delete', 'delete')->name('coupon.delete');
            Route::post('coupons/activate', 'activate')->name('coupon.activate');
            Route::post('coupons/apply/category', 'couponApplyCategory')->name('coupon.apply.category');
            Route::post('coupons/apply/product', 'couponApplyProduct')->name('coupon.apply.product');
            Route::post('coupons/remove/product', 'couponRemoveProduct')->name('coupon.remove.product');
            Route::post('coupons/remove/category', 'couponRemoveCategory')->name('coupon.remove.category');
        });

        Route::controller(PromoterController::class)->group(function () {
            Route::post('promoter/store', 'store')->name('promoter.store');
            Route::post('promoter/update', 'update')->name('promoter.update');
            Route::post('promoter/delete', 'delete')->name('promoter.delete');
        });

        Route::controller(ShippingPriceController::class)->group(function () {
            Route::get('shipping/price', 'index')->name('shippingprice');
            Route::post('shipping/price/store', 'store')->name('shippingprice.store');
            Route::post('shipping/price/update', 'update')->name('shippingprice.update');
            Route::post('shipping/price/delete', 'delete')->name('shippingprice.delete');
        });

        Route::controller(ExcelUploadController::class)->group(function () {
            route::get('/excel', 'index')->name('excel');
            route::post('/excel/categories', 'uploadCategories')->name('excel.categories');
            route::post('/excel/subcategories', 'uploadCategories')->name('excel.subcategories');
            route::post('/excel/products', 'uploadProducts')->name('excel.products');
            route::post('/excel/folder', 'uploadFolder')->name('excel.folder');
        });

        Route::controller(OrderController::class)->group(function () {
            route::get('orders', 'adminIndex')->name('admin.orders');
            route::post('delivery', 'delivery')->name('admin.orders.delivery');
        });

        Route::controller(MainBannerController::class)->group(function () {
            route::get('/banners', 'index')->name('admin.banners');
            route::post('/banners/create', 'create')->name('admin.banners.create');
            route::post('/banners/update', 'update')->name('admin.banners.update');
            route::post('/banners/delete', 'delete')->name('admin.banners.delete');
            route::post('/banners/activate', 'activate')->name('admin.banners.activate');
        });

        Route::controller(SettingController::class)->group(function () {
            Route::post('/settings/update', 'update')->name('admin.settings.update');
        });

        Route::controller(RoleAndPermissionController::class)->group(function () {
            Route::get('/roles', 'index')->name('admin.roles');
        });

        Route::controller(LocalizationController::class)->group(function () {
            Route::get('/static/translations', 'addTranslation')->name('admin.translations');
            Route::post('/static/translation/store', 'storeStaticTranslations')->name('storeStaticTranslations');
            Route::post('/static/translation/update', 'updateStaticTranslation')->name('updateStaticTranslation');
        });

        Route::controller(ButtonColorController::class)->group(function () {
            Route::post('/update/button/color', 'updateButtonColor')->name('updateButtonColor');
        });

        Route::controller(LanguageController::class)->group(function () {});

        Route::get('facebook/post', function () {

            //            https://developers.facebook.com/docs/pages-api/posts/

            $pageId = '900502759820558';
            $accessToken = config('credentials.FB_USER_TOKEN');
            $accessTokenPage = config('credentials.FB_PAGE_ACCESS_TOKEN');
            //            $accessToken = config('credentials.FB_APP_CLIENT_TOKEN');

            // ======= create post  returns post id
            $response = Http::post("https://graph.facebook.com/v24.0/{$pageId}/feed", [
                'message' => 'Check out our new floor plans!',
                'link' => 'https://shopz.ge/ka/products/dell-latitude-3320',
                'published' => true,
                //                'scheduled_publish_time' => now()->addHours(2)->timestamp, // Example: 2 hours from now
                'access_token' => $accessTokenPage,
            ]);

            // ======== get all posts ?!
            //            $response = Http::get("https://graph.facebook.com/v24.0/{$pageId}/feed", [
            //                'access_token'           => $accessTokenPage,
            //            ]);

            // ========  read post details
            //            $post_id='900502759820558_122103187047222256';
            //            $response = Http::get("https://graph.facebook.com/v24.0/{$post_id}", [
            //                'access_token'           => $accessTokenPage,
            //            ])

            //            $response = Http::post("https://graph.facebook.com/v24.0/me?fields=id,name", [
            //                'access_token'           => $accessToken,
            //            ]);

            if ($response->successful()) {

                return $response->json();
            }

            return 'Error: '.$response->body();
        });

    });

// Route::fallback(function () {
//    return back();
// });
