<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuidPrimaryKey;

class Produk extends Model
{
    use HasFactory, HasUuidPrimaryKey;

    protected $table = 'produk';

    protected $fillable = [
        'kategori_produk_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'minimal_pemesanan',
        'satuan',
        'bahan_utama',
        'catatan_khusus',
        'tersedia',
        'aktif',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'tersedia' => 'boolean',
        'aktif' => 'boolean',
    ];

    // Relationships
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_produk_id');
    }

    public function gambarProduk()
    {
        return $this->hasMany(GambarProduk::class);
    }

    public function gambarUtama()
    {
        return $this->hasOne(GambarProduk::class)->where('gambar_utama', true);
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    // Helper methods
    public function formatHarga()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
