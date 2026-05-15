<?php

namespace App\Http\Requests\Admin\User;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRolesRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->route('user');

        return $this->user()->can('assignRoles', $user);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'role' => [
                'required',
                'string',
                Rule::in([RoleName::VendorOwner->value, RoleName::Customer->value]),
            ],
        ];
    }
}
