<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('public_ref', 32)->unique();
            $table->foreignId('restaurant_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('restaurant_table_id')->nullable()->constrained('restaurant_tables')->nullOnDelete();
            $table->string('order_mode', 32);
            $table->string('status', 32);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_total', 12, 2)->default(0);
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->string('customer_name');
            $table->string('customer_phone', 64);
            $table->text('delivery_address')->nullable();
            $table->string('table_number', 32)->nullable();
            $table->text('customer_notes')->nullable();
            $table->timestamps();

            $table->index(['restaurant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
