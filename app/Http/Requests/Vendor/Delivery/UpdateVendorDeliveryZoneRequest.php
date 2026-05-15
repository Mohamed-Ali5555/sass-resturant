<?php

namespace App\Http\Requests\Vendor\Delivery;

use App\Http\Requests\Vendor\VendorMutationFormRequest;
use App\Models\DeliveryZone;

class UpdateVendorDeliveryZoneRequest extends VendorMutationFormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'fee_amount' => ['required', 'numeric', 'min:0'],
            'minimum_order_amount' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        if (! parent::authorize()) {
            return false;
        }

        /** @var DeliveryZone|null $zone */
        $zone = $this->route('delivery_zone');

        return $zone && $zone->restaurant_id === $this->vendorRestaurant()->getKey();
    }
}
