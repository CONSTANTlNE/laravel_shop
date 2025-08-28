<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Opcodes\LogViewer\Facades\LogViewer;
use Illuminate\Support\Facades\URL;

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

        LogViewer::auth(function ($request) {
            $user = Auth::guard('admin')->user();

            return $user && in_array($user->email, [
                    'gmta.constantine@gmail.com',
                ]);
        });
    }
}
