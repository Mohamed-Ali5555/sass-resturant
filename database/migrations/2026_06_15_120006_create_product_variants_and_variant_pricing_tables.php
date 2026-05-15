<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained('menu_items')->cascadeOnDelete();
            $table->string('name');
            $table->string('sku', 64)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['menu_item_id', 'sort_order']);
        });

        Schema::create('variant_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->string('currency', 3)->default('USD');
            $table->decimal('price', 10, 2);
            $table->date('effective_from')->nullable();
            $table->timestamps();

            $table->index(['product_variant_id', 'effective_from']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_pricing');
        Schema::dropIfExists('product_variants');
    }
};
