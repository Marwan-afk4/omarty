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
        Schema::create('securities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->Notnull()->constrained()->onDelete('cascade');
            $table->date('start_date')->Notnullable();
            $table->date('end_date')->Notnullable();
            $table->time('start_time')->Notnullable();
            $table->time('end_time')->Notnullable();
            $table->enum('status', ['active', 'inactive'])->Notnullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('securities');
    }
};
