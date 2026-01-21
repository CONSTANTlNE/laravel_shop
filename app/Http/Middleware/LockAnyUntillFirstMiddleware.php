<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LockAnyUntillFirstMiddleware
{
    // Recommended

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethodSafe()) {
            return $next($request);
        }

        // Get user ID or fall back to IP address
        $userId = auth('web')->id() ?? $request->ip();

        // Get route name or fall back to path
        $routeName = $request->route()?->getName() ?? $request->path();

        if (! $userId) {
            return $next($request);
        }

        // Lock ANY submission for this user on this form
        $cacheKey = "user_{$userId}_submitting_{$routeName}";

        $lock = Cache::lock($cacheKey, 30); // Shorter timeout

        if (! $lock->get()) {
            // Check if this is an HTMX request
            if ($request->header('HX-Request')) {
                return $this->htmxErrorResponse(
                    'This form was already submitted. Please refresh the page.'
                );
            }

            // Regular form submission
            return back()
                ->withInput()
                ->with('error', 'Please wait for your previous submission to complete.');
        }

        $request->attributes->set('user_submission_lock', $lock);

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        $lock = $request->attributes->get('user_submission_lock');
        if ($lock) {
            $lock->release(); // Always release so user can submit again
        }
    }

    private function htmxErrorResponse(string $message): Response
    {
        // Option 1: Return HTML fragment with error
        return response()
            ->view('components.alert', [
                'type' => 'error',
                'message' => $message,
            ], 409) // 409 Conflict status
            ->header('HX-Reswap', 'innerHTML') // Tell HTMX how to swap
            ->header('HX-Retarget', '#error-container'); // Where to put it

        // Option 2: Trigger client-side event
        // return response('', 409)
        //     ->header('HX-Trigger', json_encode([
        //         'showError' => $message
        //     ]));
    }
}
