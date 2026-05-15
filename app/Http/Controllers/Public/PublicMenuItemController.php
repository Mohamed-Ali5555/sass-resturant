<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\RestaurantTable;
use App\Services\CartService;
use Illuminate\View\View;

class PublicMenuItemController extends Controller
{
    public function __construct(
        private CartService $cart,
    ) {}

    public function show(Restaurant $restaurant, int $item): View
    {
        $menuItem = MenuItem::query()
            ->where('restaurant_id', $restaurant->getKey())
            ->whereKey($item)
            ->where('is_available', true)
            ->firstOrFail();

        $this->cart->setRestaurant($restaurant);

        $activeTable = null;
        if ($tid = $this->cart->getRestaurantTableId()) {
            $activeTable = RestaurantTable::query()
                ->where('restaurant_id', $restaurant->getKey())
                ->find($tid);
            if (! $activeTable) {
                $this->cart->setRestaurantTable(null);
            }
        }

        return view('public.menu-item', compact('restaurant', 'menuItem', 'activeTable'));
    }
}
