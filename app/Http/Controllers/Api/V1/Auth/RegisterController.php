<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\Api\V1\AuthTokenResource;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Services\Auth\ApiTokenService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, ApiTokenService $tokens): JsonResponse
    {
        $user = User::query()->create([
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'password' => Hash::make($request->string('password')->toString()),
        ]);

        $user->syncRoles([RoleName::Customer->value]);

        event(new Registered($user));

        $token = $tokens->issue($user, $request->string('device_name', 'api')->toString());

        return response()->json([
            'message' => __('Registration successful.'),
            'user' => new UserResource($user->loadMissing([])),
            'auth' => new AuthTokenResource($token),
        ], 201);
    }
}
