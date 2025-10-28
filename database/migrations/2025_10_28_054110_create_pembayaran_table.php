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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->enum('jenis_pembayaran', ['produk', 'ongkir']);
            $table->decimal('jumlah_pembayaran', 12, 2);
            $table->enum('status_pembayaran', [
                'menunggu_upload_bukti',
                'menunggu_konfirmasi',
                'dikonfirmasi',
                'ditolak'
            ])->default('menunggu_upload_bukti');
            $table->string('metode_pembayaran')->nullable(); // Transfer Bank, e-wallet, dll
            $table->string('bukti_pembayaran')->nullable(); // path file
            $table->text('catatan_pembayaran')->nullable();
            $table->datetime('tanggal_upload_bukti')->nullable();
            $table->datetime('tanggal_konfirmasi')->nullable();
            $table->foreignUuid('admin_konfirmasi_id')->nullable()->constrained('users');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
