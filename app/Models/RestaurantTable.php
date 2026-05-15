<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class RestaurantTable extends Model
{
    protected $table = 'restaurant_tables';

    protected $fillable = [
        'restaurant_id',
        'branch_id',
        'label',
        'table_code',
        'qr_token',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'restaurant_table_id');
    }

    public static function generateUniqueQrToken(): string
    {
        do {
            $token = Str::lower(Str::random(48));
        } while (static::query()->where('qr_token', $token)->exists());

        return $token;
    }
}
