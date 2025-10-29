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
    public function uploadForm($pesananId, $type = 'produk')
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $pesanan = Pesanan::with(['detailPesanan.produk', 'pembayaran'])
            ->where('id', $pesananId)
            ->where('customer_id', Auth::id())
            ->firstOrFail();

        $rekeningAdmin = RekeningAdmin::where('aktif', true)->get();

        // Validate payment type
        if (!in_array($type, ['produk', 'ongkir'])) {
            return back()->with('error', 'Jenis pembayaran tidak valid.');
        }

        // Check if this type of payment already exists and has been uploaded
        $existingPayment = Pembayaran::where('pesanan_id', $pesananId)
                                   ->where('jenis_pembayaran', $type)
                                   ->whereNotNull('bukti_pembayaran')
                                   ->first();
        
        if ($existingPayment) {
            return back()->with('error', 'Bukti pembayaran ' . ($type == 'produk' ? 'produk' : 'ongkir') . ' sudah pernah diupload untuk pesanan ini.');
        }

        // Determine amount based on payment type
        $amount = $type == 'produk' ? $pesanan->total_keseluruhan : $pesanan->biaya_ongkir;
        if ($type == 'ongkir' && !$pesanan->biaya_ongkir) {
            return back()->with('error', 'Biaya ongkir belum ditentukan oleh admin.');
        }

        return view('customer.payment.upload', compact('pesanan', 'rekeningAdmin', 'type', 'amount'));
    }

    /**
     * Process payment upload
     */
    public function upload(Request $request, $pesananId, $type = 'produk')
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

        // Validate payment type
        if (!in_array($type, ['produk', 'ongkir'])) {
            return back()->with('error', 'Jenis pembayaran tidak valid.');
        }

        // Check if this type of payment already exists and has been uploaded
        $existingPayment = Pembayaran::where('pesanan_id', $pesananId)
                                   ->where('jenis_pembayaran', $type)
                                   ->whereNotNull('bukti_pembayaran')
                                   ->first();
        if ($existingPayment) {
            return back()->with('error', 'Bukti pembayaran ' . ($type == 'produk' ? 'produk' : 'ongkir') . ' sudah pernah diupload untuk pesanan ini.');
        }

        // Determine amount and next status based on payment type
        $amount = $type == 'produk' ? $pesanan->total_keseluruhan : $pesanan->biaya_ongkir;
        $nextStatus = $type == 'produk' ? 'menunggu_konfirmasi_pembayaran_produk' : 'menunggu_konfirmasi_pembayaran_ongkir';

        if ($type == 'ongkir' && !$pesanan->biaya_ongkir) {
            return back()->with('error', 'Biaya ongkir belum ditentukan oleh admin.');
        }

        try {
            // Upload bukti pembayaran
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $pesanan->kode_pesanan . '_' . $type . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            // Check if payment record already exists (for ongkir case)
            $existingPaymentRecord = Pembayaran::where('pesanan_id', $pesananId)
                                              ->where('jenis_pembayaran', $type)
                                              ->first();

            if ($existingPaymentRecord) {
                // Update existing payment record (ongkir case)
                $existingPaymentRecord->update([
                    'rekening_admin_id' => $validated['rekening_admin_id'],
                    'status_pembayaran' => 'menunggu_konfirmasi',
                    'metode_pembayaran' => 'Transfer Bank',
                    'bukti_pembayaran' => $path,
                    'tanggal_upload_bukti' => now(),
                ]);
            } else {
                // Create new payment record (produk case)
                Pembayaran::create([
                    'pesanan_id' => $pesananId,
                    'rekening_admin_id' => $validated['rekening_admin_id'],
                    'jenis_pembayaran' => $type,
                    'jumlah_pembayaran' => $amount,
                    'status_pembayaran' => 'menunggu_konfirmasi',
                    'metode_pembayaran' => 'Transfer Bank',
                    'bukti_pembayaran' => $path,
                    'tanggal_upload_bukti' => now(),
                ]);
            }

            // Update order status
            $pesanan->update([
                'status_pesanan' => $nextStatus
            ]);

            $successMessage = $type == 'produk' 
                ? 'Bukti pembayaran produk berhasil diupload! Pesanan Anda sedang menunggu konfirmasi admin.'
                : 'Bukti pembayaran ongkir berhasil diupload! Pesanan Anda sedang menunggu konfirmasi admin.';

            return redirect()->route('customer.orders.show', $pesanan->id)
                           ->with('success', $successMessage);

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