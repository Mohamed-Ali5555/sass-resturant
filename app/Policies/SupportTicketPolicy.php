<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\SupportTicket;
use App\Models\User;

class SupportTicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function view(User $user, SupportTicket $supportTicket): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function update(User $user, SupportTicket $supportTicket): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }

    public function reply(User $user, SupportTicket $supportTicket): bool
    {
        return $user->hasRole(RoleName::SuperAdmin->value);
    }
}
