<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function show(Restaurant $restaurant, string $publicRef): View
    {
        $order = Order::query()
            ->where('public_ref', $publicRef)
            ->where('restaurant_id', $restaurant->getKey())
            ->firstOrFail();

        $order->load(['orderItems', 'orderPayments']);

        return view('public.order-show', compact('restaurant', 'order'));
    }
}
