<?php


use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\LocalizationController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\frontend\QuotationController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SocialController;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\ContactInfo;
use App\Models\Faq;
use App\Models\Service;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;


Route::prefix('{locale?}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization', 'adminlogin',])
    ->group(function () {
        Route::prefix('admin')->group(function () {

        });
    });


Route::fallback(function () {
    return back();
});
