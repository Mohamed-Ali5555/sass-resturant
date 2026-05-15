<?php

namespace App\Http\Requests\Vendor\Staff;

use App\Enums\RoleName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'staff_role' => ['nullable', Rule::in(array_column(RoleName::staffRoles(), 'value'))],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
        ];
    }
}
