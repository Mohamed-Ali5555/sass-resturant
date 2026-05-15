<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\V1\AuthTokenResource;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Services\Auth\ApiTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, ApiTokenService $tokens): JsonResponse
    {
        $request->authenticate();

        $user = User::query()->where('email', $request->string('email'))->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        $token = $tokens->issue($user, $request->string('device_name', 'api')->toString());

        return response()->json([
            'message' => __('Authenticated.'),
            'user' => new UserResource($user),
            'auth' => new AuthTokenResource($token),
        ]);
    }
}
