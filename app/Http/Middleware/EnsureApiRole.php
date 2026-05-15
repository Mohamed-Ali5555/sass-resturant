<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Role check for Sanctum API routes (uses $request->user()).
 */
class EnsureApiRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => __('Unauthenticated.')], 401);
        }

        if (! $user->hasAnyRole($roles)) {
            return response()->json(['message' => __('Forbidden.')], 403);
        }

        return $next($request);
    }
}
