<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVendorCanManageRestaurant
{
    public function handle(Request $request, Closure $next): Response
    {
        $restaurant = $request->attributes->get('vendorRestaurant');

        if (! $restaurant || ! $restaurant->vendorCanManage()) {
            abort(403, 'Subscription does not allow management right now.');
        }

        return $next($request);
    }
}
