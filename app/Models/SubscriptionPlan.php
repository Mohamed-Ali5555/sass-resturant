<?php

namespace App\Models;

use App\Enums\PlanInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'slug',
        'interval',
        'price_amount',
        'currency',
        'features',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'interval' => PlanInterval::class,
            'price_amount' => 'decimal:2',
            'features' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function restaurantSubscriptions(): HasMany
    {
        return $this->hasMany(RestaurantSubscription::class, 'subscription_plan_id');
    }
}
