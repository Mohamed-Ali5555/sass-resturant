<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function assignRoles(User $user, User $model): bool
    {
        if (! $user->hasRole(RoleName::SuperAdmin->value)) {
            return false;
        }

        if ($model->hasRole(RoleName::SuperAdmin->value)) {
            return false;
        }

        return true;
    }

    public function toggleDisabled(User $user, User $model): bool
    {
        if (! $user->hasRole(RoleName::SuperAdmin->value)) {
            return false;
        }

        if ($user->is($model)) {
            return false;
        }

        if ($model->hasRole(RoleName::SuperAdmin->value)) {
            return false;
        }

        return true;
    }
}
