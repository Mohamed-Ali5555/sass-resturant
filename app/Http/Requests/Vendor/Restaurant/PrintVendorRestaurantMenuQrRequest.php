<?php

namespace App\Http\Requests\Vendor\Restaurant;

use App\Http\Requests\Vendor\VendorFormRequest;

class PrintVendorRestaurantMenuQrRequest extends VendorFormRequest
{
    public function authorize(): bool
    {
        if (! parent::authorize()) {
            return false;
        }

        if (! ($this->user()?->can('update', $this->vendorRestaurant()) ?? false)) {
            return false;
        }

        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $this->route('restaurant');

        return (int) $restaurant->getKey() === (int) $this->vendorRestaurant()->getKey();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
