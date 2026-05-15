<?php

namespace App\Http\Requests\Vendor\MenuItem;

use App\Http\Requests\Vendor\VendorFormRequest;

class PrintVendorMenuItemQrRequest extends VendorFormRequest
{
    public function authorize(): bool
    {
        if (! parent::authorize()) {
            return false;
        }

        /** @var \App\Models\MenuItem $menuItem */
        $menuItem = $this->route('menuItem');

        if ((int) $menuItem->restaurant_id !== (int) $this->vendorRestaurant()->getKey()) {
            return false;
        }

        return $this->user()?->can('update', $menuItem) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
