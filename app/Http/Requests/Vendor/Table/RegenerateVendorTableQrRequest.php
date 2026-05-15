<?php

namespace App\Http\Requests\Vendor\Table;

use App\Http\Requests\Vendor\VendorMutationFormRequest;

class RegenerateVendorTableQrRequest extends VendorMutationFormRequest
{
    public function authorize(): bool
    {
        if (! parent::authorize()) {
            return false;
        }

        /** @var \App\Models\RestaurantTable $table */
        $table = $this->route('restaurant_table');

        return $table->restaurant_id === $this->vendorRestaurant()->getKey();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
