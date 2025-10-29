<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\RekeningAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Show payment upload page
     */
    public function uploadForm($pesananId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $pesanan = Pesanan::with(['detailPesanan.produk', 'pembayaran'])
            ->where('id', $pesananId)
            ->where('customer_id', Auth::id())
            ->firstOrFail();

        $rekeningAdmin = RekeningAdmin::where('aktif', true)->get();

        return view('customer.payment.upload', compact('pesanan', 'rekeningAdmin'));
    }

    /**
     * Process payment upload
     */
    public function upload(Request $request, $pesananId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $pesanan = Pesanan::where('id', $pesananId)
            ->where('customer_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'rekening_admin_id' => ['required', 'exists:rekening_admin,id'],
        ]);

        // Check if payment already exists
        $existingPayment = Pembayaran::where('pesanan_id', $pesananId)->first();
        if ($existingPayment) {
            return back()->with('error', 'Bukti pembayaran sudah pernah diupload untuk pesanan ini.');
        }

        try {
            // Upload bukti pembayaran
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $pesanan->kode_pesanan . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            // Create payment record
            Pembayaran::create([
                'pesanan_id' => $pesananId,
                'rekening_admin_id' => $validated['rekening_admin_id'],
                'jenis_pembayaran' => 'produk',
                'jumlah_pembayaran' => $pesanan->total_keseluruhan,
                'status_pembayaran' => 'menunggu_konfirmasi',
                'metode_pembayaran' => 'Transfer Bank',
                'bukti_pembayaran' => $path,
                'tanggal_upload_bukti' => now(),
            ]);

            // Update order status
            $pesanan->update([
                'status_pesanan' => 'menunggu_konfirmasi_pembayaran'
            ]);

            return redirect()->route('customer.orders.show', $pesanan->id)
                           ->with('success', 'Bukti pembayaran berhasil diupload! Pesanan Anda sedang menunggu konfirmasi admin.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengupload bukti pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Show payment confirmation details
     */
    public function confirmation($pesananId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $pesanan = Pesanan::with(['detailPesanan.produk.gambarUtama', 'pembayaran.rekeningAdmin'])
            ->where('id', $pesananId)
            ->where('customer_id', Auth::id())
            ->firstOrFail();

        return view('customer.payment.confirmation', compact('pesanan'));
    }
}