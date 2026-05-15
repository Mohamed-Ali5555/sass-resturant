<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurant_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->string('address_line')->nullable();
            $table->string('city')->nullable();
            $table->string('country', 2)->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('logo_path')->nullable();
            $table->json('brand_colors')->nullable();
            $table->timestamps();

            $table->unique('restaurant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_profiles');
    }
};
