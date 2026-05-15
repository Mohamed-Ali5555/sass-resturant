<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\PlatformCommission;
use App\Models\Restaurant;
use App\Models\SubscriptionPlan;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Restaurant::class);

        $restaurantsCount = Restaurant::query()->count();
        $activeRestaurantsCount = Restaurant::query()->where('status', 'active')->count();
        $suspendedRestaurantsCount = Restaurant::query()->where('status', 'suspended')->count();
        $plansCount = SubscriptionPlan::query()->count();

        $ordersTotal = Order::query()->count();

        $gmvQuery = Order::query()->whereNotIn('status', [
            OrderStatus::Canceled,
            OrderStatus::PendingPayment,
        ]);

        $gmvTotal = (float) (clone $gmvQuery)->sum('grand_total');

        $platformRate = (float) (PlatformCommission::query()
            ->where('scope_type', PlatformCommission::SCOPE_PLATFORM)
            ->where('scope_id', 0)
            ->value('commission_percent') ?? 0);

        $estimatedCommissions = round($gmvTotal * ($platformRate / 100), 2);

        $chartDays = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->startOfDay();
            $end = (clone $day)->endOfDay();
            $dayOrders = Order::query()->whereBetween('created_at', [$day, $end])->count();
            $dayGmv = (float) Order::query()
                ->whereBetween('created_at', [$day, $end])
                ->whereNotIn('status', [OrderStatus::Canceled, OrderStatus::PendingPayment])
                ->sum('grand_total');
            $chartDays[] = [
                'label' => $day->format('M j'),
                'orders' => $dayOrders,
                'gmv' => $dayGmv,
            ];
        }

        $maxChartGmv = max(1, ...array_column($chartDays, 'gmv'));
        $maxChartOrders = max(1, ...array_column($chartDays, 'orders'));

        return view('admin.dashboard', compact(
            'restaurantsCount',
            'activeRestaurantsCount',
            'suspendedRestaurantsCount',
            'plansCount',
            'ordersTotal',
            'gmvTotal',
            'platformRate',
            'estimatedCommissions',
            'chartDays',
            'maxChartGmv',
            'maxChartOrders',
        ));
    }
}
