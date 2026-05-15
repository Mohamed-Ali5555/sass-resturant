<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminAnalyticsController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Restaurant::class);

        $excludedForGmv = [OrderStatus::Canceled, OrderStatus::PendingPayment];

        $chartDays = [];
        for ($i = 29; $i >= 0; $i--) {
            $day = now()->subDays($i)->startOfDay();
            $end = (clone $day)->endOfDay();
            $base = Order::query()->whereBetween('created_at', [$day, $end]);
            $chartDays[] = [
                'label' => $day->format('M j'),
                'orders' => (clone $base)->count(),
                'gmv' => (float) (clone $base)->whereNotIn('status', $excludedForGmv)->sum('grand_total'),
            ];
        }

        $maxChartOrders = max(1, ...array_column($chartDays, 'orders'));
        $maxChartGmv = max(1, ...array_column($chartDays, 'gmv'));

        $since = now()->subDays(30);

        $statusRows = Order::query()
            ->select('status', DB::raw('count(*) as cnt'))
            ->where('created_at', '>=', $since)
            ->groupBy('status')
            ->get();

        $topRestaurants = Order::query()
            ->selectRaw('restaurant_id, SUM(grand_total) as gmv, COUNT(*) as order_cnt')
            ->where('created_at', '>=', $since)
            ->whereNotIn('status', $excludedForGmv)
            ->groupBy('restaurant_id')
            ->orderByDesc('gmv')
            ->limit(10)
            ->get();

        $restaurantNames = Restaurant::query()
            ->whereIn('id', $topRestaurants->pluck('restaurant_id'))
            ->pluck('name', 'id');

        return view('admin.analytics', compact(
            'chartDays',
            'maxChartOrders',
            'maxChartGmv',
            'statusRows',
            'topRestaurants',
            'restaurantNames',
        ));
    }
}
