<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModifierGroup extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'slug',
        'sort_order',
        'is_required',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_required' => 'boolean',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function modifiers(): HasMany
    {
        return $this->hasMany(Modifier::class);
    }

    public function productModifierRules(): HasMany
    {
        return $this->hasMany(ProductModifierRule::class);
    }
}
