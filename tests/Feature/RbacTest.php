<?php

namespace Tests\Feature;

use App\Enums\PlanInterval;
use App\Enums\RoleName;
use App\Enums\SubscriptionStatus;
use App\Models\Restaurant;
use App\Models\RestaurantSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    private function attachActiveSubscription(Restaurant $restaurant): void
    {
        $plan = SubscriptionPlan::query()->create([
            'name' => 'Test plan',
            'slug' => 'test-plan-'.Str::lower(Str::random(10)),
            'interval' => PlanInterval::Monthly,
            'price_amount' => 10,
            'currency' => 'USD',
            'features' => [],
            'is_active' => true,
        ]);

        RestaurantSubscription::query()->create([
            'restaurant_id' => $restaurant->getKey(),
            'subscription_plan_id' => $plan->getKey(),
            'status' => SubscriptionStatus::Active,
            'trial_ends_at' => null,
            'current_period_start' => now(),
            'current_period_end' => now()->addMonth(),
            'canceled_at' => null,
            'external_subscription_id' => null,
        ]);
    }

    public function test_vendor_cannot_open_edit_for_another_vendors_restaurant(): void
    {
        $ownerA = User::factory()->create();
        $ownerA->syncRoles([RoleName::VendorOwner->value]);

        $ownerB = User::factory()->create();
        $ownerB->syncRoles([RoleName::VendorOwner->value]);

        $restaurantA = Restaurant::query()->create([
            'vendor_owner_id' => $ownerA->getKey(),
            'parent_restaurant_id' => null,
            'name' => 'Restaurant A',
            'slug' => 'rest-a-'.Str::lower(Str::random(8)),
            'status' => 'active',
            'currency' => 'USD',
        ]);

        $restaurantB = Restaurant::query()->create([
            'vendor_owner_id' => $ownerB->getKey(),
            'parent_restaurant_id' => null,
            'name' => 'Restaurant B',
            'slug' => 'rest-b-'.Str::lower(Str::random(8)),
            'status' => 'active',
            'currency' => 'USD',
        ]);

        $this->attachActiveSubscription($restaurantA);
        $this->attachActiveSubscription($restaurantB);

        $response = $this->actingAs($ownerA)
            ->withSession(['vendor_restaurant_id' => $restaurantA->getKey()])
            ->get(route('vendor.restaurants.edit', $restaurantB));

        $response->assertForbidden();
    }

    public function test_customer_cannot_access_vendor_panel(): void
    {
        $customer = User::factory()->create();
        $customer->syncRoles([RoleName::Customer->value]);

        $response = $this->actingAs($customer)->get(route('vendor.dashboard'));

        $response->assertForbidden();
    }
}
