<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Staff\StoreStaffRequest;
use App\Http\Requests\Vendor\Staff\UpdateStaffRequest;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorStaffController extends Controller
{
    public function index(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $staff = $restaurant->staffUsers()
            ->with('branches')
            ->orderBy('name')
            ->get()
            ->map(function (User $u) use ($restaurant) {
                $pivot = $u->getRelation('pivot') ?? $u->restaurantsAsStaff
                    ->where('id', $restaurant->id)->first()?->pivot;
                $u->setAttribute('_pivot', $pivot);
                return $u;
            });

        // Re-fetch properly with pivot
        $staff = $restaurant->staffUsers()->withPivot(['branch_id', 'staff_role', 'is_active'])->orderBy('name')->get();
        $branches = $restaurant->locations()->orderBy('name')->get();

        return view('vendor.staff.index', compact('restaurant', 'staff', 'branches'));
    }

    public function create(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $branches = $restaurant->locations()->orderBy('name')->get();
        $staffRoles = RoleName::staffRoles();

        return view('vendor.staff.create', compact('restaurant', 'branches', 'staffRoles'));
    }

    public function store(StoreStaffRequest $request): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $data = $request->validated();

        $user = User::query()->where('email', $data['email'])->first();

        if (! $user) {
            return back()->withErrors(['email' => __('No account found with this email.')]);
        }

        if ($restaurant->staffUsers()->whereKey($user->getKey())->exists()) {
            return back()->withErrors(['email' => __('This user is already on your staff.')]);
        }

        $restaurant->staffUsers()->attach($user->getKey(), [
            'branch_id' => $data['branch_id'] ?? null,
            'staff_role' => $data['staff_role'] ?? null,
            'is_active' => true,
        ]);

        if (! empty($data['staff_role'])) {
            $user->syncRoles(array_unique(array_merge($user->getRoleNames()->all(), [$data['staff_role']])));
        }

        return redirect()->route('vendor.staff.index')->with('status', __('Staff member added.'));
    }

    public function edit(Request $request, User $staff): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        abort_unless($restaurant->staffUsers()->whereKey($staff->getKey())->exists(), 404);

        $pivot = $restaurant->staffUsers()
            ->withPivot(['branch_id', 'staff_role', 'is_active'])
            ->whereKey($staff->getKey())
            ->first()
            ?->pivot;

        $branches = $restaurant->locations()->orderBy('name')->get();
        $staffRoles = RoleName::staffRoles();

        return view('vendor.staff.edit', compact('restaurant', 'staff', 'pivot', 'branches', 'staffRoles'));
    }

    public function update(UpdateStaffRequest $request, User $staff): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        abort_unless($restaurant->staffUsers()->whereKey($staff->getKey())->exists(), 404);

        $data = $request->validated();

        $restaurant->staffUsers()->updateExistingPivot($staff->getKey(), [
            'branch_id' => $data['branch_id'] ?? null,
            'staff_role' => $data['staff_role'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('vendor.staff.index')->with('status', __('Staff member updated.'));
    }

    public function destroy(Request $request, User $staff): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        abort_unless($restaurant->staffUsers()->whereKey($staff->getKey())->exists(), 404);

        $restaurant->staffUsers()->detach($staff->getKey());

        return redirect()->route('vendor.staff.index')->with('status', __('Staff member removed.'));
    }
}
