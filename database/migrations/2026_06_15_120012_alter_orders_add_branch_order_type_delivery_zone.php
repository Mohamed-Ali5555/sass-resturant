<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->after('restaurant_id')->constrained()->nullOnDelete();
            $table->string('order_type', 32)->nullable()->after('order_mode');
            $table->foreignId('delivery_zone_id')->nullable()->after('delivery_fee')->constrained('delivery_zones')->nullOnDelete();
            $table->index('order_type');
            $table->index('status');
        });

        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            DB::statement("UPDATE orders SET order_type = CASE order_mode WHEN 'dine_in' THEN 'dine_in' WHEN 'takeaway' THEN 'pickup' WHEN 'delivery' THEN 'delivery' ELSE 'pickup' END");
        } else {
            DB::table('orders')->where('order_mode', 'dine_in')->update(['order_type' => 'dine_in']);
            DB::table('orders')->where('order_mode', 'takeaway')->update(['order_type' => 'pickup']);
            DB::table('orders')->where('order_mode', 'delivery')->update(['order_type' => 'delivery']);
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['delivery_zone_id']);
            $table->dropForeign(['branch_id']);
            $table->dropIndex(['order_type']);
            $table->dropIndex(['status']);
            $table->dropColumn(['branch_id', 'order_type', 'delivery_zone_id']);
        });
    }
};
