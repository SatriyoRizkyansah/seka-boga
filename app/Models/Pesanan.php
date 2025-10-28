<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'kode_pesanan',
        'customer_id',
        'status_pesanan',
        'total_harga_produk',
        'biaya_ongkir',
        'total_keseluruhan',
        'alamat_pengiriman',
        'kota_pengiriman',
        'provinsi_pengiriman',
        'kode_pos_pengiriman',
        'nomor_telepon_penerima',
        'nama_penerima',
        'catatan_pesanan',
        'tanggal_pesanan',
        'tanggal_dibutuhkan',
    ];

    protected $casts = [
        'total_harga_produk' => 'decimal:2',
        'biaya_ongkir' => 'decimal:2',
        'total_keseluruhan' => 'decimal:2',
        'tanggal_pesanan' => 'datetime',
        'tanggal_dibutuhkan' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }

    // Helper methods
    public function formatTotalHargaProduk()
    {
        return 'Rp ' . number_format($this->total_harga_produk, 0, ',', '.');
    }

    public function formatBiayaOngkir()
    {
        return $this->biaya_ongkir ? 'Rp ' . number_format($this->biaya_ongkir, 0, ',', '.') : 'Belum ditentukan';
    }

    public function formatTotalKeseluruhan()
    {
        return $this->total_keseluruhan ? 'Rp ' . number_format($this->total_keseluruhan, 0, ',', '.') : 'Belum ditentukan';
    }

    public function formatHarga()
    {
        return $this->total_keseluruhan ? 'Rp ' . number_format($this->total_keseluruhan, 0, ',', '.') : 'Rp ' . number_format($this->total_harga_produk, 0, ',', '.');
    }

    public static function generateKodePesanan()
    {
        $today = Carbon::now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', Carbon::today())
                        ->orderBy('id', 'desc')
                        ->first();
        
        $sequence = $lastOrder ? (int)substr($lastOrder->kode_pesanan, -3) + 1 : 1;
        
        return 'ORD-' . $today . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }
}
