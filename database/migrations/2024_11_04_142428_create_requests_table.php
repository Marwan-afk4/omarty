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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->Notnull()->constrained()->onDelete('cascade');
            $table->string('country')->Notnullable();
            $table->string('city')->Notnullable();
            $table->string('zone')->Notnullable();
            $table->string('attachment_image')->Notnullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->Notnullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};