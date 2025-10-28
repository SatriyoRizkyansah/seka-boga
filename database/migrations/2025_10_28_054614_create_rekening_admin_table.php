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
        Schema::create('rekening_admin', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_bank');
            $table->string('nomor_rekening');
            $table->string('nama_pemilik_rekening');
            $table->enum('jenis_rekening', ['utama', 'alternatif'])->default('alternatif');
            $table->boolean('aktif')->default(true);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_admin');
    }
};
