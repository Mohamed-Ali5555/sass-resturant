<?php

namespace App\Models;

use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Restaurant extends Model
{
    protected $fillable = [
        'vendor_owner_id',
        'parent_restaurant_id',
        'name',
        'slug',
        'status',
        'suspension_reason',
        'currency',
        'timezone',
        'tax_rate_percent',
        'delivery_fee',
        'enable_dine_in',
        'enable_takeaway',
        'enable_delivery',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'tax_rate_percent' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'enable_dine_in' => 'boolean',
            'enable_takeaway' => 'boolean',
            'enable_delivery' => 'boolean',
            'settings' => 'array',
        ];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $field ??= $this->getRouteKeyName();

        if ($field === 'slug') {
            return $this->where('slug', $value)
                ->where('status', 'active')
                ->firstOrFail();
        }

        return $this->where($field, $value)->firstOrFail();
    }

    public function vendorOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_owner_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_restaurant_id');
    }

    public function branches(): HasMany
    {
        return $this->hasMany(self::class, 'parent_restaurant_id');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(RestaurantProfile::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Physical locations (separate from child {@see self::branches()} restaurant rows).
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function modifierGroups(): HasMany
    {
        return $this->hasMany(ModifierGroup::class);
    }

    public function deliveryZones(): HasMany
    {
        return $this->hasMany(DeliveryZone::class);
    }

    public function deliveryFeeRules(): HasMany
    {
        return $this->hasMany(DeliveryFeeRule::class);
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function discountRules(): HasMany
    {
        return $this->hasMany(DiscountRule::class);
    }

    public function openingHours(): HasMany
    {
        return $this->hasMany(OpeningHour::class);
    }

    public function inventoryItems(): HasMany
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function paymentGatewayConfigs(): HasMany
    {
        return $this->hasMany(PaymentGatewayConfig::class);
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function restaurantTables(): HasMany
    {
        return $this->hasMany(RestaurantTable::class);
    }

    public function staffUsers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'restaurant_user')
            ->withPivot(['branch_id', 'staff_role', 'is_active'])
            ->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(RestaurantSubscription::class);
    }

    public function latestSubscription(): ?RestaurantSubscription
    {
        return $this->subscriptions()->orderByDesc('id')->first();
    }

    public function canShowPublicMenu(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $sub = $this->latestSubscription();

        if (! $sub) {
            return false;
        }

        return $sub->status !== SubscriptionStatus::Canceled;
    }

    public function canAcceptPublicOrders(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $sub = $this->latestSubscription();

        if (! $sub) {
            return false;
        }

        return in_array($sub->status, [
            SubscriptionStatus::Trialing,
            SubscriptionStatus::Active,
        ], true);
    }

    public function vendorCanManage(): bool
    {
        $sub = $this->latestSubscription();

        if (! $sub) {
            return false;
        }

        return ! in_array($sub->status, [SubscriptionStatus::Canceled], true);
    }
}
