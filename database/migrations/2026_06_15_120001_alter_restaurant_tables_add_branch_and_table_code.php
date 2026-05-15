<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurant_tables', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->after('restaurant_id')->constrained()->nullOnDelete();
            $table->string('table_code', 64)->nullable()->after('label');
            $table->index(['branch_id', 'table_code']);
        });
    }

    public function down(): void
    {
        Schema::table('restaurant_tables', function (Blueprint $table) {
            $table->dropIndex(['branch_id', 'table_code']);
            $table->dropConstrainedForeignId('branch_id');
            $table->dropColumn('table_code');
        });
    }
};
