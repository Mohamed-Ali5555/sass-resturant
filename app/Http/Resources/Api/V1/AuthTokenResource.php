<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\NewAccessToken;

/** @mixin NewAccessToken */
class AuthTokenResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token_type' => 'Bearer',
            'access_token' => $this->plainTextToken,
            'abilities' => $this->accessToken->abilities ?? [],
            'expires_at' => $this->accessToken->expires_at?->toIso8601String(),
        ];
    }
}
