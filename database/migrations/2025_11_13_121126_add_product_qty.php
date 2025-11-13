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
        Schema::table('products', function (Blueprint $table) {
            $table->datetime('estimated_date')->nullable()->after('schedule_date');
            $table->integer('ng_quantity')->default(0)->after('target_quantity');
            $table->integer('ok_quantity')->default(0)->after('ng_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('estimated_date');
            $table->dropColumn('ng_quantity');
            $table->dropColumn('ok_quantity');
        }); 
    }
};
