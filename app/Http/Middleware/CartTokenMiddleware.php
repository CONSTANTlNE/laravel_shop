<?php

namespace App\Http\Middleware;

use App\Models\CartItem;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // If cart_token cookie does not exist
        if (! $request->hasCookie('cart_token')) {
            $token = Str::uuid()->toString();
            // Queue it so Laravel attaches it to the response automatically
            Cookie::queue('cart_token', $token, 60 * 24 * 30); // 30 days
        }

        $carttotal = null; // prevent multiple DB calls if re-run

        if ($carttotal === null) {
            $carttotal = 0;

            // 1️⃣ Get authenticated owner (web/admin)
            $owner = null;
            foreach (['web', 'admin'] as $guard) {
                if (Auth::guard($guard)->check()) {
                    $owner = Auth::guard($guard)->user();
                    break;
                }
            }

            //            dd($owner);
            if ($owner) {
                // Authenticated: sum owner's cart items
                $carttotal = CartItem::where('owner_id', $owner->id)
                    ->where('owner_type', get_class($owner))
                    ->sum('quantity');
                //                dd($carttotal);
            } else {
                // Guest: sum by token
                $carttoken = $request->cookie('cart_token');
                if ($carttoken) {
                    $carttotal = CartItem::where('cart_token', $carttoken)
                        ->where('owner_id', null)
                        ->sum('quantity');
                }
            }

            view()->share('carttotal', $carttotal);
        }

        return $next($request);
    }
}
