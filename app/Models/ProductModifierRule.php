<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductModifierRule extends Model
{
    protected $fillable = [
        'menu_item_id',
        'modifier_group_id',
        'min_select',
        'max_select',
    ];

    protected function casts(): array
    {
        return [
            'min_select' => 'integer',
            'max_select' => 'integer',
        ];
    }

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function modifierGroup(): BelongsTo
    {
        return $this->belongsTo(ModifierGroup::class);
    }
}
