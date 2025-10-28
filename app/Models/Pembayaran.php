<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuidPrimaryKey;

class Pembayaran extends Model
{
    use HasFactory, HasUuidPrimaryKey;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pesanan_id',
        'rekening_admin_id',
        'jenis_pembayaran',
        'jumlah_pembayaran',
        'status_pembayaran',
        'metode_pembayaran',
        'bukti_pembayaran',
        'catatan_pembayaran',
        'tanggal_upload_bukti',
        'tanggal_konfirmasi',
        'admin_konfirmasi_id',
        'alasan_penolakan',
    ];

    protected $casts = [
        'jumlah_pembayaran' => 'decimal:2',
        'tanggal_upload_bukti' => 'datetime',
        'tanggal_konfirmasi' => 'datetime',
    ];

    // Relationships
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function rekeningAdmin()
    {
        return $this->belongsTo(RekeningAdmin::class);
    }

    public function adminKonfirmasi()
    {
        return $this->belongsTo(User::class, 'admin_konfirmasi_id');
    }

    // Helper methods
    public function formatJumlahPembayaran()
    {
        return 'Rp ' . number_format($this->jumlah_pembayaran, 0, ',', '.');
    }
}
