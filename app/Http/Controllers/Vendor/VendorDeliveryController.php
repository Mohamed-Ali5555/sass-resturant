<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Delivery\DestroyVendorDeliveryFeeRuleRequest;
use App\Http\Requests\Vendor\Delivery\DestroyVendorDeliveryZoneRequest;
use App\Http\Requests\Vendor\Delivery\StoreVendorDeliveryFeeRuleRequest;
use App\Http\Requests\Vendor\Delivery\StoreVendorDeliveryZoneRequest;
use App\Http\Requests\Vendor\Delivery\UpdateVendorDeliveryFeeRuleRequest;
use App\Http\Requests\Vendor\Delivery\UpdateVendorDeliveryZoneRequest;
use App\Models\DeliveryFeeRule;
use App\Models\DeliveryZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorDeliveryController extends Controller
{
    public function index(Request $request): View
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);

        $zones = $restaurant->deliveryZones()->orderBy('sort_order')->get();
        $rules = $restaurant->deliveryFeeRules()->orderBy('sort_order')->get();

        return view('vendor.delivery.index', compact('restaurant', 'zones', 'rules'));
    }

    public function storeZone(StoreVendorDeliveryZoneRequest $request): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $data = $request->validated();
        $data['restaurant_id'] = $restaurant->getKey();
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        DeliveryZone::query()->create($data);

        return redirect()->route('vendor.delivery.index')->with('status', __('Delivery zone added.'));
    }

    public function updateZone(UpdateVendorDeliveryZoneRequest $request, DeliveryZone $delivery_zone): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($delivery_zone->restaurant_id === $restaurant->getKey(), 403);

        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', $delivery_zone->is_active);
        $data['sort_order'] = $data['sort_order'] ?? $delivery_zone->sort_order;
        $delivery_zone->update($data);

        return redirect()->route('vendor.delivery.index')->with('status', __('Zone updated.'));
    }

    public function destroyZone(DestroyVendorDeliveryZoneRequest $request, DeliveryZone $delivery_zone): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($delivery_zone->restaurant_id === $restaurant->getKey(), 403);

        $delivery_zone->delete();

        return redirect()->route('vendor.delivery.index')->with('status', __('Zone removed.'));
    }

    public function storeRule(StoreVendorDeliveryFeeRuleRequest $request): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $data = $request->validated();
        $data['restaurant_id'] = $restaurant->getKey();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        DeliveryFeeRule::query()->create($data);

        return redirect()->route('vendor.delivery.index')->with('status', __('Fee rule added.'));
    }

    public function updateRule(UpdateVendorDeliveryFeeRuleRequest $request, DeliveryFeeRule $delivery_fee_rule): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($delivery_fee_rule->restaurant_id === $restaurant->getKey(), 403);

        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $delivery_fee_rule->sort_order;
        $delivery_fee_rule->update($data);

        return redirect()->route('vendor.delivery.index')->with('status', __('Fee rule updated.'));
    }

    public function destroyRule(DestroyVendorDeliveryFeeRuleRequest $request, DeliveryFeeRule $delivery_fee_rule): RedirectResponse
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $this->authorize('update', $restaurant);
        abort_unless($delivery_fee_rule->restaurant_id === $restaurant->getKey(), 403);

        $delivery_fee_rule->delete();

        return redirect()->route('vendor.delivery.index')->with('status', __('Fee rule removed.'));
    }
}
