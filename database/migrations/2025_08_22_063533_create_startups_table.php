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
        Schema::create('startups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('device_id')->index();
            $table->date('startup_date')->nullable();
            $table->tinyInteger('status')->default(0); // 0: initial, 1: verified, 2: pause, 3: finish
            $table->string('verification_type')->nullable(); // e.g., 'hourly', 'batch'
            $table->enum('pause_reason', ['break', 'noise', 'maintenance'])->nullable(); // e.g. 'break', 'noise', 'maintenance'
            $table->datetime('pause_time')->nullable(); // last pause times
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startups');
    }
};
