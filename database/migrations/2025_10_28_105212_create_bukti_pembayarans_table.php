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
        Schema::create('bukti_pembayarans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->string('file_path');
            $table->string('nama_pengirim');
            $table->string('bank_pengirim');
            $table->decimal('jumlah_transfer', 12, 2);
            $table->date('tanggal_transfer');
            $table->text('catatan_pembayaran')->nullable();
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->uuid('verified_by')->nullable();
            $table->timestamps();
            
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_pembayarans');
    }
};
