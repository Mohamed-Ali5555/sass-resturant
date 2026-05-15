<?php

namespace App\Http\Requests\Vendor\Table;

use App\Http\Requests\Vendor\VendorMutationFormRequest;
use App\Models\RestaurantTable;
use Illuminate\Validation\Rule;

class UpdateVendorRestaurantTableRequest extends VendorMutationFormRequest
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
        $restaurant = $this->vendorRestaurant();
        /** @var RestaurantTable $restaurant_table */
        $table = $this->route('restaurant_table');

        return [
            'label' => ['required', 'string', 'max:120'],
            'table_code' => [
                'nullable',
                'string',
                'max:64',
                Rule::unique('restaurant_tables', 'table_code')
                    ->where(fn ($q) => $q->where('restaurant_id', $restaurant->getKey()))
                    ->ignore($table->getKey()),
            ],
            'branch_id' => [
                'nullable',
                'integer',
                Rule::exists('branches', 'id')->where(fn ($q) => $q->where('restaurant_id', $restaurant->getKey())),
            ],
        ];
    }
}
