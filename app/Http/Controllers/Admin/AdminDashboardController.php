<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard
        $stats = [
            'total_penjualan' => Pesanan::where('status_pesanan', 'selesai')->sum('total_keseluruhan') ?? 0,
            'pesanan_bulan_ini' => Pesanan::whereMonth('created_at', now()->month)->count(),
            'menu_aktif' => Produk::where('aktif', true)->count(),
            'total_pelanggan' => User::where('role', 'customer')->count(),
        ];

        // Pesanan terbaru
        $pesanan_terbaru = Pesanan::with(['user', 'detailPesanan.produk'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Menu populer (berdasarkan jumlah pesanan)
        $menu_populer = Produk::with(['gambar'])
            ->withCount('detailPesanan')
            ->orderBy('detail_pesanan_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pesanan_terbaru', 'menu_populer'));
    }
}
