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
        Schema::create('laporan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->foreignUuid('customer_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis_laporan', ['komplain', 'saran', 'review']);
            $table->string('judul_laporan');
            $table->text('isi_laporan');
            $table->integer('rating')->nullable(); // 1-5 untuk review
            $table->enum('status_laporan', [
                'baru',
                'sedang_ditangani',
                'selesai',
                'ditutup'
            ])->default('baru');
            $table->text('tanggapan_admin')->nullable();
            $table->foreignUuid('admin_penanganan_id')->nullable()->constrained('users');
            $table->datetime('tanggal_tanggapan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
