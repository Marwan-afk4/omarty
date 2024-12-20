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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->Notnull()->constrained()->onDelete('cascade');
            $table->foreignId('flat_id')->Notnull()->constrained()->onDelete('cascade');
            $table->foreignId('zone_id')->Notnull()->constrained()->onDelete('cascade');
            $table->string('shop_name');
            $table->string('code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
