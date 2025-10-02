<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ExcelUploadController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFeatureController;
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
            Route::get('/categories/all', 'allCategories')->name('admin.categories.all');
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
            Route::post('/product/in-stock', 'inStock')->name('product.in-stock');
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
        });

        Route::controller(ProductFeatureController::class)->group(function () {
            Route::post('/product/feature/store', 'store')->name('product.feature.store');
            Route::post('/product/feature/updte', 'update')->name('product.feature.update');
            Route::post('/product/feature/delete', 'delete')->name('product.feature.delete');
        });

        Route::controller(ExcelUploadController::class)->group(function () {
            route::get('/excel', 'index')->name('excel');
            route::post('/excel/categories', 'uploadCategories')->name('excel.categories');
            route::post('/excel/subcategories', 'uploadCategories')->name('excel.subcategories');
            route::post('/excel/products', 'uploadProducts')->name('excel.products');
            route::post('/excel/folder', 'uploadFolder')->name('excel.folder');
        });

        Route::controller(DiscountController::class)->group(function () {
            Route::get('discount/all', 'index')->name('discount.all');
            Route::post('/discount/store', 'store')->name('discount.store');
            Route::post('/discount/apply/category', 'discountApplyCategory')->name('discount.apply.category');
            Route::post('/discount/apply/product', 'discountApplyProduct')->name('discount.apply.product');
            Route::post('/discount/remove/product', 'discountRemoveProduct')->name('discount.remove.product');
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
    });

// Route::fallback(function () {
//    return back();
// });
