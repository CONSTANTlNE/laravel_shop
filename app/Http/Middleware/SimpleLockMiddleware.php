<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SimpleLockMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only check state-changing requests
        if ($request->isMethodSafe()) {
            return $next($request);
        }

        $idempotencyKey = $request->input('idempotency_key');
        $userId = auth()->id() ?? $request->ip(); // Fallback to IP for guests

        if (! $idempotencyKey) {
            return $next($request);
        }

        $cacheKey = "form_submit_{$userId}_$idempotencyKey";

        // Try to acquire atomic lock
        $lock = Cache::lock($cacheKey, 600);

        if (! $lock->get()) {
            // Key already exists = duplicate submission
            //            return $this->duplicateResponse($request);
            return response()->noContent();
        }

        // Store lock for cleanup in terminate
        $request->attributes->set('idempotency_lock', $lock);

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        // Keep the lock for successful submissions (don't release)
        // Only release on errors so user can retry
        if ($response->isSuccessful() || $response->isRedirection()) {
            // Lock stays in cache for TTL duration
            return;
        }

        // Release lock on error so user can resubmit
        $lock = $request->attributes->get('idempotency_lock');
        if ($lock) {
            $lock->release();
        }
    }

    private function duplicateResponse(Request $request): Response
    {
        $message = 'This form was already submitted. Please refresh the page.';

        // HTMX request
        if ($request->header('HX-Request')) {
            return response($message, 429)
                ->header('HX-Trigger', json_encode([
                    'showAlert' => [
                        'type' => 'error',
                        'message' => $message,
                    ],
                ]));
        }

        // API/AJAX request
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'duplicate' => true,
            ], 429);
        }

        // Regular form submission
        return back()
            ->withInput()
            ->with('error', $message);
    }
}
