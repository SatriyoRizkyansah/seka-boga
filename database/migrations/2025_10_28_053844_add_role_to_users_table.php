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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'customer'])->default('customer')->after('email');
            $table->string('nomor_telepon')->nullable()->after('role');
            $table->text('alamat_lengkap')->nullable()->after('nomor_telepon');
            $table->string('kota')->nullable()->after('alamat_lengkap');
            $table->string('provinsi')->nullable()->after('kota');
            $table->string('kode_pos')->nullable()->after('provinsi');
            $table->boolean('aktif')->default(true)->after('kode_pos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nomor_telepon', 'alamat_lengkap', 'kota', 'provinsi', 'kode_pos', 'aktif']);
        });
    }
};
