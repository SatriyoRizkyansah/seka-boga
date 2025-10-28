<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Seka Boga',
            'email' => 'admin@sekaboga.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'nomor_telepon' => '081234567890',
            'alamat_lengkap' => 'Jl. Admin No. 1, Jakarta',
            'kota' => 'Jakarta',
            'provinsi' => 'DKI Jakarta',
            'kode_pos' => '12345',
            'aktif' => true,
        ]);

        // Create Sample Customer
        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@example.com',
            'password' => bcrypt('customer123'),
            'role' => 'customer',
            'nomor_telepon' => '081234567891',
            'alamat_lengkap' => 'Jl. Customer No. 2, Jakarta',
            'kota' => 'Jakarta',
            'provinsi' => 'DKI Jakarta',
            'kode_pos' => '12346',
            'aktif' => true,
        ]);

        // Call other seeders
        $this->call([
            RekeningAdminSeeder::class,
            KategoriProdukSeeder::class,
            ProdukSeeder::class,
        ]);
    }
}
