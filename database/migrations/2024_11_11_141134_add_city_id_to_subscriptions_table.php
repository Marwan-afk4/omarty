<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreignId('country_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('city_id')->after('country_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('zone_id')->after('city_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('building_id')->after('zone_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            //
        });
    }
};
