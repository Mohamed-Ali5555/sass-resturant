<?php

namespace App\Http\Requests\Vendor\Promotion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:50', 'regex:/^\S+$/'],
            'discount_type' => ['required', Rule::in(['percent', 'fixed'])],
            'percent_off' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'amount_off' => ['nullable', 'numeric', 'min:0'],
            'max_redemptions' => ['nullable', 'integer', 'min:1'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['boolean'],
        ];
    }
}
