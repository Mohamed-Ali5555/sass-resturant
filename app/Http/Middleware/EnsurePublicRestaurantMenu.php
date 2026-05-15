<?php

namespace App\Http\Middleware;

use App\Models\Restaurant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePublicRestaurantMenu
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->route('restaurant');

        if (! $restaurant->canShowPublicMenu()) {
            abort(404);
        }

        return $next($request);
    }
}
