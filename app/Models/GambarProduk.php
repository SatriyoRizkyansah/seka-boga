<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GambarProduk extends Model
{
    use HasFactory;

    protected $table = 'gambar_produk';

    protected $fillable = [
        'produk_id',
        'nama_file',
        'path_gambar',
        'gambar_utama',
        'urutan',
    ];

    protected $casts = [
        'gambar_utama' => 'boolean',
    ];

    // Relationships
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
