<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantProfile extends Model
{
    protected $fillable = [
        'restaurant_id',
        'address_line',
        'city',
        'country',
        'phone',
        'logo_path',
        'gallery_paths',
        'brand_colors',
    ];

    protected function casts(): array
    {
        return [
            'brand_colors' => 'array',
            'gallery_paths' => 'array',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
