<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\SubscriptionPlan;
use App\Models\User;

class SubscriptionPlanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function view(User $user, SubscriptionPlan $subscriptionPlan): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function update(User $user, SubscriptionPlan $subscriptionPlan): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function delete(User $user, SubscriptionPlan $subscriptionPlan): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }
}
