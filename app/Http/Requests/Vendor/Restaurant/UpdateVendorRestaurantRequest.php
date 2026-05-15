<?php

namespace App\Http\Requests\Vendor\Restaurant;

use App\Http\Requests\Vendor\VendorMutationFormRequest;

class UpdateVendorRestaurantRequest extends VendorMutationFormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'timezone' => ['nullable', 'string', 'max:64'],
            'currency' => ['required', 'string', 'size:3'],
            'tax_rate_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'delivery_fee' => ['required', 'numeric', 'min:0'],
            'enable_dine_in' => ['sometimes', 'boolean'],
            'enable_takeaway' => ['sometimes', 'boolean'],
            'enable_delivery' => ['sometimes', 'boolean'],
            'profile.address_line' => ['nullable', 'string', 'max:255'],
            'profile.city' => ['nullable', 'string', 'max:120'],
            'profile.country' => ['nullable', 'string', 'size:2'],
            'profile.phone' => ['nullable', 'string', 'max:64'],
            'logo' => ['nullable', 'file', 'image', 'max:2048'],
            'gallery' => ['nullable', 'array', 'max:8'],
            'gallery.*' => ['file', 'image', 'max:2048'],
            'remove_gallery_indices' => ['nullable', 'array'],
            'remove_gallery_indices.*' => ['integer', 'min:0'],
        ];
    }
}
