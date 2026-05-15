<?php

namespace App\Http\Requests\Vendor\Category;

use App\Http\Requests\Vendor\VendorFormRequest;

class StoreCategoryRequest extends VendorFormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65000'],
        ];
    }
}
