<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidPrimaryKey;

class Kategori extends Model
{
    use HasUuidPrimaryKey;

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

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Relasi dengan Produk
     */
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_produk_id');
    }
}