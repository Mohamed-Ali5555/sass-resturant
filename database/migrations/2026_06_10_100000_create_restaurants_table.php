<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_owner_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('parent_restaurant_id')->nullable()->constrained('restaurants')->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('status', 32)->default('active');
            $table->string('currency', 3)->default('USD');
            $table->string('timezone')->nullable();
            $table->decimal('tax_rate_percent', 5, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->boolean('enable_dine_in')->default(true);
            $table->boolean('enable_takeaway')->default(true);
            $table->boolean('enable_delivery')->default(true);
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->unique('slug');
            $table->index('parent_restaurant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
