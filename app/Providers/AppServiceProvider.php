<?php

namespace App\Providers;

use App\Models\ButtonColor;
use App\Models\Category;
use App\Models\Export;
use App\Models\Language;
use App\Models\Setting;
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
            $locales = Language::all();
            View::share('locales', $locales);
        }
        if (Schema::hasTable('terms')) {
            $terms = Term::first();
            View::share('terms', $terms);
        }
        if (Schema::hasTable('terms')) {
            $site_settings = Setting::first();
            View::share('site_settings', $site_settings);
        }

        View()->composer('frontend.components.layout', function ($view) {
            $active_color = ButtonColor::where('is_active', 1)->first();
            $export = Export::where('admin_id', auth('admin')->id())
                ->where('status', 'completed')
                ->with('media')->first();

            return $view->with(compact('active_color', 'export'));
        });

        view()->composer('frontend.components.categories', function ($view) {
            $categories = Category::with(['subcategories:id,category_id,name,slug'])
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
