<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'category_id',
        'name',
        'description',
        'price',
        'is_available',
        'image',
        'stock_qty',
        'track_inventory',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_available' => 'boolean',
            'track_inventory' => 'boolean',
        ];
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'menu_item_id');
    }

    public function productModifierRules(): HasMany
    {
        return $this->hasMany(ProductModifierRule::class, 'menu_item_id');
    }

    public function inventoryItems(): HasMany
    {
        return $this->hasMany(InventoryItem::class, 'menu_item_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'product_id');
    }
}
