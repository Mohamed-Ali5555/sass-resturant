<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HubOrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->with('restaurant')
            ->orderByDesc('id')
            ->paginate(12);

        return view('account.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        $this->authorize('view', $order);

        $order->load(['restaurant', 'orderItems', 'orderPayments']);

        return view('account.orders.show', compact('order'));
    }
}
