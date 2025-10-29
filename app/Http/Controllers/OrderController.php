<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display customer orders
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = Pesanan::with(['detailPesanan.produk.gambarUtama'])
            ->where('customer_id', Auth::id())
            ->orderBy('tanggal_pesanan', 'desc')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show specific order
     */
    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Pesanan::with(['detailPesanan.produk.gambarUtama', 'pembayaran.rekeningAdmin'])
            ->where('id', $id)
            ->where('customer_id', Auth::id())
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Cancel order (only if pending)
     */
    public function cancel($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Pesanan::where('id', $id)
            ->where('customer_id', Auth::id())
            ->where('status_pesanan', 'pending')
            ->firstOrFail();

        $order->update([
            'status_pesanan' => 'cancelled',
            'tanggal_dibatalkan' => now(),
        ]);

        return redirect()->route('customer.orders.index')
                       ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Complete order (customer received the order)
     */
    public function complete($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Pesanan::where('id', $id)
            ->where('customer_id', Auth::id())
            ->where('status_pesanan', 'dikirim')
            ->firstOrFail();

        $order->update([
            'status_pesanan' => 'selesai'
        ]);

        return redirect()->route('customer.orders.index')
                       ->with('success', 'Pesanan berhasil diselesaikan. Terima kasih!');
    }

    /**
     * Get order status badge
     */
    public static function getStatusBadge($status)
    {
        $badges = [
            'menunggu_pembayaran_produk' => 'bg-yellow-100 text-yellow-800',
            'menunggu_konfirmasi_pembayaran_produk' => 'bg-blue-100 text-blue-800',
            'pembayaran_produk_dikonfirmasi' => 'bg-green-100 text-green-800',
            'menunggu_input_ongkir' => 'bg-orange-100 text-orange-800',
            'menunggu_pembayaran_ongkir' => 'bg-yellow-100 text-yellow-800',
            'menunggu_konfirmasi_pembayaran_ongkir' => 'bg-blue-100 text-blue-800',
            'pembayaran_ongkir_dikonfirmasi' => 'bg-green-100 text-green-800',
            'diproses' => 'bg-indigo-100 text-indigo-800',
            'menunggu_input_resi' => 'bg-purple-100 text-purple-800',
            'dikirim' => 'bg-green-100 text-green-800',
            'selesai' => 'bg-gray-100 text-gray-800',
            'dibatalkan' => 'bg-red-100 text-red-800',
        ];

        return $badges[$status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get order status text
     */
    public static function getStatusText($status)
    {
        $statuses = [
            'menunggu_pembayaran_produk' => 'Menunggu Pembayaran Produk',
            'menunggu_konfirmasi_pembayaran_produk' => 'Menunggu Konfirmasi Pembayaran',
            'pembayaran_produk_dikonfirmasi' => 'Pembayaran Dikonfirmasi',
            'menunggu_input_ongkir' => 'Menunggu Input Ongkir',
            'menunggu_pembayaran_ongkir' => 'Menunggu Pembayaran Ongkir',
            'menunggu_konfirmasi_pembayaran_ongkir' => 'Menunggu Konfirmasi Ongkir',
            'pembayaran_ongkir_dikonfirmasi' => 'Pembayaran Ongkir Dikonfirmasi',
            'diproses' => 'Sedang Diproses',
            'menunggu_input_resi' => 'Menunggu Input Resi',
            'dikirim' => 'Sedang Dikirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];

        return $statuses[$status] ?? 'Status Tidak Diketahui';
    }
}