<?php

namespace App\Http\Requests\Vendor\Table;

use App\Http\Requests\Vendor\VendorMutationFormRequest;
use Illuminate\Validation\Rule;

class StoreVendorRestaurantTableRequest extends VendorMutationFormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $restaurant = $this->vendorRestaurant();

        return [
            'label' => ['required', 'string', 'max:120'],
            'table_code' => [
                'nullable',
                'string',
                'max:64',
                Rule::unique('restaurant_tables', 'table_code')->where(fn ($q) => $q->where('restaurant_id', $restaurant->getKey())),
            ],
            'branch_id' => [
                'nullable',
                'integer',
                Rule::exists('branches', 'id')->where(fn ($q) => $q->where('restaurant_id', $restaurant->getKey())),
            ],
        ];
    }
}
