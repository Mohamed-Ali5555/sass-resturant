<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('fee_amount', 10, 2)->default(0);
            $table->decimal('minimum_order_amount', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['restaurant_id', 'is_active']);
        });

        Schema::create('delivery_fee_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->decimal('min_subtotal', 10, 2)->default(0);
            $table->decimal('fee_amount', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['restaurant_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_fee_rules');
        Schema::dropIfExists('delivery_zones');
    }
};
