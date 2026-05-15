<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // See categories migration: menu catalog uses soft deletes; transactional tables do not.
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->boolean('is_available')->default(true);
            $table->string('image')->nullable();
            $table->unsignedInteger('stock_qty')->nullable();
            $table->boolean('track_inventory')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['restaurant_id', 'is_available']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
