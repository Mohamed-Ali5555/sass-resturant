<?php

namespace Database\Seeders;

use App\Enums\PlanInterval;
use App\Enums\RoleName;
use App\Enums\SubscriptionStatus;
use App\Models\Address;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\RestaurantProfile;
use App\Models\RestaurantSubscription;
use App\Models\RestaurantTable;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FoodMenuSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@foodmenu.local'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ],
        );
        $admin->syncRoles([RoleName::SuperAdmin->value]);

        $vendor = User::query()->firstOrCreate(
            ['email' => 'vendor@demo.local'],
            [
                'name' => 'Demo Vendor',
                'password' => Hash::make('password'),
            ],
        );
        $vendor->syncRoles([RoleName::VendorOwner->value]);

        $manager = User::query()->firstOrCreate(
            ['email' => 'manager@demo.local'],
            [
                'name' => 'Demo Manager',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $manager->syncRoles([RoleName::BranchManager->value]);

        $cashier = User::query()->firstOrCreate(
            ['email' => 'cashier@demo.local'],
            [
                'name' => 'Demo Cashier',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $cashier->syncRoles([RoleName::Cashier->value]);

        $customer = User::query()->firstOrCreate(
            ['email' => 'customer@demo.local'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $customer->syncRoles([RoleName::Customer->value]);

        Address::query()->updateOrCreate(
            [
                'user_id' => $vendor->getKey(),
                'label' => 'Home',
            ],
            [
                'line1' => '123 Demo Street',
                'line2' => null,
                'city' => 'Demo City',
                'postal_code' => '12345',
                'country' => 'US',
                'is_default' => true,
            ],
        );

        $plan = SubscriptionPlan::query()->firstOrCreate(
            ['slug' => 'standard-monthly'],
            [
                'name' => 'Standard',
                'interval' => PlanInterval::Monthly,
                'price_amount' => 29.00,
                'currency' => 'USD',
                'features' => ['menu', 'orders'],
                'is_active' => true,
            ],
        );

        $main = Restaurant::query()->updateOrCreate(
            ['slug' => 'demo-bistro'],
            [
                'vendor_owner_id' => $vendor->getKey(),
                'parent_restaurant_id' => null,
                'name' => 'Demo Bistro',
                'status' => 'active',
                'currency' => 'USD',
                'timezone' => 'UTC',
                'tax_rate_percent' => 10,
                'delivery_fee' => 3.50,
                'enable_dine_in' => true,
                'enable_takeaway' => true,
                'enable_delivery' => true,
            ],
        );

        RestaurantProfile::query()->updateOrCreate(
            ['restaurant_id' => $main->getKey()],
            [
                'address_line' => '10 Market Square',
                'city' => 'Demo City',
                'country' => 'US',
                'phone' => '+1-555-0100',
                'logo_path' => null,
                'brand_colors' => ['primary' => '#4f46e5', 'accent' => '#f97316'],
            ],
        );

        $this->seedSubscription($main, $plan);

        $north = Restaurant::query()->updateOrCreate(
            ['slug' => 'demo-bistro-north'],
            [
                'vendor_owner_id' => $vendor->getKey(),
                'parent_restaurant_id' => $main->getKey(),
                'name' => 'Demo Bistro — North Branch',
                'status' => 'active',
                'currency' => 'USD',
                'timezone' => 'UTC',
                'tax_rate_percent' => 10,
                'delivery_fee' => 3.50,
                'enable_dine_in' => true,
                'enable_takeaway' => true,
                'enable_delivery' => true,
            ],
        );

        RestaurantProfile::query()->updateOrCreate(
            ['restaurant_id' => $north->getKey()],
            [
                'address_line' => '200 North Avenue',
                'city' => 'Demo City',
                'country' => 'US',
                'phone' => '+1-555-0101',
                'logo_path' => null,
                'brand_colors' => null,
            ],
        );

        $this->seedSubscription($north, $plan);

        $south = Restaurant::query()->updateOrCreate(
            ['slug' => 'demo-bistro-south'],
            [
                'vendor_owner_id' => $vendor->getKey(),
                'parent_restaurant_id' => $main->getKey(),
                'name' => 'Demo Bistro — South Branch',
                'status' => 'active',
                'currency' => 'USD',
                'timezone' => 'UTC',
                'tax_rate_percent' => 10,
                'delivery_fee' => 3.50,
                'enable_dine_in' => true,
                'enable_takeaway' => true,
                'enable_delivery' => true,
            ],
        );

        RestaurantProfile::query()->updateOrCreate(
            ['restaurant_id' => $south->getKey()],
            [
                'address_line' => '88 South Road',
                'city' => 'Demo City',
                'country' => 'US',
                'phone' => '+1-555-0102',
                'logo_path' => null,
                'brand_colors' => null,
            ],
        );

        $this->seedSubscription($south, $plan);

        $categoryBlocks = [
            ['name' => 'Mains', 'sort_order' => 10, 'items' => ['Margherita Pizza', 'Grilled Salmon', 'Beef Burger', 'Chicken Shawarma']],
            ['name' => 'Appetizers', 'sort_order' => 20, 'items' => ['Bruschetta Trio', 'Crispy Calamari', 'Soup of the Day', 'House Salad']],
            ['name' => 'Sides', 'sort_order' => 30, 'items' => ['Garlic Fries', 'Seasoned Rice', 'Steamed Broccoli', 'Coleslaw']],
            ['name' => 'Desserts', 'sort_order' => 40, 'items' => ['Chocolate Brownie', 'Vanilla Panna Cotta', 'Lemon Tart', 'Ice Cream Cup']],
            ['name' => 'Hot Drinks', 'sort_order' => 50, 'items' => ['Espresso', 'Cappuccino', 'Latte', 'Hot Chocolate']],
            ['name' => 'Cold Drinks', 'sort_order' => 60, 'items' => ['Iced Tea', 'Lemonade', 'Sparkling Water', 'Cola']],
            ['name' => 'Specials', 'sort_order' => 70, 'items' => ['Chef Pasta', 'Market Fish', 'Daily Wrap']],
            ['name' => 'Kids', 'sort_order' => 80, 'items' => ['Kids Burger', 'Mac & Cheese', 'Chicken Tenders']],
        ];

        $itemIndex = 0;
        foreach ($categoryBlocks as $block) {
            $category = Category::query()->firstOrCreate(
                [
                    'restaurant_id' => $main->getKey(),
                    'name' => $block['name'],
                ],
                [
                    'sort_order' => $block['sort_order'],
                ],
            );

            foreach ($block['items'] as $itemName) {
                $itemIndex++;
                $price = round(6.5 + ($itemIndex * 0.35), 2);

                MenuItem::query()->updateOrCreate(
                    [
                        'restaurant_id' => $main->getKey(),
                        'name' => $itemName,
                    ],
                    [
                        'category_id' => $category->getKey(),
                        'description' => 'Seeded demo item #'.$itemIndex.'.',
                        'price' => $price,
                        'is_available' => true,
                        'image' => null,
                        'track_inventory' => $itemIndex % 5 === 0,
                        'stock_qty' => $itemIndex % 5 === 0 ? 40 : null,
                    ],
                );
            }
        }

        for ($t = 1; $t <= 10; $t++) {
            RestaurantTable::query()->firstOrCreate(
                [
                    'restaurant_id' => $main->getKey(),
                    'label' => 'Table '.$t,
                ],
                [
                    'qr_token' => RestaurantTable::generateUniqueQrToken(),
                ],
            );
        }
    }

    private function seedSubscription(Restaurant $restaurant, SubscriptionPlan $plan): void
    {
        RestaurantSubscription::query()->updateOrCreate(
            ['restaurant_id' => $restaurant->getKey()],
            [
                'subscription_plan_id' => $plan->getKey(),
                'status' => SubscriptionStatus::Active,
                'trial_ends_at' => null,
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
                'canceled_at' => null,
                'external_subscription_id' => null,
                'billing_cycle' => $plan->interval->value,
            ],
        );
    }
}
