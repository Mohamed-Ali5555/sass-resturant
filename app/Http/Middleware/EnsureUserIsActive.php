<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->is_disabled) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('This account has been disabled.'),
                ], 403);
            }

            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => __('This account has been disabled.'),
            ]);
        }

        return $next($request);
    }
}
