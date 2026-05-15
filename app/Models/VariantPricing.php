<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantPricing extends Model
{
    protected $table = 'variant_pricing';

    protected $fillable = [
        'product_variant_id',
        'currency',
        'price',
        'effective_from',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'effective_from' => 'date',
        ];
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
