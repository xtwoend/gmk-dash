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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->datetime('activity_date')->nullable();
            $table->unsignedBigInteger('foreman_id')->nullable(); // Foreman who performed the activity

            $table->foreignId('startup_id')->on('startups')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->on('users')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->on('products')->constrained()->onDelete('cascade');  

            $table->string('type')->nullable(); // Type of activity (e.g., 'hourly', 'batch', 'change-over')

            $table->boolean('fe_front')->default(false); // Front verification for FE
            $table->boolean('fe_middle')->default(false); // Middle verification for FE
            $table->boolean('fe_back')->default(false); // Back verification for FE

            $table->boolean('non_fe_front')->default(false); // Front verification for non-FE
            $table->boolean('non_fe_middle')->default(false); // Middle verification for non-FE
            $table->boolean('non_fe_back')->default(false); // Back verification for non-FE

            $table->boolean('ss_front')->default(false); // Front verification for SS
            $table->boolean('ss_middle')->default(false); // Middle verification for SS
            $table->boolean('ss_back')->default(false); // Back verification for SS

            $table->double('qty', 13, 2)->default(0);
            $table->double('ng_qty', 13, 2)->default(0);
            $table->double('recheck_qty', 13, 2)->default(0);

            $table->tinyInteger('status')->default(0); // 0: failed, 1: in progress, 2: completed, 3: missed

            $table->text('remarks')->nullable(); // Additional remarks for the activity

            $table->timestamps();

            $table->foreign('foreman_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
