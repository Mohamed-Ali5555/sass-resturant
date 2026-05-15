<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubscriptionPlan\DestroySubscriptionPlanRequest;
use App\Http\Requests\Admin\SubscriptionPlan\StoreSubscriptionPlanRequest;
use App\Http\Requests\Admin\SubscriptionPlan\UpdateSubscriptionPlanRequest;
use App\Models\SubscriptionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminSubscriptionPlanController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', SubscriptionPlan::class);

        $plans = SubscriptionPlan::query()->orderBy('name')->paginate(20);

        return view('admin.subscription-plans.index', compact('plans'));
    }

    public function create(): View
    {
        $this->authorize('create', SubscriptionPlan::class);

        return view('admin.subscription-plans.create');
    }

    public function store(StoreSubscriptionPlanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['features'] = $data['features'] ?? [];

        SubscriptionPlan::query()->create($data);

        return redirect()
            ->route('admin.subscription-plans.index')
            ->with('status', __('Subscription plan created.'));
    }

    public function edit(SubscriptionPlan $subscription_plan): View
    {
        $this->authorize('update', $subscription_plan);

        return view('admin.subscription-plans.edit', ['plan' => $subscription_plan]);
    }

    public function update(UpdateSubscriptionPlanRequest $request, SubscriptionPlan $subscription_plan): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['features'] = $data['features'] ?? [];

        $subscription_plan->update($data);

        return redirect()
            ->route('admin.subscription-plans.index')
            ->with('status', __('Subscription plan updated.'));
    }

    public function destroy(DestroySubscriptionPlanRequest $request, SubscriptionPlan $subscription_plan): RedirectResponse
    {
        if ($subscription_plan->restaurantSubscriptions()->exists()) {
            return redirect()
                ->route('admin.subscription-plans.index')
                ->with('error', __('This plan cannot be deleted because restaurants are linked to it.'));
        }

        $subscription_plan->delete();

        return redirect()
            ->route('admin.subscription-plans.index')
            ->with('status', __('Subscription plan deleted.'));
    }
}
