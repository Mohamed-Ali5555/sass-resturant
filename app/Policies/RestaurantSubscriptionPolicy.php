<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\RestaurantSubscription;
use App\Models\User;

class RestaurantSubscriptionPolicy
{
    public function update(User $user, RestaurantSubscription $restaurantSubscription): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }
}
