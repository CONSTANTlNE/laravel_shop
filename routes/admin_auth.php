<?php

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\RoutePath;
use Illuminate\Support\Facades\Route;

Route::prefix('{locale?}')
    ->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware([ 'localization'])
    ->group(function () {
        route::get('/admin', fn () => view('admin.auth.admin_login'))
            ->middleware(['localization','guest:admin'])
            ->name('admin.login');
    });

route::get('/admin', fn () => view('admin.auth.admin_login'))
    ->middleware(['localization','guest:admin'])
    ->name('admin.login3');



$limiter = config('fortify.limiters.login');
$twoFactorLimiter = config('fortify.limiters.two-factor');
$verificationLimiter = config('fortify.limiters.verification', '6,1');

Route::post(RoutePath::for('admin.login2', '/admin/login'), [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'guest:admin',
        $limiter ? 'throttle:'.$limiter : null,
    ]))->name('admin.login2');


Route::post(RoutePath::for('admin.logout', '/admin/logout'), [AuthenticatedSessionController::class, 'destroy'])
    ->middleware([config('fortify.auth_middleware', 'auth').':admin'])
    ->name('admin.logout');
