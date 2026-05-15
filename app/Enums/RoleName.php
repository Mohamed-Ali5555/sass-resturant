<?php

namespace App\Enums;

/**
 * Spatie role names (guard: web). Use with {@see \App\Models\User::assignRole()}.
 *
 * Restaurant Owner is stored as {@see self::VendorOwner} for backward compatibility.
 */
enum RoleName: string
{
    case SuperAdmin = 'super_admin';
    case VendorOwner = 'vendor_owner';
    case BranchManager = 'branch_manager';
    case Cashier = 'cashier';
    case KitchenStaff = 'kitchen_staff';
    case DeliveryDriver = 'delivery_driver';
    case Customer = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::VendorOwner => 'Restaurant Owner',
            self::BranchManager => 'Branch Manager',
            self::Cashier => 'Cashier',
            self::KitchenStaff => 'Kitchen Staff',
            self::DeliveryDriver => 'Delivery Driver',
            self::Customer => 'Customer',
        };
    }

    /**
     * Roles that may access the vendor web panel (also require restaurant context).
     *
     * @return list<string>
     */
    public static function vendorPanelRoles(): array
    {
        return [
            self::SuperAdmin->value,
            self::VendorOwner->value,
            self::BranchManager->value,
        ];
    }

    /**
     * Roles that can be assigned to restaurant staff members.
     *
     * @return list<self>
     */
    public static function staffRoles(): array
    {
        return [
            self::BranchManager,
            self::Cashier,
            self::KitchenStaff,
            self::DeliveryDriver,
        ];
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
