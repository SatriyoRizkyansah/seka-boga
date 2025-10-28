<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuidPrimaryKey;

class KategoriProduk extends Model
{
    use HasFactory, HasUuidPrimaryKey;

    protected $table = 'kategori_produk';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'gambar_kategori',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    // Relationships
    public function produk()
    {
        return $this->hasMany(Produk::class);
    }

    public function produkAktif()
    {
        return $this->hasMany(Produk::class)->where('aktif', true)->where('tersedia', true);
    }
}
