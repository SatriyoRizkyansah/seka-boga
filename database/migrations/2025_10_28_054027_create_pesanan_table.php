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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_pesanan', 20)->unique();
            $table->foreignUuid('customer_id')->constrained('users')->onDelete('cascade');
            $table->enum('status_pesanan', [
                'menunggu_pembayaran', 
                'menunggu_konfirmasi_pembayaran', 
                'pembayaran_dikonfirmasi',
                'menunggu_pembayaran_ongkir',
                'menunggu_konfirmasi_ongkir',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan'
            ])->default('menunggu_pembayaran');
            $table->decimal('total_harga_produk', 12, 2);
            $table->decimal('biaya_ongkir', 10, 2)->nullable();
            $table->decimal('total_keseluruhan', 12, 2)->nullable();
            $table->text('alamat_pengiriman');
            $table->string('kota_pengiriman');
            $table->string('provinsi_pengiriman');
            $table->string('kode_pos_pengiriman');
            $table->string('nomor_telepon_penerima');
            $table->string('nama_penerima');
            $table->text('catatan_pesanan')->nullable();
            $table->datetime('tanggal_pesanan');
            $table->datetime('tanggal_dibutuhkan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
