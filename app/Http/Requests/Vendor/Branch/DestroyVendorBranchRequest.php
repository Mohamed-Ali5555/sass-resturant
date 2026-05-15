<?php

namespace App\Http\Requests\Vendor\Branch;

use App\Http\Requests\Vendor\VendorMutationFormRequest;

class DestroyVendorBranchRequest extends VendorMutationFormRequest
{
    public function authorize(): bool
    {
        if (! parent::authorize()) {
            return false;
        }

        /** @var \App\Models\Branch $branch */
        $branch = $this->route('branch');

        return $branch->restaurant_id === $this->vendorRestaurant()->getKey();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
