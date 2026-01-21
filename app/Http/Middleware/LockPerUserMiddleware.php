<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LockPerUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethodSafe()) {
            return $next($request);
        }

        $idempotencyKey = $request->input('idempotency_key');
        $userId = auth()->id(); // Get authenticated user ID
        $routeName = $request->route()->getName(); // Or use URL

        if (! $idempotencyKey || ! $userId) {
            return $next($request);
        }

        // Lock per user per form type
        $cacheKey = "form_submit_{$userId}_{$routeName}_{$idempotencyKey}";

        $lock = Cache::lock($cacheKey, 600);

        if (! $lock->get()) {
            return back()
                ->withInput()
                ->with('error', 'This form was already submitted. Please refresh the page.');
        }

        $request->attributes->set('idempotency_lock', $lock);

        return $next($request);
    }
}
