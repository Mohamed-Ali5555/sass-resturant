<?php

namespace Tests\Feature;

use App\Enums\PlanInterval;
use App\Enums\SubscriptionStatus;
use App\Models\Restaurant;
use App\Models\RestaurantSubscription;
use App\Models\RestaurantTable;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PublicQrRoutingTest extends TestCase
{
    use RefreshDatabase;

    private function seedRestaurantWithSubscription(): Restaurant
    {
        $owner = User::factory()->create();

        $plan = SubscriptionPlan::query()->create([
            'name' => 'QR test plan',
            'slug' => 'qr-plan-'.Str::lower(Str::random(8)),
            'interval' => PlanInterval::Monthly,
            'price_amount' => 10,
            'currency' => 'USD',
            'features' => [],
            'is_active' => true,
        ]);

        $restaurant = Restaurant::query()->create([
            'vendor_owner_id' => $owner->getKey(),
            'parent_restaurant_id' => null,
            'name' => 'QR Bistro',
            'slug' => 'qr-bistro-'.Str::lower(Str::random(6)),
            'status' => 'active',
            'currency' => 'USD',
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

        return $restaurant;
    }

    public function test_invalid_table_qr_token_returns_404(): void
    {
        $restaurant = $this->seedRestaurantWithSubscription();

        RestaurantTable::query()->create([
            'restaurant_id' => $restaurant->getKey(),
            'branch_id' => null,
            'label' => 'T1',
            'table_code' => null,
            'qr_token' => RestaurantTable::generateUniqueQrToken(),
        ]);

        $wrong = str_repeat('a', 48);

        $this->get(route('public.restaurant.table', [
            'restaurant' => $restaurant->slug,
            'qr_token' => $wrong,
        ]))->assertNotFound();
    }

    public function test_valid_table_qr_redirects_to_menu_and_sets_session(): void
    {
        $restaurant = $this->seedRestaurantWithSubscription();

        $token = RestaurantTable::generateUniqueQrToken();
        RestaurantTable::query()->create([
            'restaurant_id' => $restaurant->getKey(),
            'branch_id' => null,
            'label' => 'Window 2',
            'table_code' => 'W2',
            'qr_token' => $token,
        ]);

        $this->get(route('public.restaurant.table', [
            'restaurant' => $restaurant->slug,
            'qr_token' => $token,
        ]))
            ->assertRedirect(route('public.restaurant.show', ['restaurant' => $restaurant->slug]));

        $this->get(route('public.restaurant.show', ['restaurant' => $restaurant->slug]))
            ->assertOk()
            ->assertSee('Window 2', false);
    }

    public function test_menu_item_wrong_restaurant_returns_404(): void
    {
        $a = $this->seedRestaurantWithSubscription();
        $b = $this->seedRestaurantWithSubscription();

        $cat = $a->categories()->create(['name' => 'C', 'sort_order' => 0]);
        $item = $a->menuItems()->create([
            'category_id' => $cat->getKey(),
            'name' => 'Soup',
            'description' => null,
            'price' => 5,
            'is_available' => true,
            'image' => null,
            'stock_qty' => null,
            'track_inventory' => false,
        ]);

        $this->get(route('public.menu.item', [
            'restaurant' => $b->slug,
            'item' => $item->getKey(),
        ]))->assertNotFound();
    }
}
