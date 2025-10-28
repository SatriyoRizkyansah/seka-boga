<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nomor_telepon',
        'alamat_lengkap',
        'kota',
        'provinsi',
        'kode_pos',
        'aktif',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'aktif' => 'boolean',
        ];
    }

    // Relationships untuk Customer
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'customer_id');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'customer_id');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'customer_id');
    }

    // Relationships untuk Admin
    public function pembayaranYangDikonfirmasi()
    {
        return $this->hasMany(Pembayaran::class, 'admin_konfirmasi_id');
    }

    public function laporanYangDitangani()
    {
        return $this->hasMany(Laporan::class, 'admin_penanganan_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}
