<?php

namespace App\Http\Requests\Public\Cart;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $this->route('restaurant');

        return [
            'menu_item_id' => [
                'required',
                'integer',
                Rule::exists('menu_items', 'id')
                    ->where(fn ($q) => $q->where('restaurant_id', $restaurant->getKey())),
            ],
            'qty' => ['required', 'integer', 'min:0', 'max:99'],
        ];
    }
}
