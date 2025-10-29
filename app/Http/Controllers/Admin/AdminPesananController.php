<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminPesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Pesanan::with(['customer', 'detailPesanan', 'pembayaran'])
            ->orderBy('tanggal_pesanan', 'desc');
            
        if ($status != 'all') {
            $query->where('status_pesanan', $status);
        }
        
        $pesanan = $query->paginate(10);
        
        $statusList = [
            'all' => 'Semua',
            'menunggu_pembayaran_produk' => 'Menunggu Pembayaran Produk',
            'menunggu_konfirmasi_pembayaran_produk' => 'Menunggu Konfirmasi Pembayaran Produk',
            'pembayaran_produk_dikonfirmasi' => 'Pembayaran Produk Dikonfirmasi',
            'menunggu_input_ongkir' => 'Menunggu Input Ongkir',
            'menunggu_pembayaran_ongkir' => 'Menunggu Pembayaran Ongkir',
            'menunggu_konfirmasi_pembayaran_ongkir' => 'Menunggu Konfirmasi Pembayaran Ongkir',
            'pembayaran_ongkir_dikonfirmasi' => 'Pembayaran Ongkir Dikonfirmasi',
            'diproses' => 'Diproses',
            'menunggu_input_resi' => 'Menunggu Input Resi',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];
        
        return view('admin.pesanan.index', compact('pesanan', 'statusList', 'status'));
    }
    
    public function show($id)
    {
        $pesanan = Pesanan::with([
            'customer', 
            'detailPesanan.produk.gambarUtama', 
            'semuaPembayaran.rekeningAdmin'
        ])->findOrFail($id);
        
        return view('admin.pesanan.show', compact('pesanan'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status_pesanan' => 'required|in:menunggu_pembayaran_produk,menunggu_konfirmasi_pembayaran_produk,pembayaran_produk_dikonfirmasi,menunggu_input_ongkir,menunggu_pembayaran_ongkir,menunggu_konfirmasi_pembayaran_ongkir,pembayaran_ongkir_dikonfirmasi,diproses,menunggu_input_resi,dikirim,selesai,dibatalkan'
        ]);
        
        $pesanan = Pesanan::findOrFail($id);
        
        $pesanan->update([
            'status_pesanan' => $validated['status_pesanan']
        ]);
        
        return back()->with('success', 'Status pesanan berhasil diupdate!');
    }
    
    public function inputShippingCost(Request $request, $id)
    {
        $validated = $request->validate([
            'biaya_ongkir' => 'required|numeric|min:0'
        ]);
        
        $pesanan = Pesanan::findOrFail($id);
        
        $pesanan->update([
            'biaya_ongkir' => $validated['biaya_ongkir'],
            'status_pesanan' => 'menunggu_pembayaran_ongkir'
        ]);
        
        // Create pembayaran ongkir record
        Pembayaran::create([
            'pesanan_id' => $pesanan->id,
            'jenis_pembayaran' => 'ongkir',
            'jumlah_pembayaran' => $validated['biaya_ongkir'],
            'status_pembayaran' => 'menunggu_upload_bukti'
        ]);
        
        return back()->with('success', 'Biaya ongkir berhasil ditambahkan!');
    }
    
    public function confirmPayment(Request $request, $id)
    {
        $validated = $request->validate([
            'jenis_pembayaran' => 'required|in:produk,ongkir',
            'status' => 'required|in:dikonfirmasi,ditolak'
        ]);
        
        $pesanan = Pesanan::findOrFail($id);
        $pembayaran = $pesanan->semuaPembayaran()
            ->where('jenis_pembayaran', $validated['jenis_pembayaran'])
            ->first();
            
        if (!$pembayaran) {
            return back()->with('error', 'Tidak ada bukti pembayaran untuk jenis pembayaran ini!');
        }
        
        $pembayaran->update([
            'status_pembayaran' => $validated['status'],
            'tanggal_konfirmasi' => now(),
            'admin_konfirmasi_id' => Auth::id()
        ]);
        
        // Update status pesanan berdasarkan jenis pembayaran dengan alur otomatis
        if ($validated['status'] == 'dikonfirmasi') {
            if ($validated['jenis_pembayaran'] == 'produk') {
                // Setelah pembayaran produk dikonfirmasi, langsung ke input ongkir
                $pesanan->update(['status_pesanan' => 'menunggu_input_ongkir']);
            } elseif ($validated['jenis_pembayaran'] == 'ongkir') {
                // Setelah pembayaran ongkir dikonfirmasi, langsung ke menunggu input resi
                $pesanan->update(['status_pesanan' => 'menunggu_input_resi']);
            }
        } else {
            // Jika ditolak, kembali ke status menunggu pembayaran
            if ($validated['jenis_pembayaran'] == 'produk') {
                $pesanan->update(['status_pesanan' => 'menunggu_pembayaran_produk']);
            } elseif ($validated['jenis_pembayaran'] == 'ongkir') {
                $pesanan->update(['status_pesanan' => 'menunggu_pembayaran_ongkir']);
            }
        }
        
        return back()->with('success', 'Status pembayaran berhasil diupdate!');
    }
    
    public function inputTrackingNumber(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_jasa_pengiriman' => 'required|string|max:255',
            'nomor_resi' => 'required|string|max:255'
        ]);
        
        $pesanan = Pesanan::findOrFail($id);
        
        $pesanan->update([
            'nama_jasa_pengiriman' => $validated['nama_jasa_pengiriman'],
            'nomor_resi' => $validated['nomor_resi'],
            'status_pesanan' => 'dikirim'
        ]);
        
        return back()->with('success', 'Nomor resi berhasil ditambahkan dan pesanan dalam status dikirim!');
    }
}