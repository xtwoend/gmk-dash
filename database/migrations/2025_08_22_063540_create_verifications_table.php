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
        Schema::create('verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('startup_id')->references('id')->on('startups')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('foreman_id')->nullable(); // Foreman who verified the startup
            $table->string('type')->nullable(); // Type of verification (e.g., 'startup', 'break', 'maintenance')
            $table->tinyInteger('fe')->default(0);  // counter fe verification metdec max 3 (font, middle, back)
            $table->tinyInteger('non_fe')->default(0);  // counter non_fe verification metdec max 3 (font, middle, back)
            $table->tinyInteger('ss')->default(0);  // counter ss verification metdec max 3 (font, middle, back)
            $table->tinyInteger('status')->default(0);  // status verification (0: failed, 1: success)
            $table->string('wor')->nullable(); // Work Order Reference
            $table->string('remarks')->nullable(); // Additional remarks for the verification
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifications');
    }
};
