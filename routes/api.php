<?php

use App\Http\Controllers\Api\V1\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\MeController;
use App\Http\Controllers\Api\V1\Auth\NewPasswordController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::prefix('auth')->group(function (): void {
        Route::post('register', RegisterController::class)->middleware('throttle:10,1');
        Route::post('login', LoginController::class)->middleware('throttle:10,1');
        Route::post('forgot-password', PasswordResetLinkController::class)->middleware('throttle:6,1');
        Route::post('reset-password', NewPasswordController::class)->middleware('throttle:6,1');

        Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, 'verifySigned'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('api.verification.verify');

        Route::middleware(['auth:sanctum', 'active'])->group(function (): void {
            Route::post('logout', LogoutController::class);
            Route::get('me', MeController::class);
            Route::post('email/verification-notification', EmailVerificationNotificationController::class)
                ->middleware('throttle:6,1');
        });
    });

    Route::middleware(['auth:sanctum', 'active'])->group(function (): void {
        Route::get('permissions-matrix', function () {
            return response()->json([
                'roles' => \App\Enums\RoleName::values(),
                'permissions' => \App\Enums\PermissionName::values(),
                'matrix' => collect(\App\Support\PermissionsMatrix::rolePermissions())
                    ->map(fn ($perms, $role) => [
                        'role' => $role,
                        'permissions' => array_map(fn (\App\Enums\PermissionName $p) => $p->value, $perms),
                    ])
                    ->values(),
            ]);
        })->middleware('admin.api');
    });
});
