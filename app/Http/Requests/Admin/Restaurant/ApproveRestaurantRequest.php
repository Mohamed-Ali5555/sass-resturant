<?php

namespace App\Http\Requests\Admin\Restaurant;

use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;

class ApproveRestaurantRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Restaurant $restaurant */
        $restaurant = $this->route('restaurant');

        return $this->user()->can('activate', $restaurant);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
