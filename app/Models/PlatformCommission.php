<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformCommission extends Model
{
    public const SCOPE_PLATFORM = 'platform';

    public const SCOPE_PLAN = 'plan';

    public const SCOPE_RESTAURANT = 'restaurant';

    protected $fillable = [
        'scope_type',
        'scope_id',
        'commission_percent',
    ];

    protected function casts(): array
    {
        return [
            'scope_id' => 'integer',
            'commission_percent' => 'decimal:2',
        ];
    }
}
