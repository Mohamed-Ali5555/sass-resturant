<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\OpeningHour\SyncVendorOpeningHoursRequest;
use App\Models\OpeningHour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorOpeningHoursController extends Controller
{
    public function edit(Request $request): View
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);

        $branchId = $request->query('branch_id');
        $branchId = $branchId !== null && $branchId !== '' ? (int) $branchId : null;
        if ($branchId) {
            abort_unless($restaurant->locations()->whereKey($branchId)->exists(), 403);
        }

        $hours = OpeningHour::query()
            ->where('restaurant_id', $restaurant->getKey())
            ->where('branch_id', $branchId)
            ->orderBy('day_of_week')
            ->get()
            ->keyBy('day_of_week');

        $rows = [];
        for ($d = 0; $d <= 6; $d++) {
            $existing = $hours->get($d);
            $rows[] = [
                'day_of_week' => $d,
                'is_closed' => $existing ? (bool) $existing->is_closed : ($d === 0),
                'open_time' => $existing && $existing->open_time ? substr((string) $existing->open_time, 0, 5) : '10:00',
                'close_time' => $existing && $existing->close_time ? substr((string) $existing->close_time, 0, 5) : '22:00',
            ];
        }

        $branches = $restaurant->locations()->orderBy('name')->get();

        return view('vendor.opening-hours.edit', compact('restaurant', 'rows', 'branchId', 'branches'));
    }

    public function update(SyncVendorOpeningHoursRequest $request): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);

        $validated = $request->validated();
        $branchId = $validated['branch_id'] ?? null;
        if ($branchId) {
            abort_unless($restaurant->locations()->whereKey($branchId)->exists(), 403);
        }

        OpeningHour::query()
            ->where('restaurant_id', $restaurant->getKey())
            ->where('branch_id', $branchId)
            ->delete();

        foreach ($validated['hours'] as $row) {
            $closed = ! empty($row['is_closed']);
            OpeningHour::query()->create([
                'restaurant_id' => $restaurant->getKey(),
                'branch_id' => $branchId,
                'day_of_week' => (int) $row['day_of_week'],
                'open_time' => $closed ? null : ($row['open_time'].':00'),
                'close_time' => $closed ? null : ($row['close_time'].':00'),
                'is_closed' => $closed,
            ]);
        }

        return redirect()
            ->route('vendor.opening-hours.edit', $branchId ? ['branch_id' => $branchId] : [])
            ->with('status', __('Opening hours saved.'));
    }
}
