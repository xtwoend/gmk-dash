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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('startup_id')->constrained()->onDelete('cascade');
            $table->string('por_id'); // Production Order Reference
            $table->string('item_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('batch_number')->nullable();
            $table->json('product_specifications')->nullable(); // Product specs as JSON
            $table->enum('product_type', ['pcs', 'gram']);
            $table->integer('target_quantity')->nullable();
            $table->string('unit')->default('pcs'); // Default unit is 'pcs' 'kg', 'gram'
            $table->string('prod_pool_id')->nullable();
            $table->timestamp('schedule_date')->nullable();
            $table->timestamp('scanned_at')->nullable();
            $table->timestamps();

            $table->index(['startup_id', 'por_id']);
            $table->index('batch_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
