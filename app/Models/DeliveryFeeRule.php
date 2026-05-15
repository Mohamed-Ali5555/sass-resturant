<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryFeeRule extends Model
{
    protected $fillable = [
        'restaurant_id',
        'min_subtotal',
        'fee_amount',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'min_subtotal' => 'decimal:2',
            'fee_amount' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
