<?php

namespace App\Http\Requests\Vendor\Delivery;

use App\Http\Requests\Vendor\VendorMutationFormRequest;

class StoreVendorDeliveryZoneRequest extends VendorMutationFormRequest
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
}
