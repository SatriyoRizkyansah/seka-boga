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
            // Shipping information
            $table->string('nama_penerima')->after('total_amount');
            $table->string('nomor_telepon_penerima', 20)->after('nama_penerima');
            $table->text('alamat_pengiriman')->after('nomor_telepon_penerima');
            $table->string('kota_pengiriman', 100)->after('alamat_pengiriman');
            $table->string('provinsi_pengiriman', 100)->after('kota_pengiriman');
            $table->string('kode_pos_pengiriman', 10)->after('provinsi_pengiriman');
            
            // Event information
            $table->date('tanggal_acara')->after('kode_pos_pengiriman');
            $table->string('waktu_acara', 20)->after('tanggal_acara');
            
            // Payment information
            $table->string('metode_pembayaran', 50)->after('waktu_acara');
            $table->foreignUuid('rekening_admin_id')->nullable()->after('metode_pembayaran')->constrained('rekening_admin');
            
            // Payment proof
            $table->string('bukti_transfer')->nullable()->after('rekening_admin_id');
            $table->string('nama_pengirim')->nullable()->after('bukti_transfer');
            $table->date('tanggal_transfer')->nullable()->after('nama_pengirim');
            $table->decimal('jumlah_transfer', 15, 2)->nullable()->after('tanggal_transfer');
            $table->string('bank_pengirim', 100)->nullable()->after('jumlah_transfer');
            $table->string('nomor_rekening_pengirim', 50)->nullable()->after('bank_pengirim');
            $table->text('catatan_pembayaran')->nullable()->after('nomor_rekening_pengirim');
            $table->timestamp('tanggal_upload_bukti')->nullable()->after('catatan_pembayaran');
            
            // Additional timestamps
            $table->timestamp('tanggal_dibatalkan')->nullable()->after('tanggal_upload_bukti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropForeign(['rekening_admin_id']);
            $table->dropColumn([
                'nama_penerima',
                'nomor_telepon_penerima',
                'alamat_pengiriman',
                'kota_pengiriman',
                'provinsi_pengiriman',
                'kode_pos_pengiriman',
                'tanggal_acara',
                'waktu_acara',
                'metode_pembayaran',
                'rekening_admin_id',
                'bukti_transfer',
                'nama_pengirim',
                'tanggal_transfer',
                'jumlah_transfer',
                'bank_pengirim',
                'nomor_rekening_pengirim',
                'catatan_pembayaran',
                'tanggal_upload_bukti',
                'tanggal_dibatalkan'
            ]);
        });
    }
};
