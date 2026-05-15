<?php

namespace App\Enums;

/**
 * Canonical permission names (guard: web). Synced to Spatie via {@see \App\Support\PermissionsMatrix}.
 */
enum PermissionName: string
{
    // Platform
    case AdminAccess = 'admin.access';
    case AdminUsersManage = 'admin.users.manage';
    case AdminRestaurantsManage = 'admin.restaurants.manage';
    case AdminPlansManage = 'admin.plans.manage';
    case AdminCommissionsManage = 'admin.commissions.manage';
    case AdminPaymentGatewaysManage = 'admin.payment-gateways.manage';
    case AdminSupportTicketsManage = 'admin.support-tickets.manage';
    case AdminAnalyticsView = 'admin.analytics.view';

    // Restaurant panel
    case VendorPanel = 'vendor.panel';
    case RestaurantSettingsUpdate = 'restaurant.settings.update';
    case RestaurantBranchesManage = 'restaurant.branches.manage';
    case RestaurantMenuManage = 'restaurant.menu.manage';
    case RestaurantTablesManage = 'restaurant.tables.manage';
    case RestaurantOpeningHoursManage = 'restaurant.opening-hours.manage';
    case RestaurantDeliveryManage = 'restaurant.delivery.manage';
    case RestaurantStaffManage = 'restaurant.staff.manage';
    case RestaurantAnalyticsView = 'restaurant.analytics.view';

    // Orders & operations
    case OrdersView = 'orders.view';
    case OrdersUpdateStatus = 'orders.update-status';
    case OrdersCreate = 'orders.create';
    case KitchenOrdersView = 'kitchen.orders.view';
    case KitchenOrdersUpdateStatus = 'kitchen.orders.update-status';
    case DeliveryAssignmentsView = 'delivery.assignments.view';
    case DeliveryAssignmentsUpdate = 'delivery.assignments.update';

    // Customer account
    case AccountOrdersView = 'account.orders.view';
    case AccountFavoritesView = 'account.favorites.view';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
