<?php

namespace App\Http\Requests\Vendor\Branch;

use App\Http\Requests\Vendor\VendorMutationFormRequest;
use App\Models\Branch;
use Illuminate\Validation\Rule;

class UpdateVendorBranchRequest extends VendorMutationFormRequest
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
        $restaurant = $this->vendorRestaurant();
        /** @var Branch $branch */
        $branch = $this->route('branch');

        return [
            'name' => ['required', 'string', 'max:160'],
            'slug' => [
                'required',
                'string',
                'max:96',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('branches', 'slug')
                    ->where(fn ($q) => $q->where('restaurant_id', $restaurant->getKey()))
                    ->ignore($branch->getKey()),
            ],
            'status' => ['required', 'string', 'in:active,inactive'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ];
    }
}
