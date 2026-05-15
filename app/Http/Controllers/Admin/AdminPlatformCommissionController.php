<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Commission\DestroyPlatformCommissionRequest;
use App\Http\Requests\Admin\Commission\StorePlatformCommissionRequest;
use App\Http\Requests\Admin\Commission\UpdatePlatformCommissionRequest;
use App\Models\PlatformCommission;
use App\Models\Restaurant;
use App\Models\SubscriptionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminPlatformCommissionController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', PlatformCommission::class);

        $commissions = PlatformCommission::query()->orderBy('scope_type')->orderBy('scope_id')->paginate(30);

        return view('admin.commissions.index', compact('commissions'));
    }

    public function create(): View
    {
        $this->authorize('create', PlatformCommission::class);

        return view('admin.commissions.create', [
            'plans' => SubscriptionPlan::query()->orderBy('name')->get(),
            'restaurants' => Restaurant::query()->orderBy('name')->limit(500)->get(),
        ]);
    }

    public function store(StorePlatformCommissionRequest $request): RedirectResponse
    {
        PlatformCommission::query()->create($request->validated());

        return redirect()
            ->route('admin.platform-commissions.index')
            ->with('status', __('Commission rule created.'));
    }

    public function edit(PlatformCommission $platform_commission): View
    {
        $this->authorize('update', $platform_commission);

        return view('admin.commissions.edit', [
            'commission' => $platform_commission,
            'plans' => SubscriptionPlan::query()->orderBy('name')->get(),
            'restaurants' => Restaurant::query()->orderBy('name')->limit(500)->get(),
        ]);
    }

    public function update(UpdatePlatformCommissionRequest $request, PlatformCommission $platform_commission): RedirectResponse
    {
        $platform_commission->update($request->validated());

        return redirect()
            ->route('admin.platform-commissions.index')
            ->with('status', __('Commission rule updated.'));
    }

    public function destroy(DestroyPlatformCommissionRequest $request, PlatformCommission $platform_commission): RedirectResponse
    {
        if (
            $platform_commission->scope_type === PlatformCommission::SCOPE_PLATFORM
            && (int) $platform_commission->scope_id === 0
        ) {
            return redirect()
                ->route('admin.platform-commissions.index')
                ->with('error', __('The default platform commission row cannot be deleted.'));
        }

        $platform_commission->delete();

        return redirect()
            ->route('admin.platform-commissions.index')
            ->with('status', __('Commission rule deleted.'));
    }
}
