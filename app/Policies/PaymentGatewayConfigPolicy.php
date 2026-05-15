<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\PaymentGatewayConfig;
use App\Models\User;

class PaymentGatewayConfigPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function update(User $user, PaymentGatewayConfig $paymentGatewayConfig): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }
}
