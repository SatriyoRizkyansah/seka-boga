<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\RekeningAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItems = Keranjang::with(['produk.kategori', 'produk.gambarUtama'])
            ->where('customer_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart')
                           ->with('error', 'Keranjang belanja kosong');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });

        $user = Auth::user();
        $rekeningAdmin = RekeningAdmin::where('aktif', true)->get();

        return view('customer.checkout.index', compact('cartItems', 'total', 'user', 'rekeningAdmin'));
    }

    public function store(Request $request)
    {
        Log::info('=== CHECKOUT PROCESS STARTED ===');
        Log::info('Request data: ', $request->all());

        if (!Auth::check()) {
            Log::error('User not authenticated');
            return redirect()->route('login');
        }

        // Validasi input
        $validated = $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'nomor_telepon_penerima' => 'required|string|max:20',
            'alamat_pengiriman' => 'required|string',
            'kota_pengiriman' => 'required|string|max:255',
            'provinsi_pengiriman' => 'required|string|max:255',
            'kode_pos_pengiriman' => 'required|string|max:10',
            'tanggal_acara' => 'required|date|after_or_equal:today',
            'waktu_acara' => 'required',
            'catatan_pesanan' => 'nullable|string',
        ]);

        Log::info('Validation passed');

        // Ambil item keranjang
        $cartItems = Keranjang::with('produk')
            ->where('customer_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            Log::error('Cart is empty');
            return redirect()->route('customer.cart')
                           ->with('error', 'Keranjang belanja kosong');
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });

        Log::info('Total amount calculated: ' . $totalAmount);

        DB::beginTransaction();
        try {
            // Buat pesanan
            $pesanan = Pesanan::create([
                'customer_id' => Auth::id(),
                'kode_pesanan' => $this->generateOrderNumber(),
                'tanggal_pesanan' => now(),
                'tanggal_dibutuhkan' => $validated['tanggal_acara'] . ' ' . $validated['waktu_acara'],
                'status_pesanan' => 'menunggu_pembayaran_produk',
                'total_harga_produk' => $totalAmount,
                'total_keseluruhan' => $totalAmount,
                'nama_penerima' => $validated['nama_penerima'],
                'nomor_telepon_penerima' => $validated['nomor_telepon_penerima'],
                'alamat_pengiriman' => $validated['alamat_pengiriman'],
                'kota_pengiriman' => $validated['kota_pengiriman'],
                'provinsi_pengiriman' => $validated['provinsi_pengiriman'],
                'kode_pos_pengiriman' => $validated['kode_pos_pengiriman'],
                'catatan_pesanan' => $validated['catatan_pesanan'],
            ]);

            Log::info('Order created with ID: ' . $pesanan->id);

            // Buat detail pesanan
            foreach ($cartItems as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'nama_produk' => $item->produk->nama_produk, // snapshot nama produk
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->produk->harga,
                    'subtotal' => $item->jumlah * $item->produk->harga,
                    'catatan_produk' => $item->catatan, // sesuai dengan migration
                ]);
            }

            Log::info('Order details created');

            // Hapus keranjang
            Keranjang::where('customer_id', Auth::id())->delete();

            Log::info('Cart cleared');

            DB::commit();

            Log::info('Transaction committed successfully');
            Log::info('Redirecting to payment page for order: ' . $pesanan->id);

            return redirect()->route('customer.payment.upload', $pesanan->id)
                           ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating order: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->withInput()
                        ->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    private function generateOrderNumber()
    {
        $prefix = 'SB';
        $date = date('Ymd');
        $random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        $orderNumber = $prefix . $date . $random;
        
        // Pastikan nomor pesanan unik
        while (Pesanan::where('kode_pesanan', $orderNumber)->exists()) {
            $random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $orderNumber = $prefix . $date . $random;
        }
        
        return $orderNumber;
    }
}