<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('region', 96)->nullable()->after('city');
            $table->decimal('latitude', 10, 7)->nullable()->after('country');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->string('contact_phone', 32)->nullable()->after('longitude');
            $table->text('delivery_instructions')->nullable()->after('contact_phone');
            $table->string('building_floor', 64)->nullable()->after('delivery_instructions');
        });
    }

    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn([
                'region',
                'latitude',
                'longitude',
                'contact_phone',
                'delivery_instructions',
                'building_floor',
            ]);
        });
    }
};
