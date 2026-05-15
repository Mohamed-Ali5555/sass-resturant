<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentGatewayConfig extends Model
{
    public const OWNER_PLATFORM = 'platform';

    public const OWNER_RESTAURANT = 'restaurant';

    protected $fillable = [
        'owner_scope',
        'restaurant_id',
        'driver',
        'secret_payload',
        'public_key_masked',
        'metadata',
        'enabled',
    ];

    protected function casts(): array
    {
        return [
            'secret_payload' => 'encrypted',
            'metadata' => 'array',
            'enabled' => 'boolean',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
