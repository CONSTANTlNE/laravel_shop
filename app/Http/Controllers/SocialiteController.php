<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

/**
 * @property-read \App\Models\Setting $setting
 */
class SocialiteController extends Controller
{
    public function googleredirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googlecallback()
    {

        try {
            $user = Socialite::driver('google')->user();

            // dd($user);

            $existing = User::where('email', $user->email)->first();

            if ($existing) {

                if ($existing->auth_type === 'facebook') {

                    return redirect()->route('login', ['locale' => app()->getLocale()])->with('alert_error',
                        __('Email already registered'));

                }

                if ($existing->auth_type === null) {

                    return redirect()->route('home', ['locale' => app()->getLocale()])->with('alert_error',
                        __('Email already registered'));
                }

            }

            $google_user = User::where('social_id', $user->id)->first();

            if (! $google_user) {

                $google_user = User::create([
                    'social_id' => $user->id,
                    'name' => $user->name,
                    'auth_type' => 'google',
                    'email' => $user->email,
                    'password' => 'khG$%669@fgTklop896',
                    'adminpass' => 'khG$%669@fgTklop896',
                ]);

                event(new Registered($google_user));
            }

            Auth::login($google_user);

//            return back()->withInput();
            return redirect()->route('home', ['locale' => app()->getLocale()]);

        } catch (Exception $e) {
            Log::channel('socialite')->error($e->getMessage());
            return redirect()->route('home', ['locale' => app()->getLocale()])
                ->with('alert_error', __('Google login failed'));
        }
    }
}
