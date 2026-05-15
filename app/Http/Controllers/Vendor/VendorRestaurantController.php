<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Restaurant\PrintVendorRestaurantMenuQrRequest;
use App\Http\Requests\Vendor\Restaurant\UpdateVendorRestaurantRequest;
use App\Models\Restaurant;
use App\Services\QrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VendorRestaurantController extends Controller
{
    public function edit(Request $request, Restaurant $restaurant): View
    {
        $this->assertSessionRestaurant($request, $restaurant);
        $this->authorize('update', $restaurant);

        $restaurant->load(['profile', 'locations']);

        return view('vendor.restaurants.edit', compact('restaurant'));
    }

    public function printMenuQr(PrintVendorRestaurantMenuQrRequest $request, Restaurant $restaurant, QrCodeService $qrCodes): View
    {
        $this->assertSessionRestaurant($request, $restaurant);
        $this->authorize('update', $restaurant);

        $menuUrl = route('public.restaurant.show', ['restaurant' => $restaurant->slug], true);
        $qrPngDataUri = $qrCodes->pngDataUri($menuUrl, 520, 8);

        return view('vendor.restaurants.qr-print-menu', compact('restaurant', 'menuUrl', 'qrPngDataUri'));
    }

    public function update(UpdateVendorRestaurantRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $this->assertSessionRestaurant($request, $restaurant);
        $this->authorize('update', $restaurant);

        $data = $request->validated();
        $profileInput = $data['profile'] ?? [];
        unset($data['profile'], $data['logo'], $data['gallery'], $data['remove_gallery_indices']);

        $restaurant->update([
            'name' => $data['name'],
            'timezone' => $data['timezone'] ?? null,
            'currency' => $data['currency'],
            'tax_rate_percent' => $data['tax_rate_percent'],
            'delivery_fee' => $data['delivery_fee'],
            'enable_dine_in' => $request->boolean('enable_dine_in'),
            'enable_takeaway' => $request->boolean('enable_takeaway'),
            'enable_delivery' => $request->boolean('enable_delivery'),
        ]);

        $profile = $restaurant->profile()->firstOrCreate(
            ['restaurant_id' => $restaurant->getKey()],
            [
                'address_line' => null,
                'city' => null,
                'country' => null,
                'phone' => null,
            ],
        );

        $profile->fill([
            'address_line' => $profileInput['address_line'] ?? null,
            'city' => $profileInput['city'] ?? null,
            'country' => $profileInput['country'] ?? null,
            'phone' => $profileInput['phone'] ?? null,
        ]);

        if ($request->hasFile('logo')) {
            if ($profile->logo_path) {
                Storage::disk('public')->delete($profile->logo_path);
            }
            $profile->logo_path = $request->file('logo')->store('restaurants/'.$restaurant->getKey().'/logo', 'public');
        }

        $gallery = $profile->gallery_paths ?? [];
        $remove = collect($request->input('remove_gallery_indices', []))
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->map(fn ($v) => (int) $v)
            ->unique()
            ->sort()
            ->values();

        foreach ($remove->reverse() as $idx) {
            if (isset($gallery[$idx])) {
                Storage::disk('public')->delete($gallery[$idx]);
                unset($gallery[$idx]);
            }
        }
        $gallery = array_values($gallery);

        foreach ($request->file('gallery', []) as $file) {
            $gallery[] = $file->store('restaurants/'.$restaurant->getKey().'/gallery', 'public');
        }

        $profile->gallery_paths = $gallery;
        $profile->save();

        return redirect()
            ->route('vendor.restaurants.edit', $restaurant)
            ->with('status', __('Restaurant settings saved.'));
    }

    private function assertSessionRestaurant(Request $request, Restaurant $restaurant): void
    {
        /** @var Restaurant|null $sessionRestaurant */
        $sessionRestaurant = $request->attributes->get('vendorRestaurant');
        abort_unless($sessionRestaurant && $restaurant->is($sessionRestaurant), 403);
    }
}
