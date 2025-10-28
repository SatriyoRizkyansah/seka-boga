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
        Schema::create('keranjang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('produk_id')->constrained('produk')->onDelete('cascade');
            $table->integer('jumlah');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Ensure unique combination of customer and product
            $table->unique(['customer_id', 'produk_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
