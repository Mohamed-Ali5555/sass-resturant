<?php

namespace App\Http\Requests\Vendor\Delivery;

use App\Http\Requests\Vendor\VendorMutationFormRequest;

class DestroyVendorDeliveryZoneRequest extends VendorMutationFormRequest
{
    public function authorize(): bool
    {
        if (! parent::authorize()) {
            return false;
        }

        $zone = $this->route('delivery_zone');

        return $zone && $zone->restaurant_id === $this->vendorRestaurant()->getKey();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
