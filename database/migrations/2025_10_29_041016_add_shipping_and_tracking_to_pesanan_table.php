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
        Schema::table('pesanan', function (Blueprint $table) {
            // Only add fields we actually need
            $table->string('nama_jasa_pengiriman')->nullable()->after('total_keseluruhan');
            $table->string('nomor_resi')->nullable()->after('nama_jasa_pengiriman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn([
                'nama_jasa_pengiriman',
                'nomor_resi'
            ]);
        });
    }
};
