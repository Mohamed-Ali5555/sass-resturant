<?php

namespace App\Http\Requests\Vendor\Delivery;

use App\Http\Requests\Vendor\VendorMutationFormRequest;
use App\Models\DeliveryFeeRule;

class UpdateVendorDeliveryFeeRuleRequest extends VendorMutationFormRequest
{
    public function authorize(): bool
    {
        if (! parent::authorize()) {
            return false;
        }

        /** @var DeliveryFeeRule|null $rule */
        $rule = $this->route('delivery_fee_rule');

        return $rule && $rule->restaurant_id === $this->vendorRestaurant()->getKey();
    }

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
