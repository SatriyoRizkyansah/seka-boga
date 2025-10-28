<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekeningAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rekenings = [
            [
                'nama_bank' => 'BCA',
                'nomor_rekening' => '1234567890',
                'nama_pemilik_rekening' => 'Seka Boga Catering',
                'jenis_rekening' => 'utama',
                'aktif' => true,
                'catatan' => 'Rekening utama untuk pembayaran',
            ],
            [
                'nama_bank' => 'Mandiri',
                'nomor_rekening' => '0987654321',
                'nama_pemilik_rekening' => 'Seka Boga Catering',
                'jenis_rekening' => 'cadangan',
                'aktif' => true,
                'catatan' => 'Rekening cadangan untuk pembayaran',
            ],
        ];

        foreach ($rekenings as $rekening) {
            \App\Models\RekeningAdmin::create($rekening);
        }
    }
}
