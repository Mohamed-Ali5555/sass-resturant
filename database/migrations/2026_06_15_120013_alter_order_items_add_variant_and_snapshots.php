<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->nullable()->after('menu_item_id')->constrained('product_variants')->nullOnDelete();
            $table->json('pricing_snapshot')->nullable()->after('modifiers_snapshot');
            $table->json('customizations_snapshot')->nullable()->after('pricing_snapshot');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_variant_id');
            $table->dropColumn(['pricing_snapshot', 'customizations_snapshot']);
        });
    }
};
