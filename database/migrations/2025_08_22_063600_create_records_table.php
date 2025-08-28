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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('startup_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->datetime('record_time')->nullable();
            $table->tinyInteger('status')->default(1); // 0: ok, 1: ng detected, 2: recheck, 3: carantine
            $table->boolean('is_reported')->default(false); // Whether the record has been reported
            $table->boolean('is_separated')->default(false); // Whether the record has been separated
            $table->boolean('is_quarantined')->default(false); // Whether the record has been quarantined
            $table->unsignedBigInteger('qa_id')->nullable(); // QA personnel who verified the record
            $table->datetime('qa_confirmed_at')->nullable(); // Time when QA verified the record
            $table->text('remarks')->nullable(); // Additional remarks for the record
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
