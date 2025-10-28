<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'pesanan_id',
        'customer_id',
        'jenis_laporan',
        'judul_laporan',
        'isi_laporan',
        'rating',
        'status_laporan',
        'tanggapan_admin',
        'admin_penanganan_id',
        'tanggal_tanggapan',
    ];

    protected $casts = [
        'tanggal_tanggapan' => 'datetime',
    ];

    // Relationships
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function adminPenanganan()
    {
        return $this->belongsTo(User::class, 'admin_penanganan_id');
    }
}
