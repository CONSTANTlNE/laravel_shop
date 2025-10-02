<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Term;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
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
//        URL::forceScheme('https');
        Model::unguard();
        Model::preventLazyLoading(!app()->isProduction());
        Model::preventAccessingMissingAttributes();
        Paginator::useBootstrapFive();


        LogViewer::auth(function ($request) {
            $user = Auth::guard('admin')->user();

            return $user && in_array($user->email, [
                    'gmta.constantine@gmail.com',
                ]);
        });








        $locales = Language::all();
        $terms=Term::first();
        View::share('locales', $locales);
        View::share('terms', $terms);


        view()->composer('frontend.components.categories', function ($view) {
            $categories = Category::with('subcategories')
                ->get();

            return $view->with(compact('categories'));
        });

    }
}
