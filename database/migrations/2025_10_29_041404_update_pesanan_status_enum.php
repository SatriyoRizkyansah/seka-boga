<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, add new enum values to existing ones
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status_pesanan ENUM(
            'menunggu_pembayaran',
            'menunggu_konfirmasi_pembayaran',
            'pembayaran_dikonfirmasi',
            'menunggu_pembayaran_ongkir',
            'menunggu_konfirmasi_ongkir',
            'diproses',
            'dikirim',
            'selesai',
            'dibatalkan',
            'menunggu_pembayaran_produk',
            'menunggu_konfirmasi_pembayaran_produk', 
            'pembayaran_produk_dikonfirmasi',
            'menunggu_input_ongkir',
            'menunggu_konfirmasi_pembayaran_ongkir',
            'pembayaran_ongkir_dikonfirmasi',
            'menunggu_input_resi'
        ) DEFAULT 'menunggu_pembayaran'");
        
        // Then update existing data to new values
        DB::table('pesanan')->where('status_pesanan', 'menunggu_pembayaran')->update(['status_pesanan' => 'menunggu_pembayaran_produk']);
        DB::table('pesanan')->where('status_pesanan', 'menunggu_konfirmasi_pembayaran')->update(['status_pesanan' => 'menunggu_konfirmasi_pembayaran_produk']);
        DB::table('pesanan')->where('status_pesanan', 'pembayaran_dikonfirmasi')->update(['status_pesanan' => 'pembayaran_produk_dikonfirmasi']);
        
        // Finally, remove old enum values and set new default
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status_pesanan ENUM(
            'menunggu_pembayaran_produk',
            'menunggu_konfirmasi_pembayaran_produk', 
            'pembayaran_produk_dikonfirmasi',
            'menunggu_input_ongkir',
            'menunggu_pembayaran_ongkir',
            'menunggu_konfirmasi_pembayaran_ongkir',
            'pembayaran_ongkir_dikonfirmasi',
            'diproses',
            'menunggu_input_resi',
            'dikirim',
            'selesai',
            'dibatalkan'
        ) DEFAULT 'menunggu_pembayaran_produk'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pesanan MODIFY COLUMN status_pesanan ENUM(
            'menunggu_pembayaran',
            'menunggu_konfirmasi_pembayaran',
            'pembayaran_dikonfirmasi',
            'menunggu_pembayaran_ongkir',
            'menunggu_konfirmasi_ongkir',
            'diproses',
            'dikirim',
            'selesai',
            'dibatalkan'
        ) DEFAULT 'menunggu_pembayaran'");
    }
};
