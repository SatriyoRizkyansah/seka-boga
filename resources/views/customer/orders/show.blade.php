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
                        
                        <!-- Informasi Resi -->
                        @if($order->nomor_resi && $order->nama_jasa_pengiriman && in_array($order->status_pesanan, ['dikirim', 'selesai']))
                        <div class="md:col-span-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 mt-4">
                            <h4 class="text-sm font-semibold text-blue-800 mb-2 flex items-center">
                                <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                Informasi Pengiriman
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-blue-600 mb-1">Jasa Pengiriman:</p>
                                    <p class="font-semibold text-blue-800">{{ $order->nama_jasa_pengiriman }}</p>
                                </div>
                                <div>
                                    <p class="text-blue-600 mb-1">Nomor Resi:</p>
                                    <p class="font-semibold text-blue-800 font-mono tracking-wide">{{ $order->nomor_resi }}</p>
                                </div>
                            </div>
                            @if($order->status_pesanan == 'dikirim')
                            <div class="mt-3 pt-3 border-t border-blue-200">
                                <p class="text-xs text-blue-600">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pesanan sedang dalam perjalanan. Anda dapat melacak paket dengan nomor resi di atas.
                                </p>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Information Carousel -->
                @php 
                    $pembayaranProduk = $order->getPembayaranProduk(); 
                    $pembayaranOngkir = $order->getPembayaranOngkir();
                @endphp
                @if($pembayaranProduk || $pembayaranOngkir)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-100">
                        <div class="flex items-center mb-3">
                            <div class="bg-blue-100 p-3 rounded-xl mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-blue-800">Informasi Pembayaran</h3>
                                <p class="text-sm text-blue-600">Pembayaran produk dan ongkir</p>
                            </div>
                        </div>
                        
                        <!-- Tab Navigation -->
                        <div class="flex flex-wrap gap-2">
                            @if($pembayaranProduk)
                            <button onclick="switchPaymentTab('produk')" 
                                    id="tab-produk"
                                    class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 payment-tab active">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Produk
                                </span>
                            </button>
                            @endif
                            @if($pembayaranOngkir)
                            <button onclick="switchPaymentTab('ongkir')" 
                                    id="tab-ongkir"
                                    class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 payment-tab {{ !$pembayaranProduk ? 'active' : '' }}">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Ongkir
                                </span>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Carousel Container -->
                    <div class="relative overflow-hidden p-6 payment-carousel">
                        <!-- Pembayaran Produk Panel -->
                        @if($pembayaranProduk)
                        <div id="panel-produk" class="payment-panel {{ $pembayaranProduk ? 'active' : '' }}">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-green-800">Pembayaran Produk</h4>
                                    <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full {{ $pembayaranProduk->status_pembayaran == 'dikonfirmasi' ? 'bg-green-100 text-green-800' : ($pembayaranProduk->status_pembayaran == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucwords(str_replace('_', ' ', $pembayaranProduk->status_pembayaran)) }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <!-- Info Pembayaran -->
                                    <div class="bg-white rounded-xl p-4 border border-green-100">
                                        <h4 class="font-semibold text-gray-800 mb-4">Informasi Pembayaran</h4>
                                        <div class="space-y-3">
                                            @if($pembayaranProduk->rekeningAdmin)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Rekening Tujuan</dt>
                                                <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-2 rounded">
                                                    <div class="font-medium">{{ $pembayaranProduk->rekeningAdmin->nama_bank }}</div>
                                                    <div class="font-mono text-xs">{{ $pembayaranProduk->rekeningAdmin->nomor_rekening }}</div>
                                                    <div class="text-xs text-gray-600">a.n. {{ $pembayaranProduk->rekeningAdmin->nama_pemilik }}</div>
                                                </dd>
                                            </div>
                                            @endif
                                            
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Jumlah Pembayaran</dt>
                                                <dd class="mt-1 text-lg font-bold text-green-600">
                                                    Rp {{ number_format($pembayaranProduk->jumlah_pembayaran, 0, ',', '.') }}
                                                </dd>
                                            </div>
                                            
                                            @if($pembayaranProduk->tanggal_upload_bukti)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tanggal Upload</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    {{ $pembayaranProduk->tanggal_upload_bukti->format('d M Y H:i') }}
                                                </dd>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Bukti Transfer -->
                                    @if($pembayaranProduk->bukti_pembayaran)
                                    <div class="bg-white rounded-xl p-4 border border-green-100">
                                        <h4 class="font-semibold text-gray-800 mb-4">Bukti Transfer</h4>
                                        <div class="mb-3">
                                            <img src="{{ Storage::url($pembayaranProduk->bukti_pembayaran) }}" 
                                                 alt="Bukti Pembayaran Produk" 
                                                 class="w-full h-32 object-cover rounded-lg">
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            <button onclick="showImageModal('{{ Storage::url($pembayaranProduk->bukti_pembayaran) }}')" 
                                                    class="w-full bg-blue-100 text-blue-700 py-2 px-3 rounded-lg text-sm font-medium hover:bg-blue-200 transition-colors flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat
                                            </button>
                                            <a href="{{ Storage::url($pembayaranProduk->bukti_pembayaran) }}" download 
                                               class="w-full bg-green-100 text-green-700 py-2 px-3 rounded-lg text-sm font-medium hover:bg-green-200 transition-colors flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                @if($pembayaranProduk->alasan_penolakan)
                                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <h4 class="text-sm font-semibold text-red-800 mb-2">Alasan Penolakan:</h4>
                                    <p class="text-sm text-red-700">{{ $pembayaranProduk->alasan_penolakan }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Pembayaran Ongkir Panel -->
                        @if($pembayaranOngkir)
                        <div id="panel-ongkir" class="payment-panel {{ !$pembayaranProduk ? 'active' : '' }}">
                            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-4 border border-purple-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-purple-800">Pembayaran Ongkir</h4>
                                    <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full {{ $pembayaranOngkir->status_pembayaran == 'dikonfirmasi' ? 'bg-green-100 text-green-800' : ($pembayaranOngkir->status_pembayaran == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucwords(str_replace('_', ' ', $pembayaranOngkir->status_pembayaran)) }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <!-- Info Pembayaran -->
                                    <div class="bg-white rounded-xl p-4 border border-purple-100">
                                        <h4 class="font-semibold text-gray-800 mb-4">Informasi Pembayaran</h4>
                                        <div class="space-y-3">
                                            @if($pembayaranOngkir->rekeningAdmin)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Rekening Tujuan</dt>
                                                <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-2 rounded">
                                                    <div class="font-medium">{{ $pembayaranOngkir->rekeningAdmin->nama_bank }}</div>
                                                    <div class="font-mono text-xs">{{ $pembayaranOngkir->rekeningAdmin->nomor_rekening }}</div>
                                                    <div class="text-xs text-gray-600">a.n. {{ $pembayaranOngkir->rekeningAdmin->nama_pemilik }}</div>
                                                </dd>
                                            </div>
                                            @endif
                                            
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Jumlah Pembayaran</dt>
                                                <dd class="mt-1 text-lg font-bold text-purple-600">
                                                    Rp {{ number_format($pembayaranOngkir->jumlah_pembayaran, 0, ',', '.') }}
                                                </dd>
                                            </div>
                                            
                                            @if($pembayaranOngkir->tanggal_upload_bukti)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tanggal Upload</dt>
                                                <dd class="mt-1 text-sm text-gray-900">
                                                    {{ $pembayaranOngkir->tanggal_upload_bukti->format('d M Y H:i') }}
                                                </dd>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Bukti Transfer -->
                                    @if($pembayaranOngkir->bukti_pembayaran)
                                    <div class="bg-white rounded-xl p-4 border border-purple-100">
                                        <h4 class="font-semibold text-gray-800 mb-4">Bukti Transfer</h4>
                                        <div class="mb-3">
                                            <img src="{{ Storage::url($pembayaranOngkir->bukti_pembayaran) }}" 
                                                 alt="Bukti Pembayaran Ongkir" 
                                                 class="w-full h-32 object-cover rounded-lg">
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            <button onclick="showImageModal('{{ Storage::url($pembayaranOngkir->bukti_pembayaran) }}')" 
                                                    class="w-full bg-blue-100 text-blue-700 py-2 px-3 rounded-lg text-sm font-medium hover:bg-blue-200 transition-colors flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat
                                            </button>
                                            <a href="{{ Storage::url($pembayaranOngkir->bukti_pembayaran) }}" download 
                                               class="w-full bg-purple-100 text-purple-700 py-2 px-3 rounded-lg text-sm font-medium hover:bg-purple-200 transition-colors flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                @if($pembayaranOngkir->alasan_penolakan)
                                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <h4 class="text-sm font-semibold text-red-800 mb-2">Alasan Penolakan:</h4>
                                    <p class="text-sm text-red-700">{{ $pembayaranOngkir->alasan_penolakan }}</p>
                                </div>
                                @endif
                            </div>
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
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Tanggal Pesanan:</span>
                            <span class="font-medium">{{ $order->tanggal_pesanan->format('d M Y') }}</span>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-3 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal Produk:</span>
                                <span class="font-medium">Rp {{ number_format($order->total_harga_produk, 0, ',', '.') }}</span>
                            </div>
                            @if($order->biaya_ongkir)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Ongkir:</span>
                                <span class="font-medium text-orange-600">Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</span>
                            </div>
                            @else
                            <div class="flex justify-between">
                                <span class="text-gray-500 italic">Biaya Ongkir:</span>
                                <span class="text-gray-500 italic">Belum ditentukan</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="flex justify-between items-center border-t pt-3 text-lg font-bold">
                            <span class="text-gray-900">Total Keseluruhan:</span>
                            <span class="text-green-600">Rp {{ number_format($order->total_keseluruhan ?: $order->total_harga_produk, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                    
                    <div class="space-y-3">
                        <!-- Upload Pembayaran Produk -->
                        @if($order->status_pesanan === 'menunggu_pembayaran_produk')
                            <a href="{{ route('customer.payment.upload', [$order->id, 'produk']) }}" 
                               class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200 shadow-lg text-center block">
                                Upload Pembayaran Produk
                            </a>
                        @endif
                        
                        <!-- Upload Pembayaran Ongkir -->
                        @if($order->status_pesanan === 'menunggu_pembayaran_ongkir')
                            <a href="{{ route('customer.payment.upload', [$order->id, 'ongkir']) }}" 
                               class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-3 px-4 rounded-lg font-semibold hover:from-purple-700 hover:to-purple-800 transform hover:scale-105 transition-all duration-200 shadow-lg text-center block">
                                Upload Pembayaran Ongkir
                            </a>
                        @endif
                        
                        <!-- Tombol Selesaikan Pesanan -->
                        @if($order->status_pesanan === 'dikirim')
                            <form action="{{ route('customer.orders.complete', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        onclick="return confirm('Apakah Anda sudah menerima pesanan ini?')"
                                        class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 px-4 rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                    Selesaikan Pesanan
                                </button>
                            </form>
                        @endif
                        
                        <!-- Batalkan Pesanan -->
                        @if(in_array($order->status_pesanan, ['menunggu_pembayaran_produk', 'menunggu_konfirmasi_pembayaran_produk']))
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
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
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
// Payment tab switching
function switchPaymentTab(tabName) {
    // Hide all panels
    document.querySelectorAll('.payment-panel').forEach(panel => {
        panel.classList.remove('active');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.payment-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Show selected panel
    const selectedPanel = document.getElementById(`panel-${tabName}`);
    if (selectedPanel) {
        selectedPanel.classList.add('active');
    }
    
    // Add active class to selected tab
    const selectedTab = document.getElementById(`tab-${tabName}`);
    if (selectedTab) {
        selectedTab.classList.add('active');
    }
}

function showImageModal(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    const modal = document.getElementById('imageModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>

<style>
.payment-tab {
    @apply px-6 py-3 text-sm font-medium rounded-lg transition-all duration-200 cursor-pointer;
    @apply bg-white text-gray-600 border border-gray-200 hover:bg-blue-50 hover:text-blue-600;
}

.payment-tab.active {
    @apply bg-gradient-to-r from-blue-500 to-blue-600 text-white border-blue-600;
    @apply shadow-lg transform scale-105;
}

.payment-panel {
    @apply transition-all duration-300 ease-in-out;
    opacity: 0;
    transform: translateX(20px);
    display: none;
}

.payment-panel.active {
    opacity: 1;
    transform: translateX(0);
    display: block;
    animation: slideIn 0.3s ease-out forwards;
}

.payment-carousel {
    min-height: 300px;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>
@endsection