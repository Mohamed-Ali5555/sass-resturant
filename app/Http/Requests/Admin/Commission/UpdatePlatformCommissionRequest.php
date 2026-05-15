<?php

namespace App\Http\Requests\Admin\Commission;

use App\Models\PlatformCommission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlatformCommissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var PlatformCommission $platform_commission */
        $commission = $this->route('platform_commission');

        return $this->user()->can('update', $commission);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var PlatformCommission $commission */
        $commission = $this->route('platform_commission');

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
                Rule::unique('platform_commissions', 'scope_id')
                    ->where(fn ($q) => $q->where('scope_type', $this->input('scope_type')))
                    ->ignore($commission->getKey()),
            ],
            'commission_percent' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
