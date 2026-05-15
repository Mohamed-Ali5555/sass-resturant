<?php

namespace App\Http\Requests\Vendor\Delivery;

use App\Http\Requests\Vendor\VendorMutationFormRequest;

class StoreVendorDeliveryFeeRuleRequest extends VendorMutationFormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'min_subtotal' => ['required', 'numeric', 'min:0'],
            'fee_amount' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ];
    }
}
