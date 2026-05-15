<?php

namespace App\Http\Requests\Admin;

use App\Enums\RoleName;
use Illuminate\Foundation\Http\FormRequest;

abstract class AdminFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->hasRole(RoleName::SuperAdmin->value);
    }
}
