@extends('customer.layouts.app')

@section('title', 'Pesanan Saya - Seka Boga')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesanan Saya</h1>
            <p class="text-gray-600">Kelola dan pantau status pesanan Anda</p>
        </div>

        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-600 mb-6">Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
                <a href="{{ route('customer.home') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transform hover:scale-105 transition-all duration-200 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Mulai Berbelanja
                </a>
            </div>
        @else
            <!-- Orders List -->
            <div class="space-y-6">
                @foreach($orders as $order)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <!-- Order Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $order->kode_pesanan }}</h3>
                                <p class="text-sm text-gray-600">{{ $order->tanggal_pesanan->format('d M Y H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ App\Http\Controllers\OrderController::getStatusBadge($order->status_pesanan) }}">
                                    {{ App\Http\Controllers\OrderController::getStatusText($order->status_pesanan) }}
                                </span>
                                <span class="text-lg font-bold text-green-600">
                                    Rp {{ number_format($order->total_keseluruhan ?: $order->total_harga_produk, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Preview -->
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            @foreach($order->detailPesanan->take(3) as $detail)
                                @if($detail->produk->gambarUtama)
                                    <img src="{{ Storage::url($detail->produk->gambarUtama->file_path) }}" 
                                         alt="{{ $detail->produk->nama_produk }}"
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            @endforeach
                            
                            @if($order->detailPesanan->count() > 3)
                                <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-600">+{{ $order->detailPesanan->count() - 3 }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="text-sm text-gray-600 mb-4">
                            <p><strong>{{ $order->detailPesanan->count() }} item</strong> - 
                               {{ $order->detailPesanan->first()->produk->nama_produk }}
                               @if($order->detailPesanan->count() > 1)
                                   dan {{ $order->detailPesanan->count() - 1 }} lainnya
                               @endif
                            </p>
                            @if($order->tanggal_dibutuhkan)
                                <p class="mt-1">Untuk: {{ $order->tanggal_dibutuhkan->format('d M Y H:i') }}</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('customer.orders.show', $order->id) }}" 
                               class="flex-1 text-center bg-green-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-green-700 transition-colors duration-200">
                                Lihat Detail
                            </a>
                            
                            @if($order->status_pesanan === 'menunggu_pembayaran' && !$order->pembayaran->where('status_pembayaran', '!=', 'ditolak')->first())
                                <a href="{{ route('customer.payment.upload', $order->id) }}" 
                                   class="flex-1 text-center bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200">
                                    Upload Pembayaran
                                </a>
                            @endif
                            
                            @if($order->status_pesanan === 'menunggu_pembayaran')
                                <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                                            class="w-full bg-red-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-700 transition-colors duration-200">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection