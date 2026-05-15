<?php

namespace App\Http\Controllers\Public;

use App\Enums\OrderMode;
use App\Enums\OrderStatus;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Checkout\StoreCheckoutRequest;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\RestaurantTable;
use App\Services\CartService;
use App\Services\Payments\StripeCheckoutDriver;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cart,
        private StripeCheckoutDriver $stripe,
    ) {}

    public function create(Restaurant $restaurant): View
    {
        $this->cart->setRestaurant($restaurant);
        $summary = $this->cart->summarize($restaurant);

        $activeTable = null;
        if ($tid = $this->cart->getRestaurantTableId()) {
            $activeTable = RestaurantTable::query()
                ->where('restaurant_id', $restaurant->getKey())
                ->find($tid);
            if (! $activeTable) {
                $this->cart->setRestaurantTable(null);
            }
        }

        return view('public.checkout', compact('restaurant', 'summary', 'activeTable'));
    }

    public function store(StoreCheckoutRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $this->cart->setRestaurant($restaurant);
        $summary = $this->cart->summarize($restaurant);

        if (count($summary['lines']) === 0) {
            throw ValidationException::withMessages([
                'cart' => 'Your cart is empty.',
            ]);
        }

        $orderMode = OrderMode::from($request->validated('order_mode'));
        $paymentMethod = PaymentProvider::from($request->validated('payment_method'));

        $order = DB::transaction(function () use ($request, $restaurant, $summary, $orderMode, $paymentMethod) {
            $restaurantTableId = null;
            if ($orderMode === OrderMode::DineIn) {
                $tid = $this->cart->getRestaurantTableId();
                if ($tid) {
                    $tbl = RestaurantTable::query()
                        ->where('restaurant_id', $restaurant->getKey())
                        ->whereKey($tid)
                        ->first();
                    $restaurantTableId = $tbl?->getKey();
                }
            }

            $lockedRows = [];

            foreach ($summary['lines'] as $row) {
                /** @var MenuItem $item */
                $item = MenuItem::query()
                    ->whereKey($row['item']->getKey())
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($item->track_inventory) {
                    $qty = $row['qty'];
                    if ($item->stock_qty === null || $item->stock_qty < $qty) {
                        throw ValidationException::withMessages([
                            'cart' => 'One or more items are out of stock: '.$item->name,
                        ]);
                    }

                    $item->decrement('stock_qty', $qty);
                }

                $lockedRows[] = ['item' => $item, 'qty' => $row['qty']];
            }

            $subtotal = 0.0;
            foreach ($lockedRows as $row) {
                $subtotal += ((float) $row['item']->price) * $row['qty'];
            }

            $taxRate = (float) $restaurant->tax_rate_percent;
            $taxTotal = round($subtotal * ($taxRate / 100), 2);
            $deliveryFee = $orderMode === OrderMode::Delivery ? (float) $restaurant->delivery_fee : 0.0;
            $grandTotal = round($subtotal + $taxTotal + $deliveryFee, 2);

            $order = Order::query()->create([
                'public_ref' => $this->uniquePublicRef(),
                'restaurant_id' => $restaurant->getKey(),
                'user_id' => $request->user()?->getKey(),
                'restaurant_table_id' => $restaurantTableId,
                'order_mode' => $orderMode,
                'status' => $paymentMethod === PaymentProvider::Cod ? OrderStatus::New : OrderStatus::PendingPayment,
                'subtotal' => number_format($subtotal, 2, '.', ''),
                'tax_total' => number_format($taxTotal, 2, '.', ''),
                'delivery_fee' => number_format($deliveryFee, 2, '.', ''),
                'grand_total' => number_format($grandTotal, 2, '.', ''),
                'customer_name' => $request->validated('customer_name'),
                'customer_phone' => $request->validated('customer_phone'),
                'delivery_address' => $request->validated('delivery_address'),
                'table_number' => $request->validated('table_number'),
                'customer_notes' => $request->validated('customer_notes'),
            ]);

            foreach ($lockedRows as $row) {
                $item = $row['item'];
                $qty = $row['qty'];
                $lineTotal = round(((float) $item->price) * $qty, 2);

                OrderItem::query()->create([
                    'order_id' => $order->getKey(),
                    'menu_item_id' => $item->getKey(),
                    'item_name_snapshot' => $item->name,
                    'unit_price' => $item->price,
                    'qty' => $qty,
                    'line_total' => number_format($lineTotal, 2, '.', ''),
                    'modifiers_snapshot' => null,
                ]);
            }

            OrderPayment::query()->create([
                'order_id' => $order->getKey(),
                'type' => $paymentMethod,
                'status' => $paymentMethod === PaymentProvider::Cod ? PaymentStatus::Succeeded : PaymentStatus::Pending,
                'amount' => $order->grand_total,
                'currency' => $restaurant->currency,
                'provider_reference' => null,
                'meta' => [],
            ]);

            return $order->load(['orderItems', 'orderPayments', 'restaurant']);
        });

        $this->cart->clear();

        if ($paymentMethod === PaymentProvider::Stripe) {
            return $this->stripe->afterOrderCreated($order);
        }

        return redirect()->route('public.order.show', [
            'restaurant' => $restaurant->slug,
            'publicRef' => $order->public_ref,
        ]);
    }

    private function uniquePublicRef(): string
    {
        do {
            $ref = Str::upper(Str::random(12));
        } while (Order::query()->where('public_ref', $ref)->exists());

        return $ref;
    }
}
