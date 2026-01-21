<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LockMultipleMiddleware
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

        $userId = auth()->id();
        $idempotencyKey = $request->input('idempotency_key');
        $routeName = $request->route()?->getName() ?? $request->path();

        if (! $userId) {
            return $next($request);
        }

        // Lock 1: Prevent concurrent submissions from same user on same form
        $processingKey = "user_{$userId}_processing_{$routeName}";
        $processingLock = Cache::lock($processingKey, 30);

        if (! $processingLock->get()) {
            return $this->errorResponse(
                $request,
                'Please wait for your previous submission to complete.'
            );
        }

        // Lock 2: Prevent duplicate submission of same form (atomic)
        if ($idempotencyKey) {
            $idempotencyLockKey = "form_{$userId}_{$routeName}_{$idempotencyKey}";
            $idempotencyLock = Cache::lock($idempotencyLockKey, 600);

            if (! $idempotencyLock->get()) {
                $processingLock->release(); // Release processing lock

                return $this->errorResponse(
                    $request,
                    'This form was already submitted.'
                );
            }

            // Don't release idempotency lock - let it expire naturally
            // This prevents resubmission even after processing completes
        }

        $request->attributes->set('processing_lock', $processingLock);

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        // Always release processing lock so user can submit other forms
        $lock = $request->attributes->get('processing_lock');
        if ($lock) {
            $lock->release();
        }
    }

    private function errorResponse(Request $request, string $message): Response
    {
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
