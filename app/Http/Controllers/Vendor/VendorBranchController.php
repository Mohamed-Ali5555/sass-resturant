<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Branch\DestroyVendorBranchRequest;
use App\Http\Requests\Vendor\Branch\StoreVendorBranchRequest;
use App\Http\Requests\Vendor\Branch\UpdateVendorBranchRequest;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorBranchController extends Controller
{
    public function index(Request $request): View
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);

        $branches = $restaurant->locations()->orderBy('sort_order')->orderBy('name')->paginate(30);

        return view('vendor.branches.index', compact('restaurant', 'branches'));
    }

    public function create(Request $request): View
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);

        return view('vendor.branches.create', compact('restaurant'));
    }

    public function store(StoreVendorBranchRequest $request): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $restaurant->locations()->create($data);

        return redirect()
            ->route('vendor.branches.index')
            ->with('status', __('Branch created.'));
    }

    public function edit(Request $request, Branch $branch): View
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($branch->restaurant_id === $restaurant->getKey(), 403);

        return view('vendor.branches.edit', compact('restaurant', 'branch'));
    }

    public function update(UpdateVendorBranchRequest $request, Branch $branch): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($branch->restaurant_id === $restaurant->getKey(), 403);

        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $branch->sort_order;
        $branch->update($data);

        return redirect()
            ->route('vendor.branches.index')
            ->with('status', __('Branch updated.'));
    }

    public function destroy(DestroyVendorBranchRequest $request, Branch $branch): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($branch->restaurant_id === $restaurant->getKey(), 403);

        $branch->delete();

        return redirect()
            ->route('vendor.branches.index')
            ->with('status', __('Branch deleted.'));
    }
}
