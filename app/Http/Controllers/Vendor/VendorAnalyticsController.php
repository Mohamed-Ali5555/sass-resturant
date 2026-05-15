<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VendorAnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
    
        $excludedForGmv = [OrderStatus::Canceled, OrderStatus::PendingPayment];
    
        $chartDays = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = now()->subDays($i)->startOfDay();
            $end = (clone $day)->endOfDay();
            $base = $restaurant->orders()->whereBetween('created_at', [$day, $end]); // ✅ لا join هنا = لا مشكلة
            $chartDays[] = [
                'label' => $day->format('M j'),
                'orders' => (clone $base)->count(),
                'gmv' => (float) (clone $base)->whereNotIn('status', $excludedForGmv)->sum('grand_total'),
            ];
        }
    
        $maxChartOrders = max(1, ...array_column($chartDays, 'orders'));
        $maxChartGmv = max(1, ...array_column($chartDays, 'gmv'));
    
        $since = now()->subDays(30);
    
        $statusRows = $restaurant->orders()
            ->select('status', DB::raw('count(*) as cnt'))
            ->where('created_at', '>=', $since) // ✅ لا join = لا مشكلة
            ->groupBy('status')
            ->get();
    
        $ordersLast30 = (int) $restaurant->orders()->where('created_at', '>=', $since)->count();
        $gmvLast30 = (float) $restaurant->orders()
            ->where('created_at', '>=', $since)
            ->whereNotIn('status', $excludedForGmv)
            ->sum('grand_total');
        $aovLast30 = $ordersLast30 > 0 ? round($gmvLast30 / $ordersLast30, 2) : 0.0;
    
        $topLines = Order::query()
            ->where('orders.restaurant_id', $restaurant->getKey())  // ✅ حدد الجدول
            ->where('orders.created_at', '>=', $since)              // ✅ حدد الجدول
            ->whereNotIn('orders.status', $excludedForGmv)          // ✅ حدد الجدول
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw('order_items.item_name_snapshot as name, SUM(order_items.line_total) as revenue, SUM(order_items.qty) as qty')
            ->groupBy('order_items.item_name_snapshot')
            ->orderByDesc('revenue')
            ->limit(8)
            ->get();
    
        return view('vendor.analytics', compact(
            'restaurant',
            'chartDays',
            'maxChartOrders',
            'maxChartGmv',
            'statusRows',
            'ordersLast30',
            'gmvLast30',
            'aovLast30',
            'topLines',
        ));
    }
}
