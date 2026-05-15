<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Restaurant\SwitchRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VendorDashboardController extends Controller
{
    public function index(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $subscription = $restaurant->latestSubscription();

        $excluded = [OrderStatus::Canceled, OrderStatus::PendingPayment];
        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();
        $weekAgo = now()->subDays(7)->startOfDay();
        $monthAgo = now()->subDays(30)->startOfDay();

        $todayOrders = $restaurant->orders()->where('created_at', '>=', $today)->count();
        $todayRevenue = (float) $restaurant->orders()
            ->where('created_at', '>=', $today)
            ->whereNotIn('status', $excluded)
            ->sum('grand_total');

        $monthOrders = $restaurant->orders()->where('created_at', '>=', $monthAgo)->count();
        $monthRevenue = (float) $restaurant->orders()
            ->where('created_at', '>=', $monthAgo)
            ->whereNotIn('status', $excluded)
            ->sum('grand_total');

        $openOrders = $restaurant->orders()
            ->whereIn('status', ['new', 'preparing', 'ready'])
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $weeklyChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->startOfDay();
            $end = (clone $day)->endOfDay();
            $base = $restaurant->orders()->whereBetween('created_at', [$day, $end]);
            $weeklyChart[] = [
                'label' => $day->format('D'),
                'orders' => (clone $base)->count(),
                'revenue' => (float) (clone $base)->whereNotIn('status', $excluded)->sum('grand_total'),
            ];
        }

        $topItems = $restaurant->orders()
        ->where('orders.created_at', '>=', $monthAgo)  // ✅ حدد الجدول
        ->whereNotIn('orders.status', $excluded)         // ✅ حدد الجدول
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->selectRaw('order_items.item_name_snapshot as name, SUM(order_items.qty) as qty')
        ->groupBy('order_items.item_name_snapshot')
        ->orderByDesc('qty')
        ->limit(5)
        ->get();

        $totalMenuItems = $restaurant->menuItems()->count();
        $totalTables = $restaurant->restaurantTables()->count();
        $totalStaff = $restaurant->staffUsers()->count();
        $activeCoupons = $restaurant->coupons()->where('is_active', true)->count();

        return view('vendor.dashboard', compact(
            'restaurant', 'openOrders', 'subscription',
            'todayOrders', 'todayRevenue', 'monthOrders', 'monthRevenue',
            'weeklyChart', 'topItems', 'totalMenuItems', 'totalTables',
            'totalStaff', 'activeCoupons',
        ));
    }

    public function switch(SwitchRestaurantRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $restaurant = Restaurant::query()->findOrFail($data['restaurant_id']);

        $request->session()->put('vendor_restaurant_id', $restaurant->getKey());

        return redirect()->route('vendor.dashboard');
    }
}
