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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_produk_id')->constrained('kategori_produk')->onDelete('cascade');
            $table->string('nama_produk');
            $table->text('deskripsi');
            $table->decimal('harga', 10, 2);
            $table->integer('stok')->default(0);
            $table->integer('minimal_pemesanan')->default(1);
            $table->string('satuan')->default('porsi'); // porsi, box, kg, dll
            $table->text('bahan_utama')->nullable();
            $table->text('catatan_khusus')->nullable();
            $table->boolean('tersedia')->default(true);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
