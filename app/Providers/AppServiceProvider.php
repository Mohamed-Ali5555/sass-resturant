<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\PaymentGatewayConfig;
use App\Models\PlatformCommission;
use App\Models\Restaurant;
use App\Models\RestaurantSubscription;
use App\Models\SubscriptionPlan;
use App\Models\SupportTicket;
use App\Models\User;
use App\Policies\MenuPolicy;
use App\Policies\PaymentGatewayConfigPolicy;
use App\Policies\PlatformCommissionPolicy;
use App\Policies\RestaurantPolicy;
use App\Policies\RestaurantSubscriptionPolicy;
use App\Policies\SubscriptionPlanPolicy;
use App\Policies\SupportTicketPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->useMysqlWhenSqliteIsMisconfigured();

        Gate::before(function (User $user, string $ability): ?bool {
            if ($user->isSuperAdmin()) {
                return true;
            }

            return null;
        });

        Gate::policy(Restaurant::class, RestaurantPolicy::class);
        Gate::policy(Category::class, MenuPolicy::class);
        Gate::policy(MenuItem::class, MenuPolicy::class);
        Gate::policy(SubscriptionPlan::class, SubscriptionPlanPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(PlatformCommission::class, PlatformCommissionPolicy::class);
        Gate::policy(PaymentGatewayConfig::class, PaymentGatewayConfigPolicy::class);
        Gate::policy(SupportTicket::class, SupportTicketPolicy::class);
        Gate::policy(RestaurantSubscription::class, RestaurantSubscriptionPolicy::class);
    }

    /**
     * If the default connection is SQLite but the "database" value is clearly not a SQLite
     * file (e.g. a MySQL schema name like "sassresturant"), fall back to MySQL. This fixes
     * common mis-setups: cached config, or a global DB_CONNECTION=sqlite while DB_DATABASE
     * still holds the MySQL database name.
     */
    private function useMysqlWhenSqliteIsMisconfigured(): void
    {
        if ($this->app->environment('testing')) {
            return;
        }

        if (config('database.default') !== 'sqlite') {
            return;
        }

        $sqliteDatabase = (string) config('database.connections.sqlite.database');
        $looksLikeSqlite = $sqliteDatabase === ''
            || str_starts_with($sqliteDatabase, ':memory:')
            || str_contains($sqliteDatabase, '.sqlite');

        if ($looksLikeSqlite) {
            return;
        }

        $mysqlDatabase = (string) config('database.connections.mysql.database');
        if ($mysqlDatabase === '') {
            return;
        }

        config(['database.default' => 'mysql']);
        DB::purge();
        DB::reconnect();
    }
}
