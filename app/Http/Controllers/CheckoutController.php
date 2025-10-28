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

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
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

    /**
     * Process checkout and create order
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'nama_penerima' => ['required', 'string', 'max:255'],
            'nomor_telepon_penerima' => ['required', 'string', 'max:20'],
            'alamat_pengiriman' => ['required', 'string', 'max:500'],
            'kota_pengiriman' => ['required', 'string', 'max:100'],
            'provinsi_pengiriman' => ['required', 'string', 'max:100'],
            'kode_pos_pengiriman' => ['required', 'string', 'max:10'],
            'tanggal_acara' => ['required', 'date', 'after:today'],
            'waktu_acara' => ['required', 'string'],
            'catatan_pesanan' => ['nullable', 'string', 'max:1000'],

        ]);

        $cartItems = Keranjang::with('produk')
            ->where('customer_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart')
                           ->with('error', 'Keranjang belanja kosong');
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });

        try {
            DB::beginTransaction();

            // Create order
            $pesanan = Pesanan::create([
                'customer_id' => Auth::id(),
                'kode_pesanan' => $this->generateOrderNumber(),
                'tanggal_pesanan' => now(),
                'tanggal_dibutuhkan' => $validated['tanggal_acara'] . ' ' . $validated['waktu_acara'],
                'status_pesanan' => 'menunggu_pembayaran',
                'total_harga_produk' => $totalAmount,
                'total_keseluruhan' => $totalAmount, // For now, no shipping cost
                'nama_penerima' => $validated['nama_penerima'],
                'nomor_telepon_penerima' => $validated['nomor_telepon_penerima'],
                'alamat_pengiriman' => $validated['alamat_pengiriman'],
                'kota_pengiriman' => $validated['kota_pengiriman'],
                'provinsi_pengiriman' => $validated['provinsi_pengiriman'],
                'kode_pos_pengiriman' => $validated['kode_pos_pengiriman'],
                'catatan_pesanan' => $validated['catatan_pesanan'],
            ]);

            // Create order details
            foreach ($cartItems as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->produk->harga,
                    'subtotal' => $item->jumlah * $item->produk->harga,
                    'catatan_item' => $item->catatan,
                ]);
            }

            // Clear cart
            Keranjang::where('customer_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('customer.payment.upload', $pesanan->id)
                           ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique order number
     */
    private function generateOrderNumber()
    {
        $prefix = 'SB'; // Seka Boga
        $date = date('Ymd');
        $random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        $orderNumber = $prefix . $date . $random;
        
        // Check if order number already exists
        while (Pesanan::where('kode_pesanan', $orderNumber)->exists()) {
            $random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $orderNumber = $prefix . $date . $random;
        }
        
        return $orderNumber;
    }
}