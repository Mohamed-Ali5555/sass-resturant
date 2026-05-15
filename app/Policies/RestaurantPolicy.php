<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\Restaurant;
use App\Models\User;

class RestaurantPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function view(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function activate(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function suspend(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function manageSubscription(User $user, Restaurant $restaurant): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function viewVendor(User $user, Restaurant $restaurant): bool
    {
        if ($user->hasRole(RoleName::SuperAdmin->value)) {
            return true;
        }

        return $this->vendorOwnsRestaurant($user, $restaurant);
    }

    public function update(User $user, Restaurant $restaurant): bool
    {
        if ($user->hasRole(RoleName::SuperAdmin->value)) {
            return true;
        }

        return $this->vendorOwnsRestaurant($user, $restaurant);
    }

    private function vendorOwnsRestaurant(User $user, Restaurant $restaurant): bool
    {
        if ($user->hasRole(RoleName::VendorOwner->value)
            && (int) $restaurant->vendor_owner_id === (int) $user->getKey()) {
            return true;
        }

        return $user->activeRestaurantsAsStaff()
            ->whereKey($restaurant->getKey())
            ->exists();
    }
}
