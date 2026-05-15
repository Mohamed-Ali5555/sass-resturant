<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryZone extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'fee_amount',
        'minimum_order_amount',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'fee_amount' => 'decimal:2',
            'minimum_order_amount' => 'decimal:2',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
