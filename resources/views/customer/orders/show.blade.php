@extends('customer.layouts.app')

@section('title', 'Detail Pesanan - Seka Boga')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('customer.orders.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
                    <p class="text-gray-600">{{ $order->kode_pesanan }}</p>
                </div>
            </div>
            
            <!-- Status Badge -->
            <div class="flex items-center gap-4">
                <span class="inline-flex px-4 py-2 text-sm font-medium rounded-full {{ App\Http\Controllers\OrderController::getStatusBadge($order->status_pesanan) }}">
                    {{ App\Http\Controllers\OrderController::getStatusText($order->status_pesanan) }}
                </span>
                <span class="text-xl font-bold text-green-600">
                    Rp {{ number_format($order->total_keseluruhan ?: $order->total_harga_produk, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Pesanan</h3>
                    
                    <div class="space-y-4">
                        @foreach($order->detailPesanan as $detail)
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                            @if($detail->produk->gambarUtama)
                                <img src="{{ Storage::url($detail->produk->gambarUtama->file_path) }}" 
                                     alt="{{ $detail->produk->nama_produk }}"
                                     class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $detail->produk->nama_produk }}</h4>
                                <p class="text-sm text-gray-600">{{ $detail->produk->kategori->nama_kategori }}</p>
                                <p class="text-sm text-gray-600">Qty: {{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                                @if($detail->catatan_item)
                                    <p class="text-sm text-gray-500 italic">Catatan: {{ $detail->catatan_item }}</p>
                                @endif
                            </div>
                            
                            <div class="text-right">
                                <p class="font-bold text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Informasi Pengiriman
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 mb-1">Nama Penerima:</p>
                            <p class="font-medium">{{ $order->nama_penerima }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Nomor Telepon:</p>
                            <p class="font-medium">{{ $order->nomor_telepon_penerima }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-600 mb-1">Alamat:</p>
                            <p class="font-medium">{{ $order->alamat_pengiriman }}</p>
                            <p class="font-medium">{{ $order->kota_pengiriman }}, {{ $order->provinsi_pengiriman }} {{ $order->kode_pos_pengiriman }}</p>
                        </div>
                        @if($order->tanggal_dibutuhkan)
                        <div class="md:col-span-2">
                            <p class="text-gray-600 mb-1">Waktu Dibutuhkan:</p>
                            <p class="font-medium">{{ $order->tanggal_dibutuhkan->format('d M Y H:i') }}</p>
                        </div>
                        @endif
                        @if($order->catatan_pesanan)
                        <div class="md:col-span-2">
                            <p class="text-gray-600 mb-1">Catatan Pesanan:</p>
                            <p class="font-medium">{{ $order->catatan_pesanan }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Information -->
                @if($order->pembayaran)
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Informasi Pembayaran
                    </h3>
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-medium">{{ $order->pembayaran->metode_pembayaran }}</span>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full 
                                @if($order->pembayaran->status_pembayaran === 'dikonfirmasi') bg-green-100 text-green-800
                                @elseif($order->pembayaran->status_pembayaran === 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                                @elseif($order->pembayaran->status_pembayaran === 'ditolak') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $order->pembayaran->status_pembayaran)) }}
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-2">Jumlah: <span class="font-medium">Rp {{ number_format($order->pembayaran->jumlah_pembayaran, 0, ',', '.') }}</span></p>
                        
                        @if($order->pembayaran->bukti_pembayaran)
                            <div class="mb-2">
                                <p class="text-sm text-gray-600 mb-2">Bukti Pembayaran:</p>
                                <img src="{{ Storage::url($order->pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="w-32 h-32 object-cover rounded-lg border cursor-pointer" onclick="showImageModal('{{ Storage::url($order->pembayaran->bukti_pembayaran) }}')">
                            </div>
                        @endif
                        
                        @if($order->pembayaran->tanggal_upload_bukti)
                            <p class="text-xs text-gray-500">Diupload: {{ $order->pembayaran->tanggal_upload_bukti->format('d M Y H:i') }}</p>
                        @endif
                        
                        @if($order->pembayaran->alasan_penolakan)
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded">
                                <p class="text-sm text-red-700"><strong>Alasan Penolakan:</strong> {{ $order->pembayaran->alasan_penolakan }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Order Summary & Actions -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Pesanan:</span>
                            <span class="font-medium">{{ $order->tanggal_pesanan->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">Rp {{ number_format($order->total_harga_produk, 0, ',', '.') }}</span>
                        </div>
                        @if($order->biaya_ongkir)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ongkos Kirim:</span>
                            <span class="font-medium">Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between border-t pt-2 text-lg font-bold">
                            <span>Total:</span>
                            <span class="text-green-600">Rp {{ number_format($order->total_keseluruhan ?: $order->total_harga_produk, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                    
                    <div class="space-y-3">
                        @if($order->status_pesanan === 'menunggu_pembayaran' && !$order->pembayaran->where('status_pembayaran', '!=', 'ditolak')->first())
                            <a href="{{ route('customer.payment.upload', $order->id) }}" 
                               class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200 shadow-lg text-center block">
                                Upload Pembayaran
                            </a>
                        @endif
                        
                        @if($order->status_pesanan === 'menunggu_pembayaran')
                            <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                                        class="w-full bg-red-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-red-700 transition-colors duration-200">
                                    Batalkan Pesanan
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('customer.orders.index') }}" 
                           class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-semibold hover:bg-gray-200 transition-colors duration-200 text-center block">
                            Kembali ke Daftar Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl max-h-full overflow-auto">
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Bukti Pembayaran</h3>
                <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <img id="modalImage" src="" alt="Bukti Pembayaran" class="w-full h-auto rounded-lg">
        </div>
    </div>
</div>

<script>
function showImageModal(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endsection