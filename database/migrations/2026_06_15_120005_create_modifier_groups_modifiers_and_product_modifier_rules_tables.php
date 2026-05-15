<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modifier_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug', 96);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_required')->default(false);
            $table->timestamps();

            $table->unique(['restaurant_id', 'slug']);
            $table->index(['restaurant_id', 'sort_order']);
        });

        Schema::create('modifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modifier_group_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price_adjustment', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('modifier_group_id');
        });

        Schema::create('product_modifier_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained('menu_items')->cascadeOnDelete();
            $table->foreignId('modifier_group_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('min_select')->default(0);
            $table->unsignedTinyInteger('max_select')->nullable();
            $table->timestamps();

            $table->unique(['menu_item_id', 'modifier_group_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_modifier_rules');
        Schema::dropIfExists('modifiers');
        Schema::dropIfExists('modifier_groups');
    }
};
