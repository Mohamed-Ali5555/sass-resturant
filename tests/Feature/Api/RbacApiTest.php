<?php

namespace Tests\Feature\Api;

use App\Enums\RoleName;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RbacApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_permissions_matrix_requires_admin_access(): void
    {
        $customer = User::factory()->create();
        $customer->syncRoles([RoleName::Customer->value]);
        $token = $customer->createToken('test')->plainTextToken;

        $this->getJson('/api/v1/permissions-matrix', [
            'Authorization' => 'Bearer '.$token,
        ])->assertForbidden();

        $admin = User::factory()->create([
            'email' => 'matrix-admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->syncRoles([RoleName::SuperAdmin->value]);

        // Verify the role was assigned
        $this->assertTrue($admin->fresh()->hasRole(RoleName::SuperAdmin->value));

        // Super admin can access matrix via actingAs (Sanctum guard-aware)
        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/permissions-matrix')
            ->assertOk()
            ->assertJsonStructure(['roles', 'permissions', 'matrix']);
    }

    public function test_cashier_has_orders_permissions_but_not_vendor_panel(): void
    {
        $cashier = User::factory()->create();
        $cashier->syncRoles([RoleName::Cashier->value]);

        $this->assertTrue($cashier->can('orders.view'));
        $this->assertFalse($cashier->can('vendor.panel'));
    }
}
