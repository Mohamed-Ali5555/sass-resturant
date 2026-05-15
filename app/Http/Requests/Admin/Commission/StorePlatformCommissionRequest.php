<?php

namespace App\Http\Requests\Admin\Commission;

use App\Models\PlatformCommission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlatformCommissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', PlatformCommission::class);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'scope_type' => ['required', 'string', Rule::in([
                PlatformCommission::SCOPE_PLATFORM,
                PlatformCommission::SCOPE_PLAN,
                PlatformCommission::SCOPE_RESTAURANT,
            ])],
            'scope_id' => [
                'required',
                'integer',
                'min:0',
                Rule::unique('platform_commissions', 'scope_id')->where(
                    fn ($q) => $q->where('scope_type', $this->input('scope_type'))
                ),
            ],
            'commission_percent' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
