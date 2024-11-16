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
        Schema::create('report_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->Notnull()->constrained()->onDelete('cascade');
            $table->text('message')->Notnullable();
            $table->longText('image')->nullable();
            $table->date('date')->Notnullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_issues');
    }
};
