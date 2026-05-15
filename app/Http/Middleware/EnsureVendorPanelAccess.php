<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVendorPanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $request->expectsJson()
                ? response()->json(['message' => __('Unauthenticated.')], 401)
                : redirect()->guest(route('login'));
        }

        if ($user->can('vendor.panel') || $user->can('admin.access')) {
            return $next($request);
        }

        abort(403, __('You do not have access to the restaurant panel.'));
    }
}
