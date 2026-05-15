<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->text('suspension_reason')->nullable()->after('status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_disabled')->default(false)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_disabled');
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('suspension_reason');
        });
    }
};
