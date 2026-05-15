<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('code', 64);
            $table->string('discount_type', 32);
            $table->decimal('percent_off', 5, 2)->nullable();
            $table->decimal('amount_off', 10, 2)->nullable();
            $table->unsignedInteger('max_redemptions')->nullable();
            $table->unsignedInteger('times_used')->default(0);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('code');
            $table->index(['restaurant_id', 'is_active']);
        });

        Schema::create('coupon_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('redeemed_at')->useCurrent();
            $table->timestamps();

            $table->index(['coupon_id', 'order_id']);
        });

        Schema::create('discount_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('rule_type', 32);
            $table->json('config');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['restaurant_id', 'rule_type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_rules');
        Schema::dropIfExists('coupon_redemptions');
        Schema::dropIfExists('coupons');
    }
};
