<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureApiAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
                'errors' => [
                    'token' => 'Invalid or missing bearer token'
                ]
            ], 401);
        }

        // Check if token has expired or is invalid
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token Invalid',
                'errors' => [
                    'token' => 'The provided token is invalid'
                ]
            ], 401);
        }

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}