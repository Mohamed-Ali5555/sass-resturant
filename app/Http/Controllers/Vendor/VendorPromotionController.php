<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Promotion\StoreCouponRequest;
use App\Http\Requests\Vendor\Promotion\UpdateCouponRequest;
use App\Models\Coupon;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorPromotionController extends Controller
{
    public function index(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        $coupons = $restaurant->coupons()->orderByDesc('id')->paginate(20);

        return view('vendor.promotions.index', compact('restaurant', 'coupons'));
    }

    public function create(Request $request): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');

        return view('vendor.promotions.create', compact('restaurant'));
    }

    public function store(StoreCouponRequest $request): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        $data = $request->validated();

        $restaurant->coupons()->create($data);

        return redirect()->route('vendor.promotions.index')->with('status', __('Coupon created.'));
    }

    public function edit(Request $request, Coupon $coupon): View
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $coupon->restaurant_id === (int) $restaurant->getKey(), 404);

        return view('vendor.promotions.edit', compact('restaurant', 'coupon'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $coupon->restaurant_id === (int) $restaurant->getKey(), 404);

        $coupon->update($request->validated());

        return redirect()->route('vendor.promotions.index')->with('status', __('Coupon updated.'));
    }

    public function destroy(Request $request, Coupon $coupon): RedirectResponse
    {
        /** @var Restaurant $restaurant */
        $restaurant = $request->attributes->get('vendorRestaurant');
        abort_unless((int) $coupon->restaurant_id === (int) $restaurant->getKey(), 404);

        $coupon->delete();

        return redirect()->route('vendor.promotions.index')->with('status', __('Coupon deleted.'));
    }
}
