<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Restaurant\ApproveRestaurantRequest;
use App\Http\Requests\Admin\Restaurant\SuspendRestaurantRequest;
use App\Http\Requests\Admin\Restaurant\UpdateRestaurantSubscriptionRequest;
use App\Models\Restaurant;
use App\Models\RestaurantSubscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminRestaurantController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Restaurant::class);

        $status = $request->query('status', 'all');
        $q = trim((string) $request->query('q', ''));

        $query = Restaurant::query()
            ->with('vendorOwner')
            ->withCount('orders');

        if (in_array($status, ['active', 'suspended'], true)) {
            $query->where('status', $status);
        }

        if ($q !== '') {
            $query->where(function ($sub) use ($q): void {
                $sub->where('name', 'like', '%'.$q.'%')
                    ->orWhere('slug', 'like', '%'.$q.'%')
                    ->orWhereHas('vendorOwner', function ($owner) use ($q): void {
                        $owner->where('email', 'like', '%'.$q.'%')
                            ->orWhere('name', 'like', '%'.$q.'%');
                    });
            });
        }

        $restaurants = $query->orderByDesc('id')->paginate(25)->withQueryString();

        return view('admin.restaurants.index', compact('restaurants', 'status', 'q'));
    }

    public function show(Restaurant $restaurant): View
    {
        $this->authorize('view', $restaurant);

        $restaurant->loadCount('orders')->load(['vendorOwner']);
        $subscription = $restaurant->latestSubscription();
        $plans = SubscriptionPlan::query()->where('is_active', true)->orderBy('name')->get();

        return view('admin.restaurants.show', compact('restaurant', 'subscription', 'plans'));
    }

    public function approve(ApproveRestaurantRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $restaurant->update([
            'status' => 'active',
            'suspension_reason' => null,
        ]);

        return redirect()
            ->back()
            ->with('status', __('Restaurant approved (active).'));
    }

    public function suspend(SuspendRestaurantRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $restaurant->update([
            'status' => 'suspended',
            'suspension_reason' => $request->validated('suspension_reason'),
        ]);

        return redirect()
            ->back()
            ->with('status', __('Restaurant suspended.'));
    }

    public function updateSubscription(UpdateRestaurantSubscriptionRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $data = $request->validated();

        RestaurantSubscription::query()->updateOrCreate(
            ['restaurant_id' => $restaurant->getKey()],
            [
                'subscription_plan_id' => $data['subscription_plan_id'],
                'status' => $data['status'],
                'billing_cycle' => $data['billing_cycle'] ?? null,
                'trial_ends_at' => $data['trial_ends_at'] ?? null,
                'current_period_start' => $data['current_period_start'] ?? null,
                'current_period_end' => $data['current_period_end'] ?? null,
                'canceled_at' => $data['canceled_at'] ?? null,
                'external_subscription_id' => $data['external_subscription_id'] ?? null,
            ],
        );

        return redirect()
            ->route('admin.restaurants.show', $restaurant)
            ->with('status', __('Subscription updated.'));
    }
}
