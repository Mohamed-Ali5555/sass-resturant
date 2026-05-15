<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\MenuItem\PrintVendorMenuItemQrRequest;
use App\Http\Requests\Vendor\MenuItem\StoreMenuItemRequest;
use App\Http\Requests\Vendor\MenuItem\UpdateMenuItemRequest;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Services\ImageUploadService;
use App\Services\QrCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorMenuItemController extends Controller
{
    public function index(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $items = $restaurant->menuItems()->with('category')->orderBy('name')->paginate(30);

        return view('vendor.menu.items.index', compact('restaurant', 'items'));
    }

    public function create(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $categories = $restaurant->categories()->orderBy('sort_order')->get();

        return view('vendor.menu.items.create', compact('restaurant', 'categories'));
    }

    public function store(StoreMenuItemRequest $request, ImageUploadService $uploader): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $data = $request->validated();

        $imageValue = null;
        if ($request->hasFile('image_file')) {
            $imageValue = $uploader->store($request->file('image_file'), 'menu-items');
        } elseif (! empty($data['image_url'])) {
            $imageValue = $data['image_url'];
        }

        $restaurant->menuItems()->create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'image' => $imageValue,
            'track_inventory' => $request->boolean('track_inventory'),
            'stock_qty' => $data['stock_qty'] ?? null,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('vendor.menu.items.index')->with('status', 'Item created.');
    }

    public function edit(Request $request, MenuItem $menuItem): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $menuItem->restaurant_id === (int) $restaurant->getKey(), 404);
        $this->authorize('update', $menuItem);

        $categories = $restaurant->categories()->orderBy('sort_order')->get();

        return view('vendor.menu.items.edit', compact('restaurant', 'menuItem', 'categories'));
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem, ImageUploadService $uploader): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $menuItem->restaurant_id === (int) $restaurant->getKey(), 404);

        $data = $request->validated();

        $imageValue = $menuItem->image;
        if ($request->hasFile('image_file')) {
            $imageValue = $uploader->store($request->file('image_file'), 'menu-items', $menuItem->image);
        } elseif (isset($data['image_url']) && $data['image_url'] !== $menuItem->image) {
            $imageValue = $data['image_url'] ?: null;
        }

        $menuItem->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'image' => $imageValue,
            'track_inventory' => $request->boolean('track_inventory'),
            'stock_qty' => $data['stock_qty'] ?? null,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('vendor.menu.items.index')->with('status', 'Item updated.');
    }

    public function destroy(Request $request, MenuItem $menuItem): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $menuItem->restaurant_id === (int) $restaurant->getKey(), 404);
        $this->authorize('delete', $menuItem);

        $menuItem->delete();

        return redirect()->route('vendor.menu.items.index')->with('status', 'Item deleted.');
    }

    public function printQrCard(PrintVendorMenuItemQrRequest $request, MenuItem $menuItem, QrCodeService $qrCodes): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $menuItem->restaurant_id === (int) $restaurant->getKey(), 404);
        $this->authorize('update', $menuItem);

        $itemUrl = route('public.menu.item', [
            'restaurant' => $restaurant->slug,
            'item' => $menuItem->getKey(),
        ], true);
        $qrPngDataUri = $qrCodes->pngDataUri($itemUrl, 320, 6);

        return view('vendor.menu.items.qr-print-card', compact('restaurant', 'menuItem', 'itemUrl', 'qrPngDataUri'));
    }
}
