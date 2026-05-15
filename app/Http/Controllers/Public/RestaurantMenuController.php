<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantTable;
use App\Services\CartService;
use Illuminate\View\View;

class RestaurantMenuController extends Controller
{
    public function __construct(
        private CartService $cart,
    ) {}

    public function show(Restaurant $restaurant): View
    {
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

        $categories = $restaurant->categories()
            ->orderBy('sort_order')
            ->with(['menuItems' => fn ($q) => $q->where('is_available', true)->orderBy('name')])
            ->get();

        $menuUrl = route('public.restaurant.show', ['restaurant' => $restaurant->slug], true);

        return view('public.menu', compact('restaurant', 'categories', 'menuUrl', 'activeTable'));
    }
}
