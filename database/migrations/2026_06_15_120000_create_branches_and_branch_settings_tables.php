<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug', 96);
            $table->string('status', 32)->default('active');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['restaurant_id', 'slug']);
            $table->index(['restaurant_id', 'status']);
        });

        Schema::create('branch_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->unique('branch_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_settings');
        Schema::dropIfExists('branches');
    }
};
