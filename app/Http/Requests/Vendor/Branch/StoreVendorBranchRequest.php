<?php

namespace App\Http\Requests\Vendor\Branch;

use App\Http\Requests\Vendor\VendorMutationFormRequest;
use Illuminate\Validation\Rule;

class StoreVendorBranchRequest extends VendorMutationFormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $restaurant = $this->vendorRestaurant();

        return [
            'name' => ['required', 'string', 'max:160'],
            'slug' => [
                'required',
                'string',
                'max:96',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('branches', 'slug')->where(fn ($q) => $q->where('restaurant_id', $restaurant->getKey())),
            ],
            'status' => ['required', 'string', 'in:active,inactive'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ];
    }
}
