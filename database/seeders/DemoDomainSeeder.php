<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchSetting;
use App\Models\Coupon;
use App\Models\DeliveryFeeRule;
use App\Models\DeliveryZone;
use App\Models\DiscountRule;
use App\Models\Favorite;
use App\Models\InventoryItem;
use App\Models\MenuItem;
use App\Models\Modifier;
use App\Models\ModifierGroup;
use App\Models\OpeningHour;
use App\Models\PaymentGatewayConfig;
use App\Models\PlatformCommission;
use App\Models\ProductModifierRule;
use App\Models\ProductVariant;
use App\Models\Restaurant;
use App\Models\RestaurantSubscription;
use App\Models\RestaurantTable;
use App\Models\StockMovement;
use App\Models\SupportTicket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Models\VariantPricing;
use Illuminate\Database\Seeder;

class DemoDomainSeeder extends Seeder
{
    public function run(): void
    {
        $main = Restaurant::query()->where('slug', 'demo-bistro')->first();
        if (! $main) {
            return;
        }

        $vendor   = User::query()->where('email', 'vendor@demo.local')->first();
        $manager  = User::query()->where('email', 'manager@demo.local')->first();
        $cashier  = User::query()->where('email', 'cashier@demo.local')->first();

        $hq = Branch::query()->updateOrCreate(
            ['restaurant_id' => $main->getKey(), 'slug' => 'hq'],
            [
                'name' => 'HQ — Market Square',
                'status' => 'active',
                'sort_order' => 10,
            ],
        );

        $drive = Branch::query()->updateOrCreate(
            ['restaurant_id' => $main->getKey(), 'slug' => 'drive-thru'],
            [
                'name' => 'Drive-through lane',
                'status' => 'active',
                'sort_order' => 20,
            ],
        );

        BranchSetting::query()->updateOrCreate(
            ['branch_id' => $hq->getKey()],
            ['settings' => ['prep_time_minutes' => 12, 'accepts_orders' => true]],
        );

        BranchSetting::query()->updateOrCreate(
            ['branch_id' => $drive->getKey()],
            ['settings' => ['prep_time_minutes' => 8, 'accepts_orders' => true]],
        );

        $tables = RestaurantTable::query()
            ->where('restaurant_id', $main->getKey())
            ->orderBy('id')
            ->take(4)
            ->get();

        foreach ($tables as $index => $table) {
            $branch = $index < 2 ? $hq : $drive;
            $table->update([
                'branch_id' => $branch->getKey(),
                'table_code' => 'T'.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
            ]);
        }

        PlatformCommission::query()->updateOrCreate(
            ['scope_type' => PlatformCommission::SCOPE_PLATFORM, 'scope_id' => 0],
            ['commission_percent' => 8.5],
        );

        PaymentGatewayConfig::query()->updateOrCreate(
            [
                'owner_scope' => PaymentGatewayConfig::OWNER_PLATFORM,
                'restaurant_id' => null,
                'driver' => 'stripe',
            ],
            [
                'secret_payload' => 'sk_test_demo_placeholder',
                'public_key_masked' => 'pk_test_••••4242',
                'metadata' => ['mode' => 'test'],
                'enabled' => false,
            ],
        );

        $group = ModifierGroup::query()->updateOrCreate(
            ['restaurant_id' => $main->getKey(), 'slug' => 'pizza-extras'],
            [
                'name' => 'Pizza extras',
                'sort_order' => 10,
                'is_required' => false,
            ],
        );

        Modifier::query()->updateOrCreate(
            ['modifier_group_id' => $group->getKey(), 'name' => 'Extra cheese'],
            ['price_adjustment' => 1.50, 'sort_order' => 10],
        );
        Modifier::query()->updateOrCreate(
            ['modifier_group_id' => $group->getKey(), 'name' => 'Olives'],
            ['price_adjustment' => 0.75, 'sort_order' => 20],
        );

        $pizza = MenuItem::query()
            ->where('restaurant_id', $main->getKey())
            ->where('name', 'Margherita Pizza')
            ->first()
            ?? MenuItem::query()->where('restaurant_id', $main->getKey())->orderBy('id')->first();

        if ($pizza) {
            ProductModifierRule::query()->updateOrCreate(
                [
                    'menu_item_id' => $pizza->getKey(),
                    'modifier_group_id' => $group->getKey(),
                ],
                ['min_select' => 0, 'max_select' => 3],
            );

            $variant = ProductVariant::query()->updateOrCreate(
                ['menu_item_id' => $pizza->getKey(), 'name' => 'Large'],
                ['sku' => 'PIZZA-MARG-L', 'sort_order' => 10, 'is_default' => true],
            );

            VariantPricing::query()->updateOrCreate(
                [
                    'product_variant_id' => $variant->getKey(),
                    'currency' => $main->currency,
                    'effective_from' => null,
                ],
                ['price' => $pizza->price + 3],
            );
        }

        $inv = InventoryItem::query()->updateOrCreate(
            ['restaurant_id' => $main->getKey(), 'sku' => 'DEMO-SKU-001'],
            [
                'menu_item_id' => $pizza?->getKey(),
                'name' => 'Demo stock line',
                'quantity_on_hand' => 120,
            ],
        );

        StockMovement::query()->create([
            'inventory_item_id' => $inv->getKey(),
            'quantity_delta' => 120,
            'movement_type' => 'initial',
            'meta' => ['note' => 'seed opening balance'],
            'order_id' => null,
        ]);

        Coupon::query()->updateOrCreate(
            ['code' => 'DEMO10'],
            [
                'restaurant_id' => $main->getKey(),
                'discount_type' => 'percent',
                'percent_off' => 10,
                'amount_off' => null,
                'max_redemptions' => 1000,
                'times_used' => 0,
                'starts_at' => now()->subDay(),
                'ends_at' => now()->addYear(),
                'is_active' => true,
            ],
        );

        DiscountRule::query()->updateOrCreate(
            [
                'restaurant_id' => $main->getKey(),
                'name' => 'BOGO sides (demo)',
            ],
            [
                'rule_type' => 'bogo',
                'config' => [
                    'buy_qty' => 1,
                    'get_qty' => 1,
                    'scope' => 'category',
                    'category_name' => 'Sides',
                ],
                'is_active' => true,
            ],
        );

        DiscountRule::query()->updateOrCreate(
            [
                'restaurant_id' => $main->getKey(),
                'name' => 'Happy hour 15% (demo)',
            ],
            [
                'rule_type' => 'percent',
                'config' => ['percent' => 15, 'window' => '16:00-18:00'],
                'is_active' => false,
            ],
        );

        for ($d = 0; $d <= 6; $d++) {
            OpeningHour::query()->updateOrCreate(
                [
                    'restaurant_id' => $main->getKey(),
                    'branch_id' => null,
                    'day_of_week' => $d,
                ],
                [
                    'open_time' => $d === 0 ? null : '10:00:00',
                    'close_time' => $d === 0 ? null : '22:00:00',
                    'is_closed' => $d === 0,
                ],
            );
        }

        DeliveryZone::query()->updateOrCreate(
            ['restaurant_id' => $main->getKey(), 'name' => 'City center'],
            [
                'fee_amount' => 3.50,
                'minimum_order_amount' => 15,
                'sort_order' => 10,
                'is_active' => true,
            ],
        );

        DeliveryFeeRule::query()->updateOrCreate(
            [
                'restaurant_id' => $main->getKey(),
                'min_subtotal' => 40,
            ],
            [
                'fee_amount' => 0,
                'sort_order' => 10,
            ],
        );

        if ($vendor && $pizza) {
            Favorite::query()->updateOrCreate(
                [
                    'user_id' => $vendor->getKey(),
                    'product_id' => $pizza->getKey(),
                ],
                [],
            );
        }

        if ($vendor) {
            $ticket = SupportTicket::query()->updateOrCreate(
                [
                    'user_id' => $vendor->getKey(),
                    'restaurant_id' => $main->getKey(),
                    'subject' => 'Demo support thread',
                ],
                [
                    'status' => 'open',
                    'priority' => 'normal',
                ],
            );

            TicketMessage::query()->firstOrCreate(
                [
                    'ticket_id' => $ticket->getKey(),
                    'user_id' => $vendor->getKey(),
                    'body' => 'Hello, this is a seeded ticket for QA.',
                ],
                ['is_staff_reply' => false],
            );
        }

        RestaurantSubscription::query()
            ->where('restaurant_id', $main->getKey())
            ->whereNull('billing_cycle')
            ->update(['billing_cycle' => 'monthly']);

        if ($manager) {
            $manager->restaurantsAsStaff()->syncWithoutDetaching([
                $main->getKey() => [
                    'branch_id'  => null,
                    'staff_role' => 'branch_manager',
                    'is_active'  => true,
                ],
            ]);
        }

        if ($cashier) {
            $cashier->restaurantsAsStaff()->syncWithoutDetaching([
                $main->getKey() => [
                    'branch_id'  => null,
                    'staff_role' => 'cashier',
                    'is_active'  => true,
                ],
            ]);
        }
    }
}
