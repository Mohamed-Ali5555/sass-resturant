<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantTable;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;

class RestaurantTableQrController extends Controller
{
    public function __construct(
        private CartService $cart,
    ) {}

    public function visit(Restaurant $restaurant, string $qr_token): RedirectResponse
    {
        $table = RestaurantTable::query()
            ->where('restaurant_id', $restaurant->getKey())
            ->where('qr_token', $qr_token)
            ->firstOrFail();

        $this->cart->setRestaurant($restaurant);
        $this->cart->setRestaurantTable((int) $table->getKey());

        return redirect()
            ->route('public.restaurant.show', ['restaurant' => $restaurant->slug])
            ->with('status', __('You are ordering for table :label.', ['label' => $table->label]));
    }

    public function clear(Restaurant $restaurant): RedirectResponse
    {
        $this->cart->setRestaurant($restaurant);
        $this->cart->setRestaurantTable(null);

        return redirect()->route('public.restaurant.show', ['restaurant' => $restaurant->slug]);
    }
}
