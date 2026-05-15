<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        if ($user->hasRole(RoleName::SuperAdmin->value)) {
            return true;
        }

        if ($user->hasRole(RoleName::VendorOwner->value)) {
            return (int) $order->restaurant->vendor_owner_id === (int) $user->getKey();
        }

        if ($user->hasRole(RoleName::Customer->value)) {
            return $order->user_id !== null && (int) $order->user_id === (int) $user->getKey();
        }

        return false;
    }

    public function updateStatus(User $user, Order $order): bool
    {
        if ($user->hasRole(RoleName::SuperAdmin->value)) {
            return true;
        }

        if ($user->hasRole(RoleName::VendorOwner->value)) {
            return (int) $order->restaurant->vendor_owner_id === (int) $user->getKey();
        }

        return false;
    }
}
