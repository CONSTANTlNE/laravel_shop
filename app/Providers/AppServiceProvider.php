<?php

namespace App\Providers;

use App\Models\ButtonColor;
use App\Models\Category;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Social;
use App\Models\Term;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Fortify::ignoreRoutes();
    }

    public function boot(): void
    {
        URL::forceScheme('https');
        Model::unguard();
        Model::preventLazyLoading(! app()->isProduction());
        Model::preventAccessingMissingAttributes();
        Paginator::useBootstrapFive();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('developer') ? true : null;
        });

        LogViewer::auth(function ($request) {
            $user = Auth::guard('admin')->user();

            return $user && in_array($user->email, [
                'gmta.constantine@gmail.com',
            ]);
        });

        //        LogViewer::auth(function ($request) {
        //            $user = Auth::guard('web')->user();
        //
        //            return $user && in_array($user->email, [
        //                    'gmta.constantine@gmail.com',
        //                    'developer@developer.com'
        //                ]);
        //        });

        if (Schema::hasTable('languages')) {
            $locales = cache()->rememberForever('locales', function () {
                return Language::all();
            });
            View::share('locales', $locales);
        }
        if (Schema::hasTable('terms')) {
            $terms = Term::first();
            View::share('terms', $terms);
        }

        View::composer('frontend.components.contact', function ($view) {

            $socials = Social::where('is_active', true)->orderBy('id')->get();

            $view->with([
                'socials' => $socials,
            ]);
        });

        View::composer('frontend.*', function ($view) {
            // These variables stay in memory for the single request
            static $activeColor, $siteSettings;
            // 1. Only fetch Color if we haven't already this request
            $activeColor ??= cache()->rememberForever('active_button_color', function () {
                return ButtonColor::where('is_active', 1)->first();
            });

            // 3. Only fetch Settings if we haven't already
            $siteSettings ??= cache()->rememberForever('site_settings', function () {
                return Setting::first();
            });

            // Inject into whatever view is currently being rendered (Layout, Yield, or Include)
            $view->with([
                'active_color' => $activeColor,
                'site_settings' => $siteSettings,
            ]);
        });

        view()->composer('frontend.components.categories', function ($view) {
            $categories = Category::where('removed_from_store', false)
                ->with(['subcategories' => function ($query) {
                    $query->where('removed_from_store', false)->select('id', 'category_id', 'name', 'slug');
                }])
                ->get(['id', 'name', 'slug'])
                ->map(function ($cat) {
                    return (object) [
                        'name' => $cat->name,
                        'slug' => $cat->slug,
                        'subcategories' => $cat->subcategories->map(function ($sub) {
                            return (object) [
                                'name' => $sub->name,
                                'slug' => $sub->slug,
                            ];
                        }),
                    ];
                });

            //
            //                Cache::tags(['categories'])
            //                ->rememberForever('categories', function () {
            //                    return  Category::with(['subcategories:id,category_id,name,slug'])
            //                        ->get(['id','name','slug'])
            //                        ->map(function ($cat) {
            //                            return (object)[
            //                                'name' => $cat->name,
            //                                'slug' => $cat->slug,
            //                                'subcategories' => $cat->subcategories->map(function ($sub) {
            //                                    return (object)[
            //                                        'name' => $sub->name,
            //                                        'slug' => $sub->slug,
            //                                    ];
            //                                }),
            //                            ];
            //                        });
            //                });

            return $view->with(compact('categories'));
        });

    }
}
