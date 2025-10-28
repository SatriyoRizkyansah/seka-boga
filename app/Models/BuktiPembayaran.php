<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuidPrimaryKey;

class BuktiPembayaran extends Model
{
    use HasUuidPrimaryKey;

    protected $fillable = [
        'pesanan_id',
        'file_path',
        'nama_pengirim',
        'bank_pengirim',
        'jumlah_transfer',
        'tanggal_transfer',
        'catatan_pembayaran',
        'status_verifikasi',
        'catatan_admin',
        'tanggal_verifikasi',
        'verified_by',
    ];

    protected $casts = [
        'tanggal_transfer' => 'date',
        'tanggal_verifikasi' => 'datetime',
        'jumlah_transfer' => 'decimal:2',
    ];

    /**
     * Get the pesanan that owns the bukti pembayaran
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * Get the user who verified this payment
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
