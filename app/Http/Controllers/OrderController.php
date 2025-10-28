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

        $order = Pesanan::with(['detailPesanan.produk.gambarUtama', 'rekeningAdmin'])
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
     * Get order status badge
     */
    public static function getStatusBadge($status)
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'waiting_confirmation' => 'bg-blue-100 text-blue-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'processing' => 'bg-indigo-100 text-indigo-800',
            'ready' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'completed' => 'bg-gray-100 text-gray-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];

        return $badges[$status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get order status text
     */
    public static function getStatusText($status)
    {
        $statuses = [
            'pending' => 'Menunggu Pembayaran',
            'waiting_confirmation' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Sedang Diproses',
            'ready' => 'Siap Diantar',
            'delivered' => 'Sedang Diantar',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return $statuses[$status] ?? 'Status Tidak Diketahui';
    }
}