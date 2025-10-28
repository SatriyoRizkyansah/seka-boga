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
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->string('nama_jasa_pengiriman')->nullable(); // JNE, JNT, SiCepat, dll
            $table->string('nomor_resi')->nullable();
            $table->enum('status_pengiriman', [
                'belum_diserahkan',
                'sudah_diserahkan_jasa_kirim'
            ])->default('belum_diserahkan');
            $table->text('catatan_pengiriman')->nullable();
            $table->datetime('tanggal_kirim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
