<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Nasi Box',
                'deskripsi' => 'Paket nasi box praktis untuk berbagai acara',
                'aktif' => true,
            ],
            [
                'nama_kategori' => 'Catering Premium',
                'deskripsi' => 'Paket catering premium untuk acara khusus',
                'aktif' => true,
            ],
            [
                'nama_kategori' => 'Snack Box',
                'deskripsi' => 'Beragam snack box untuk meeting dan acara ringan',
                'aktif' => true,
            ],
            [
                'nama_kategori' => 'Paket Prasmanan',
                'deskripsi' => 'Paket prasmanan untuk acara besar',
                'aktif' => true,
            ],
            [
                'nama_kategori' => 'Menu Tradisional',
                'deskripsi' => 'Menu makanan tradisional Indonesia',
                'aktif' => true,
            ],
        ];

        foreach ($kategoris as $kategori) {
            \App\Models\KategoriProduk::create($kategori);
        }
    }
}
