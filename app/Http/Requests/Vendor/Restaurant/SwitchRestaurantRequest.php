<?php

namespace App\Http\Requests\Vendor\Restaurant;

use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;

class SwitchRestaurantRequest extends FormRequest
{
    public function authorize(): bool
    {
        $id = (int) $this->input('restaurant_id');
        $restaurant = Restaurant::query()->find($id);

        if (! $restaurant) {
            return false;
        }

        return $this->user()?->can('viewVendor', $restaurant) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
        ];
    }
}
