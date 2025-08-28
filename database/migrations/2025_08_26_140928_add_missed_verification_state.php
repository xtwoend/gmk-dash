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
        Schema::table('activities', function (Blueprint $table) {
            $table->tinyInteger('missed_verification_state')->nullable()->default(null)->after('type'); // 1: sudah di beritahu ke atasan, 2: sudah test piece, 3: sudah di cek kembali productnya
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('missed_verification_state');
        });
    }
};
