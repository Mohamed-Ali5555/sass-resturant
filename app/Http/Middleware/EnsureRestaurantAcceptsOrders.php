<?php

namespace App\Http\Middleware;

use App\Models\Restaurant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRestaurantAcceptsOrders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->route('restaurant');

        if (! $restaurant->canAcceptPublicOrders()) {
            abort(403, 'This restaurant is not accepting online orders right now.');
        }

        return $next($request);
    }
}
