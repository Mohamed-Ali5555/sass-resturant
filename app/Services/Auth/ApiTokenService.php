<?php

namespace App\Services\Auth;

use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class ApiTokenService
{
    public function issue(User $user, string $deviceName = 'api'): NewAccessToken
    {
        $user->tokens()->where('name', $deviceName)->delete();

        return $user->createToken($deviceName, $this->abilitiesFor($user));
    }

    /**
     * @return list<string>
     */
    private function abilitiesFor(User $user): array
    {
        if ($user->isSuperAdmin()) {
            return ['*'];
        }

        return $user->getAllPermissions()
            ->pluck('name')
            ->unique()
            ->values()
            ->all();
    }
}
