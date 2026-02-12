<?php

namespace App\Http\Controllers;

use App\Models\CategoryOrder;
use App\Models\Language;
use App\Models\MainBanner;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class BaseController extends Controller
{
    protected $site_settings;

    protected $locales;

    protected $mainLocale;

    protected $featured_products;

    protected $formain;

    protected $formain_products;

    protected $banners;

    public function __construct()
    {

        //         $this->site_settings=Cache::tags(['site_settings'])->remember('site_settings', 3600, function () {
        //             return Setting::first();
        //         });

        //        $this->site_settings = Cache::tags(['site_settings'])
        //            ->rememberForever('site_settings', function () {
        //                return Setting::first();
        //            });

        $this->site_settings = Cache::rememberForever('site_settings', function () {
            return Setting::first();
        });

        $this->featured_products = Product::where('featured', 1)
            ->where('removed_from_store', false)
            ->with('media', 'presents')
            ->get();

        //
        //            Cache::tags(['featured_products'])
        //            ->rememberForever('featured_products', function () {
        //                return Product::where('featured', 1)->with('media')->get();
        //            });

        $this->formain = CategoryOrder::with([
            'category.products' => function ($q) {
                $q->where('show_in_main', 1)
                    ->where('removed_from_store', false)
                    ->with('media', 'presents', 'coupon');
            },
            'subcategory.products' => function ($q) {
                $q->where('show_in_main', 1)
                    ->where('removed_from_store', false)
                    ->with('media', 'presents', 'coupon');
            },
        ])
            ->where('active', 1)
            ->orderBy('order')
            ->get();

        $this->formain_products = ProductOrder::with(['product' => function ($q) {
            $q->where('show_in_main_single', true)
                ->with('media', 'presents', 'coupon', 'features');
        }])->where('active', true)
            ->orderBy('order')
            ->get();

        $this->banners = MainBanner::all();

        //            Cache::tags(['formain'])
        //            ->rememberForever('formain', function () {
        //                return CategoryOrder::with([
        //                    'category.products' => function ($q) {
        //                        $q->where('show_in_main', 1)->with('media');
        //                    },
        //                    'subcategory.products' => function ($q) {
        //                        $q->where('show_in_main', 1)->with('media');
        //                    },
        //                ])
        //                    ->where('active', 1)
        //                    ->orderBy('order')
        //                    ->get();
        //            });

        $this->locales = Cache::get('locales');
        $this->mainLocale = Language::where('main', 1)->first();

    }
}
