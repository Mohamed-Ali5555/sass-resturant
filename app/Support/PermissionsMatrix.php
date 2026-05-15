<?php

namespace App\Support;

use App\Enums\PermissionName;
use App\Enums\RoleName;

/**
 * Role → permission mapping for Spatie seeding and documentation.
 */
final class PermissionsMatrix
{
    /**
     * @return array<string, list<PermissionName>>
     */
    public static function rolePermissions(): array
    {
        return [
            RoleName::SuperAdmin->value => PermissionName::cases(),

            RoleName::VendorOwner->value => [
                PermissionName::VendorPanel,
                PermissionName::RestaurantSettingsUpdate,
                PermissionName::RestaurantBranchesManage,
                PermissionName::RestaurantMenuManage,
                PermissionName::RestaurantTablesManage,
                PermissionName::RestaurantOpeningHoursManage,
                PermissionName::RestaurantDeliveryManage,
                PermissionName::RestaurantStaffManage,
                PermissionName::RestaurantAnalyticsView,
                PermissionName::OrdersView,
                PermissionName::OrdersUpdateStatus,
                PermissionName::OrdersCreate,
                PermissionName::KitchenOrdersView,
                PermissionName::KitchenOrdersUpdateStatus,
                PermissionName::DeliveryAssignmentsView,
                PermissionName::DeliveryAssignmentsUpdate,
            ],

            RoleName::BranchManager->value => [
                PermissionName::VendorPanel,
                PermissionName::RestaurantBranchesManage,
                PermissionName::RestaurantMenuManage,
                PermissionName::RestaurantTablesManage,
                PermissionName::RestaurantOpeningHoursManage,
                PermissionName::RestaurantDeliveryManage,
                PermissionName::RestaurantAnalyticsView,
                PermissionName::OrdersView,
                PermissionName::OrdersUpdateStatus,
                PermissionName::OrdersCreate,
                PermissionName::KitchenOrdersView,
                PermissionName::KitchenOrdersUpdateStatus,
                PermissionName::DeliveryAssignmentsView,
                PermissionName::DeliveryAssignmentsUpdate,
            ],

            RoleName::Cashier->value => [
                PermissionName::OrdersView,
                PermissionName::OrdersCreate,
                PermissionName::OrdersUpdateStatus,
            ],

            RoleName::KitchenStaff->value => [
                PermissionName::KitchenOrdersView,
                PermissionName::KitchenOrdersUpdateStatus,
            ],

            RoleName::DeliveryDriver->value => [
                PermissionName::DeliveryAssignmentsView,
                PermissionName::DeliveryAssignmentsUpdate,
                PermissionName::OrdersView,
            ],

            RoleName::Customer->value => [
                PermissionName::AccountOrdersView,
                PermissionName::AccountFavoritesView,
            ],
        ];
    }

    /**
     * Platform-only permissions granted to Super Admin in addition to full set.
     *
     * @return list<PermissionName>
     */
    public static function platformPermissions(): array
    {
        return [
            PermissionName::AdminAccess,
            PermissionName::AdminUsersManage,
            PermissionName::AdminRestaurantsManage,
            PermissionName::AdminPlansManage,
            PermissionName::AdminCommissionsManage,
            PermissionName::AdminPaymentGatewaysManage,
            PermissionName::AdminSupportTicketsManage,
            PermissionName::AdminAnalyticsView,
        ];
    }
}
