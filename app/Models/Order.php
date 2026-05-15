<?php

namespace App\Models;

use App\Enums\OrderMode;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    /**
     * Customer- and vendor-facing URLs use the public reference instead of numeric ids.
     */
    public function getRouteKeyName(): string
    {
        return 'public_ref';
    }

    protected $fillable = [
        'public_ref',
        'restaurant_id',
        'branch_id',
        'user_id',
        'restaurant_table_id',
        'order_mode',
        'order_type',
        'status',
        'subtotal',
        'tax_total',
        'delivery_fee',
        'delivery_zone_id',
        'grand_total',
        'customer_name',
        'customer_phone',
        'delivery_address',
        'table_number',
        'customer_notes',
    ];

    protected function casts(): array
    {
        return [
            'order_mode' => OrderMode::class,
            'order_type' => OrderType::class,
            'status' => OrderStatus::class,
            'subtotal' => 'decimal:2',
            'tax_total' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'grand_total' => 'decimal:2',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function deliveryZone(): BelongsTo
    {
        return $this->belongsTo(DeliveryZone::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function restaurantTable(): BelongsTo
    {
        return $this->belongsTo(RestaurantTable::class, 'restaurant_table_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderPayments(): HasMany
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function driverAssignment(): HasOne
    {
        return $this->hasOne(DriverAssignment::class);
    }
}
