<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     */
    protected function gate(): void
    {

    // Note the $user = null to allow the gate to run even if 'web' user is not logged in
        Gate::define('viewHorizon', function ($user = null) {
            // Explicitly get the user from your admin guard
            $admin = auth()->guard('admin')->user();

            // Check if an admin is logged in and if their email is allowed
            return $admin && in_array($admin->email, [
                    'gmta.constantine@gmail.com',
                ]);
        });

    }
}
