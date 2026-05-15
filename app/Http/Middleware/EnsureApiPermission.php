<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Permission check for Sanctum API routes (uses $request->user(), not session guard).
 */
class EnsureApiPermission
{
    public function handle(Request $request, Closure $next, string ...$permissionParts): Response
    {
        $permission = implode('.', $permissionParts);
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => __('Unauthenticated.')], 401);
        }

        if (! $user->hasPermissionTo($permission)) {
            return response()->json(['message' => __('Forbidden.')], 403);
        }

        return $next($request);
    }
}
