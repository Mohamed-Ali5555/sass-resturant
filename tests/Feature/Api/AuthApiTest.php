<?php

namespace Tests\Feature\Api;

use App\Enums\RoleName;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_guest_can_register_and_receive_token(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'API Customer',
            'email' => 'api-customer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'device_name' => 'iphone',
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'user' => ['id', 'email', 'roles', 'permissions'],
                'auth' => ['token_type', 'access_token'],
            ]);

        $this->assertDatabaseHas('users', ['email' => 'api-customer@example.com']);
        $user = User::query()->where('email', 'api-customer@example.com')->first();
        $this->assertTrue($user->hasRole(RoleName::Customer->value));
    }

    public function test_user_can_login_and_access_me(): void
    {
        $user = User::factory()->create([
            'email' => 'login-api@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->syncRoles([RoleName::Customer->value]);

        $login = $this->postJson('/api/v1/auth/login', [
            'email' => 'login-api@example.com',
            'password' => 'password',
        ]);

        $login->assertOk();
        $token = $login->json('auth.access_token');

        $this->getJson('/api/v1/auth/me', [
            'Authorization' => 'Bearer '.$token,
        ])
            ->assertOk()
            ->assertJsonPath('data.email', 'login-api@example.com');
    }

    public function test_disabled_user_cannot_login_via_api(): void
    {
        $user = User::factory()->create([
            'email' => 'disabled-api@example.com',
            'password' => Hash::make('password'),
            'is_disabled' => true,
        ]);
        $user->syncRoles([RoleName::Customer->value]);

        $this->postJson('/api/v1/auth/login', [
            'email' => 'disabled-api@example.com',
            'password' => 'password',
        ])->assertStatus(422);
    }

    public function test_logout_revokes_token(): void
    {
        $user = User::factory()->create([
            'email' => 'logout-flow@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->syncRoles([RoleName::Customer->value]);

        $login = $this->postJson('/api/v1/auth/login', [
            'email' => 'logout-flow@example.com',
            'password' => 'password',
            'device_name' => 'test-device',
        ]);

        $login->assertOk();
        $token = $login->json('auth.access_token');

        $this->postJson('/api/v1/auth/logout', [], [
            'Authorization' => 'Bearer '.$token,
        ])->assertOk();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
        ]);
    }
}
