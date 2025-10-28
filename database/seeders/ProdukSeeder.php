<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get kategori IDs
        $nasiBox = \App\Models\KategoriProduk::where('nama_kategori', 'Nasi Box')->first();
        $cateringPremium = \App\Models\KategoriProduk::where('nama_kategori', 'Catering Premium')->first();
        $snackBox = \App\Models\KategoriProduk::where('nama_kategori', 'Snack Box')->first();
        
        $produks = [
            // Nasi Box
            [
                'kategori_produk_id' => $nasiBox->id,
                'nama_produk' => 'Nasi Box Ayam Geprek',
                'deskripsi' => 'Nasi putih dengan ayam geprek pedas, lalapan, dan sambal',
                'harga' => 15000,
                'stok' => 100,
                'minimal_pemesanan' => 10,
                'satuan' => 'box',
                'bahan_utama' => 'Ayam, nasi, sambal, lalapan',
                'tersedia' => true,
                'aktif' => true,
            ],
            [
                'kategori_produk_id' => $nasiBox->id,
                'nama_produk' => 'Nasi Box Ayam Teriyaki',
                'deskripsi' => 'Nasi putih dengan ayam teriyaki, sayuran, dan sup',
                'harga' => 18000,
                'stok' => 100,
                'minimal_pemesanan' => 10,
                'satuan' => 'box',
                'bahan_utama' => 'Ayam, nasi, saus teriyaki, sayuran',
                'tersedia' => true,
                'aktif' => true,
            ],
            
            // Catering Premium
            [
                'kategori_produk_id' => $cateringPremium->id,
                'nama_produk' => 'Paket Catering Premium A',
                'deskripsi' => 'Paket lengkap dengan nasi, ayam bakar, sayur asem, kerupuk',
                'harga' => 25000,
                'stok' => 50,
                'minimal_pemesanan' => 20,
                'satuan' => 'porsi',
                'bahan_utama' => 'Ayam bakar, nasi, sayur asem, kerupuk',
                'tersedia' => true,
                'aktif' => true,
            ],
            [
                'kategori_produk_id' => $cateringPremium->id,
                'nama_produk' => 'Paket Catering Premium B',
                'deskripsi' => 'Paket dengan ikan bakar, nasi, gado-gado, keripik',
                'harga' => 28000,
                'stok' => 50,
                'minimal_pemesanan' => 20,
                'satuan' => 'porsi',
                'bahan_utama' => 'Ikan bakar, nasi, gado-gado, keripik',
                'tersedia' => true,
                'aktif' => true,
            ],
            
            // Snack Box
            [
                'kategori_produk_id' => $snackBox->id,
                'nama_produk' => 'Snack Box Deluxe',
                'deskripsi' => 'Snack box berisi roti, kue, buah, dan minuman',
                'harga' => 12000,
                'stok' => 200,
                'minimal_pemesanan' => 5,
                'satuan' => 'box',
                'bahan_utama' => 'Roti, kue, buah segar, minuman',
                'tersedia' => true,
                'aktif' => true,
            ],
            [
                'kategori_produk_id' => $snackBox->id,
                'nama_produk' => 'Snack Box Standard',
                'deskripsi' => 'Snack box ekonomis dengan roti dan kue',
                'harga' => 8000,
                'stok' => 200,
                'minimal_pemesanan' => 5,
                'satuan' => 'box',
                'bahan_utama' => 'Roti, kue kering, minuman',
                'tersedia' => true,
                'aktif' => true,
            ],
        ];

        foreach ($produks as $produk) {
            \App\Models\Produk::create($produk);
        }
    }
}
