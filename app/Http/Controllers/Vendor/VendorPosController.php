<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VendorPosController extends Controller
{
    public function index(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $categories = $restaurant->categories()
            ->with(['menuItems' => fn ($q) => $q->where('is_available', true)->orderBy('name')])
            ->orderBy('sort_order')
            ->get();

        $tables = $restaurant->restaurantTables()->orderByRaw('CAST(table_code AS UNSIGNED)')->get();

        return view('vendor.pos.index', compact('restaurant', 'categories', 'tables'));
    }

    public function storeOrder(Request $request): JsonResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $validated = $request->validate([
            'order_type' => ['required', 'in:dine_in,takeaway,delivery'],
            'customer_name' => ['nullable', 'string', 'max:120'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'table_number' => ['nullable', 'string', 'max:30'],
            'customer_notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ]);

        // Verify all items belong to this restaurant
        $menuItemIds = collect($validated['items'])->pluck('id')->unique()->values()->all();
        $menuItems = MenuItem::query()
            ->whereIn('id', $menuItemIds)
            ->where('restaurant_id', $restaurant->getKey())
            ->get()
            ->keyBy('id');

        if ($menuItems->count() !== count($menuItemIds)) {
            return response()->json(['message' => __('Invalid menu item.')], 422);
        }

        $subtotal = 0.0;
        $lineItems = [];
        foreach ($validated['items'] as $line) {
            /** @var MenuItem $item */
            $item = $menuItems->get($line['id']);
            $lineTotal = (float) $item->price * $line['qty'];
            $subtotal += $lineTotal;
            $lineItems[] = [
                'menu_item_id' => $item->id,
                'item_name_snapshot' => $item->name,
                'unit_price' => $item->price,
                'qty' => $line['qty'],
                'line_total' => $lineTotal,
            ];
        }

        $taxTotal = round($subtotal * ((float) ($restaurant->tax_rate_percent ?? 0)) / 100, 2);
        $grandTotal = $subtotal + $taxTotal;

        $order = $restaurant->orders()->create([
            'public_ref' => strtoupper(Str::random(8)),
            'order_type' => OrderType::from($validated['order_type']),
            'order_mode' => $validated['order_type'], 
            'status' => OrderStatus::New,
            'subtotal' => $subtotal,
            'tax_total' => $taxTotal,
            'delivery_fee' => 0,
            'grand_total' => $grandTotal,
            'customer_name' => $validated['customer_name'] ??  'mohamed',
            'customer_phone' => $validated['customer_phone'] ?? '01026833710',
            'table_number' => $validated['table_number'] ?? null,
            'customer_notes' => $validated['customer_notes'] ?? 'mohamed',
        ]);

        foreach ($lineItems as $li) {
            $order->orderItems()->create($li);
        }

        return response()->json([
            'ok' => true,
            'order_ref' => $order->public_ref,
            'order_id' => $order->id,
            'grand_total' => (float) $order->grand_total,
        ], 201);
    }
}
