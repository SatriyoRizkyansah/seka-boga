<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';

    protected $fillable = [
        'pesanan_id',
        'nama_jasa_pengiriman',
        'nomor_resi',
        'status_pengiriman',
        'catatan_pengiriman',
        'tanggal_kirim',
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime',
    ];

    // Relationships
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
