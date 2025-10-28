<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';

    protected $fillable = [
        'customer_id',
        'produk_id',
        'jumlah',
        'catatan',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Helper methods
    public function subtotal()
    {
        return $this->produk->harga * $this->jumlah;
    }

    public function formatSubtotal()
    {
        return 'Rp ' . number_format($this->subtotal(), 0, ',', '.');
    }
}
