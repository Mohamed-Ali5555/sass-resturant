<?php

namespace Tests\Feature;

use App\Enums\OrderMode;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AccountHubTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_account_orders(): void
    {
        $this->get(route('account.orders.index'))->assertRedirect(route('login'));
    }

    public function test_customer_can_view_account_orders_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('account.orders.index'))
            ->assertOk();
    }

    public function test_customer_cannot_view_another_users_order(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $restaurant = Restaurant::query()->create([
            'vendor_owner_id' => $owner->getKey(),
            'parent_restaurant_id' => null,
            'name' => 'Test Restaurant',
            'slug' => 'hub-test-'.Str::lower(Str::random(6)),
            'status' => 'active',
            'currency' => 'USD',
        ]);

        $order = Order::query()->create([
            'public_ref' => 't'.Str::lower(Str::random(15)),
            'restaurant_id' => $restaurant->getKey(),
            'user_id' => $owner->getKey(),
            'order_mode' => OrderMode::DineIn->value,
            'order_type' => OrderType::DineIn->value,
            'status' => OrderStatus::New->value,
            'subtotal' => '10.00',
            'tax_total' => '0.00',
            'delivery_fee' => '0.00',
            'grand_total' => '10.00',
            'customer_name' => 'Owner',
            'customer_phone' => '5550000',
        ]);

        $this->actingAs($other)
            ->get(route('account.orders.show', $order))
            ->assertForbidden();
    }
}
