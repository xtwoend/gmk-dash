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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('type')->nullable(); // e.g., machines type
            $table->string('verification_type')->nullable(); // e.g., 'hourly', 'batch'
            $table->string('location')->nullable();
            $table->tinyInteger('status')->default(1); // 1: active, 0: inactive
            $table->string('handler')->nullable(); // handler for the device
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
