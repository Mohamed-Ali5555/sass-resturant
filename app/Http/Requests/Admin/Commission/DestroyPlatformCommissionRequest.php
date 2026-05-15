<?php

namespace App\Http\Requests\Admin\Commission;

use App\Models\PlatformCommission;
use Illuminate\Foundation\Http\FormRequest;

class DestroyPlatformCommissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var PlatformCommission $platform_commission */
        $commission = $this->route('platform_commission');

        return $this->user()->can('delete', $commission);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
