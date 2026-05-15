<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\User;

class MenuPolicy
{
    public function update(User $user, Category|MenuItem $subject): bool
    {
        return $this->vendorOwnsSubjectRestaurant($user, $subject);
    }

    public function delete(User $user, Category|MenuItem $subject): bool
    {
        return $this->vendorOwnsSubjectRestaurant($user, $subject);
    }

    private function vendorOwnsSubjectRestaurant(User $user, Category|MenuItem $subject): bool
    {
        if (! $user->hasRole(RoleName::VendorOwner->value)) {
            return false;
        }

        $restaurant = $subject->restaurant;

        return (int) $restaurant->vendor_owner_id === (int) $user->getKey();
    }
}
