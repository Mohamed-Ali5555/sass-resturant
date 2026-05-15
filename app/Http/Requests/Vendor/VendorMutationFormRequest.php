<?php

namespace App\Http\Requests\Vendor;

abstract class VendorMutationFormRequest extends VendorFormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->vendorRestaurant()) ?? false;
    }
}
