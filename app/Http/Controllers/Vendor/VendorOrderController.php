<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorOrderController extends Controller
{
    public function index(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $query = $restaurant->orders()->orderByDesc('id');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        $orders = $query->paginate(20);

        return view('vendor.orders.index', compact('restaurant', 'orders'));
    }

    public function show(Request $request, Order $order): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $order->restaurant_id === (int) $restaurant->getKey(), 404);

        $this->authorize('view', $order);

        $order->load(['orderItems', 'orderPayments']);

        return view('vendor.orders.show', compact('restaurant', 'order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $order->restaurant_id === (int) $restaurant->getKey(), 404);

        $order->update([
            'status' => OrderStatus::from($request->validated('status')),
        ]);

        return back()->with('status', 'Order updated.');
    }
}
