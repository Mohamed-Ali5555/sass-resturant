<?php

namespace Tests\Feature;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_cannot_access_admin_subscription_plans_index(): void
    {
        $customer = User::factory()->create();
        $customer->syncRoles([RoleName::Customer->value]);

        $this->actingAs($customer)
            ->get(route('admin.subscription-plans.index'))
            ->assertForbidden();
    }

    public function test_super_admin_can_view_subscription_plans_index(): void
    {
        $admin = User::factory()->create();
        $admin->syncRoles([RoleName::SuperAdmin->value]);

        $this->actingAs($admin)
            ->get(route('admin.subscription-plans.index'))
            ->assertOk();
    }

    public function test_vendor_cannot_access_admin_users(): void
    {
        $vendor = User::factory()->create();
        $vendor->syncRoles([RoleName::VendorOwner->value]);

        $this->actingAs($vendor)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_vendor_cannot_access_admin_dashboard(): void
    {
        $vendor = User::factory()->create();
        $vendor->syncRoles([RoleName::VendorOwner->value]);

        $this->actingAs($vendor)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }
}
