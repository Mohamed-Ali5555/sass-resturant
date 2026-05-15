<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\PlatformCommission;
use App\Models\User;

class PlatformCommissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function update(User $user, PlatformCommission $platformCommission): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function delete(User $user, PlatformCommission $platformCommission): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }
}
