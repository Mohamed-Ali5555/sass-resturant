<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorKitchenController extends Controller
{
    /** Active kitchen statuses (not yet delivered/canceled). */
    private const ACTIVE_STATUSES = [
        OrderStatus::New->value,
        OrderStatus::Preparing->value,
        OrderStatus::Ready->value,
    ];

    public function index(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $orders = $this->activeOrders($restaurant);

        return view('vendor.kitchen.dashboard', compact('restaurant', 'orders'));
    }

    /**
     * JSON feed polled by the KDS every N seconds.
     */
    public function feed(Request $request): JsonResponse
    {    
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $orders = $this->activeOrders($restaurant);

        return response()->json([
            'timestamp' => now()->toIso8601String(),
            'orders' => $orders->map(fn (Order $o) => [
                'id' => $o->id,
                'public_ref' => $o->public_ref,
                'status' => $o->status->value,
                'order_type' => $o->order_type?->value,
                'table_number' => $o->table_number,
                'customer_notes' => $o->customer_notes,
                'created_at' => $o->created_at?->toIso8601String(),
                'minutes_ago' => (int) $o->created_at?->diffInMinutes(now()),
                'est_prep_minutes' => $this->estimatePrepTime($o),
                'items' => $o->orderItems->map(fn ($i) => [
                    'name' => $i->item_name_snapshot,
                    'qty' => $i->qty,
                    'notes' => $i->customizations_snapshot['notes'] ?? null,
                ])->values(),
            ])->values(),
        ]);
    }

    /**
     * Update order status from the kitchen.
     */
    public function updateStatus(Request $request, Order $order): JsonResponse|RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $order->restaurant_id === (int) $restaurant->getKey(), 404);

        $next = $request->input('status');

        $allowed = array_merge(self::ACTIVE_STATUSES, [OrderStatus::Completed->value]);
        abort_unless(in_array($next, $allowed, true), 422);

        $order->update(['status' => OrderStatus::from($next)]);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'status' => $order->status->value]);
        }

        return back()->with('status', __('Order updated.'));
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, Order> */
    private function activeOrders(Restaurant $restaurant)
    {
        return $restaurant->orders()
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->with('orderItems')
            ->orderBy('created_at')
            ->get();
    }

    private function estimatePrepTime(Order $order): int
    {
        $itemCount = $order->orderItems->sum('qty');

        return 5 + (int) ceil($itemCount * 1.5);
    }
}
