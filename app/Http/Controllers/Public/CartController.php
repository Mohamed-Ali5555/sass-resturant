<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Cart\StoreCartItemRequest;
use App\Http\Requests\Public\Cart\UpdateCartItemRequest;
use App\Models\Restaurant;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private CartService $cart,
    ) {}

    public function index(Restaurant $restaurant): View
    {
        $this->cart->setRestaurant($restaurant);
        $summary = $this->cart->summarize($restaurant);

        return view('public.cart', compact('restaurant', 'summary'));
    }

    public function store(StoreCartItemRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $this->cart->addLine(
            $restaurant,
            (int) $request->validated('menu_item_id'),
            (int) $request->validated('qty', 1),
        );

        return back()->with('status', 'Added to cart.');
    }

    public function update(UpdateCartItemRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $this->cart->updateLine(
            $restaurant,
            (int) $request->validated('menu_item_id'),
            (int) $request->validated('qty'),
        );

        return back()->with('status', 'Cart updated.');
    }

    public function destroy(Restaurant $restaurant, int $menuItem): RedirectResponse
    {
        $this->cart->removeLine($restaurant, $menuItem);

        return back()->with('status', 'Removed.');
    }
}
