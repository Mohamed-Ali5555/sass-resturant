<?php

namespace App\Http\Requests\Vendor\MenuItem;

use App\Http\Requests\Vendor\VendorFormRequest;
use Illuminate\Validation\Rule;

class StoreMenuItemRequest extends VendorFormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $restaurant = $this->vendorRestaurant();

        return [
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where(fn ($q) => $q->where('restaurant_id', $restaurant->getKey())),
            ],
            'name' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable'],
            'image_file' => ['nullable', 'image', 'max:4096'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'track_inventory' => ['sometimes', 'boolean'],
            'stock_qty' => ['nullable', 'integer', 'min:0'],
            'is_available' => ['sometimes', 'boolean'],
        ];
    }
}
