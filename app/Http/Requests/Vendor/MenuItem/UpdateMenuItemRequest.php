<?php

namespace App\Http\Requests\Vendor\MenuItem;

use App\Models\MenuItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var MenuItem $menuItem */
        $menuItem = $this->route('menuItem');

        return $this->user()?->can('update', $menuItem) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var MenuItem $menuItem */
        $menuItem = $this->route('menuItem');
        $restaurant = $menuItem->restaurant;

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
