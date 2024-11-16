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
        Schema::table('requests', function (Blueprint $table) {
            $table->foreignId('country_id')->after('user_id')->Notnull()->constrained()->onDelete('cascade');
            $table->foreignId('city_id')->after('country_id')->Notnull()->constrained()->onDelete('cascade');
            $table->string('building_name')->after('zone')->Notnull();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            //
        });
    }
};
