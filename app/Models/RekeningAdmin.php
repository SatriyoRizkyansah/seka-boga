<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuidPrimaryKey;

class RekeningAdmin extends Model
{
    use HasFactory, HasUuidPrimaryKey;

    protected $table = 'rekening_admin';

    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'jenis_rekening',
        'aktif',
        'catatan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    // Relationships
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeUtama($query)
    {
        return $query->where('jenis_rekening', 'utama');
    }
}
