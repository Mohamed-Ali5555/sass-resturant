<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurant_subscriptions', function (Blueprint $table) {
            $table->string('billing_cycle', 16)->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('restaurant_subscriptions', function (Blueprint $table) {
            $table->dropColumn('billing_cycle');
        });
    }
};
