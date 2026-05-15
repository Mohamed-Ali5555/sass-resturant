<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Table\DestroyVendorRestaurantTableRequest;
use App\Http\Requests\Vendor\Table\PrintVendorTableQrRequest;
use App\Http\Requests\Vendor\Table\RegenerateVendorTableQrRequest;
use App\Http\Requests\Vendor\Table\StoreVendorRestaurantTableRequest;
use App\Http\Requests\Vendor\Table\UpdateVendorRestaurantTableRequest;
use App\Models\RestaurantTable;
use App\Services\QrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorRestaurantTableController extends Controller
{
    public function index(Request $request): View
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);

        $tables = $restaurant->restaurantTables()->with('branch')->orderBy('label')->paginate(40);
        $branches = $restaurant->locations()->orderBy('name')->get();

        return view('vendor.tables.index', compact('restaurant', 'tables', 'branches'));
    }

    public function create(Request $request): View
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        $branches = $restaurant->locations()->orderBy('name')->get();

        return view('vendor.tables.create', compact('restaurant', 'branches'));
    }

    public function store(StoreVendorRestaurantTableRequest $request): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $data = $request->validated();
        $data['restaurant_id'] = $restaurant->getKey();
        $data['qr_token'] = RestaurantTable::generateUniqueQrToken();

        RestaurantTable::query()->create($data);

        return redirect()
            ->route('vendor.tables.index')
            ->with('status', __('Table created.'));
    }

    public function edit(Request $request, RestaurantTable $restaurant_table): View
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($restaurant_table->restaurant_id === $restaurant->getKey(), 403);
        $branches = $restaurant->locations()->orderBy('name')->get();

        return view('vendor.tables.edit', [
            'restaurant' => $restaurant,
            'table' => $restaurant_table,
            'branches' => $branches,
        ]);
    }

    public function update(UpdateVendorRestaurantTableRequest $request, RestaurantTable $restaurant_table): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($restaurant_table->restaurant_id === $restaurant->getKey(), 403);

        $restaurant_table->update($request->validated());

        return redirect()
            ->route('vendor.tables.index')
            ->with('status', __('Table updated.'));
    }

    public function destroy(DestroyVendorRestaurantTableRequest $request, RestaurantTable $restaurant_table): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($restaurant_table->restaurant_id === $restaurant->getKey(), 403);

        if ($restaurant_table->orders()->exists()) {
            return redirect()
                ->route('vendor.tables.index')
                ->with('error', __('This table cannot be deleted because it has orders.'));
        }

        $restaurant_table->delete();

        return redirect()
            ->route('vendor.tables.index')
            ->with('status', __('Table deleted.'));
    }

    public function regenerateQr(RegenerateVendorTableQrRequest $request, RestaurantTable $restaurant_table): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($restaurant_table->restaurant_id === $restaurant->getKey(), 403);

        $restaurant_table->update(['qr_token' => RestaurantTable::generateUniqueQrToken()]);

        return redirect()
            ->back()
            ->with('status', __('QR token regenerated.'));
    }

    public function printQr(PrintVendorTableQrRequest $request, RestaurantTable $restaurant_table, QrCodeService $qrCodes): View
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($restaurant_table->restaurant_id === $restaurant->getKey(), 403);

        $tableEntryUrl = route('public.restaurant.table', [
            'restaurant' => $restaurant->slug,
            'qr_token' => $restaurant_table->qr_token,
        ], true);

        $menuUrl = route('public.restaurant.show', ['restaurant' => $restaurant->slug], true);
        $qrPngDataUri = $qrCodes->pngDataUri($tableEntryUrl, 480, 10);

        return view('vendor.tables.qr-print', compact('restaurant', 'restaurant_table', 'menuUrl', 'tableEntryUrl', 'qrPngDataUri'));
    }
}
