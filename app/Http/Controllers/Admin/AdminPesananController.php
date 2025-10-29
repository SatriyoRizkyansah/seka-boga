<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_konfirmasi_pembayaran' => 'Menunggu Konfirmasi Pembayaran',
            'pembayaran_dikonfirmasi' => 'Pembayaran Dikonfirmasi',
            'diproses' => 'Diproses',
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
            'pembayaran.rekeningAdmin'
        ])->findOrFail($id);
        
        return view('admin.pesanan.show', compact('pesanan'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status_pesanan' => 'required|in:menunggu_pembayaran,menunggu_konfirmasi_pembayaran,pembayaran_dikonfirmasi,diproses,dikirim,selesai,dibatalkan'
        ]);
        
        $pesanan = Pesanan::findOrFail($id);
        
        $pesanan->update([
            'status_pesanan' => $validated['status_pesanan']
        ]);
        
        return back()->with('success', 'Status pesanan berhasil diupdate!');
    }
    
    public function confirmPayment(Request $request, $id)
    {
        $pesanan = Pesanan::with('pembayaran')->findOrFail($id);
        
        if (!$pesanan->pembayaran) {
            return back()->with('error', 'Tidak ada bukti pembayaran untuk pesanan ini!');
        }
        
        $validated = $request->validate([
            'status' => 'required|in:dikonfirmasi,ditolak'
        ]);
        
        $pesanan->pembayaran->update([
            'status_pembayaran' => $validated['status'],
            'tanggal_konfirmasi' => now()
        ]);
        
        if ($validated['status'] == 'dikonfirmasi') {
            $pesanan->update(['status_pesanan' => 'pembayaran_dikonfirmasi']);
        } else {
            $pesanan->update(['status_pesanan' => 'menunggu_pembayaran']);
        }
        
        return back()->with('success', 'Status pembayaran berhasil diupdate!');
    }
}