<?php

namespace App\Http\Middleware;

use App\Models\Restaurant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVendorRestaurantSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('login'));
        }

        $restaurantId = (int) $request->session()->get('vendor_restaurant_id');

        if ($restaurantId) {
            $restaurant = Restaurant::query()->find($restaurantId);
            if ($restaurant && $user->canAccessRestaurant($restaurant)) {
                $request->attributes->set('vendorRestaurant', $restaurant);

                return $next($request);
            }
        }

        if ($user->isSuperAdmin()) {
            $fallback = Restaurant::query()->orderBy('id')->first();
            if ($fallback) {
                $request->session()->put('vendor_restaurant_id', $fallback->getKey());
                $request->attributes->set('vendorRestaurant', $fallback);

                return $next($request);
            }
        }

        $owned = $user->ownedRestaurants()->orderBy('id')->first();
        if ($owned) {
            $request->session()->put('vendor_restaurant_id', $owned->getKey());
            $request->attributes->set('vendorRestaurant', $owned);

            return $next($request);
        }

        $staff = $user->activeRestaurantsAsStaff()->orderBy('restaurants.id')->first();
        if ($staff) {
            $request->session()->put('vendor_restaurant_id', $staff->getKey());
            $request->attributes->set('vendorRestaurant', $staff);

            return $next($request);
        }

        abort(403, 'No restaurant assigned.');
    }
}
