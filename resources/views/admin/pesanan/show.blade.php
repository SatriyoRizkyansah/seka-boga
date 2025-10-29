@extends('admin.layout.app')

@section('title', 'Detail Pesanan')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan #{{ $pesanan->kode_pesanan }}</h1>
        <a href="{{ route('admin.pesanan.index') }}" class="btn-secondary">
            ← Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informasi Pesanan - 2/3 width -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Informasi Pesanan -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Pesanan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kode Pesanan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->kode_pesanan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Pesanan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->tanggal_pesanan->format('d M Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Dibutuhkan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->tanggal_dibutuhkan ? \Carbon\Carbon::parse($pesanan->tanggal_dibutuhkan)->format('d M Y H:i') : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @php
                                    $statusClasses = [
                                        'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                        'menunggu_konfirmasi_pembayaran' => 'bg-blue-100 text-blue-800',
                                        'pembayaran_dikonfirmasi' => 'bg-green-100 text-green-800',
                                        'diproses' => 'bg-blue-100 text-blue-800',
                                        'dikirim' => 'bg-purple-100 text-purple-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                        'dibatalkan' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$pesanan->status_pesanan] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucwords(str_replace('_', ' ', $pesanan->status_pesanan)) }}
                                </span>
                            </dd>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Customer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->customer->nama_lengkap ?? $pesanan->customer->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->customer->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->nomor_telepon_penerima }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $pesanan->alamat_pengiriman }}<br>
                                {{ $pesanan->kota_pengiriman }}, {{ $pesanan->provinsi_pengiriman }} {{ $pesanan->kode_pos_pengiriman }}
                            </dd>
                        </div>
                    </div>
                </div>
                
                @if($pesanan->catatan_pesanan)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <dt class="text-sm font-medium text-gray-500">Catatan Pesanan</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->catatan_pesanan }}</dd>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detail Item Pesanan -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Detail Item</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pesanan->detailPesanan as $detail)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($detail->produk->gambarUtama)
                                            <img src="{{ Storage::url($detail->produk->gambarUtama->file_path) }}" 
                                                 alt="{{ $detail->nama_produk }}"
                                                 class="h-12 w-12 rounded-lg object-cover mr-4">
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $detail->nama_produk }}</div>
                                            @if($detail->catatan_produk)
                                                <div class="text-sm text-gray-500">{{ $detail->catatan_produk }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $detail->jumlah }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-900">Total:</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">
                                    Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Aksi - 1/3 width -->
    <div class="space-y-6">
        <!-- Status Info -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-xl shadow-lg">
            <div class="px-6 py-5">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-indigo-800">Status Pesanan Saat Ini</h3>
                        <p class="text-sm text-indigo-600">Alur otomatis - Status akan berubah setelah aksi dilakukan</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-4 border border-indigo-100">
                    @php
                        $statusMessages = [
                            'menunggu_pembayaran_produk' => ['text' => 'Menunggu customer upload bukti pembayaran produk', 'color' => 'yellow'],
                            'menunggu_konfirmasi_pembayaran_produk' => ['text' => 'Menunggu konfirmasi pembayaran produk dari admin', 'color' => 'blue'],
                            'menunggu_input_ongkir' => ['text' => 'Menunggu admin input biaya ongkir', 'color' => 'orange'],
                            'menunggu_pembayaran_ongkir' => ['text' => 'Menunggu customer upload bukti pembayaran ongkir', 'color' => 'yellow'],
                            'menunggu_konfirmasi_pembayaran_ongkir' => ['text' => 'Menunggu konfirmasi pembayaran ongkir dari admin', 'color' => 'purple'],
                            'menunggu_input_resi' => ['text' => 'Menunggu admin input nomor resi pengiriman', 'color' => 'blue'],
                            'dikirim' => ['text' => 'Pesanan sedang dalam perjalanan', 'color' => 'indigo'],
                            'selesai' => ['text' => 'Pesanan telah selesai', 'color' => 'green'],
                            'dibatalkan' => ['text' => 'Pesanan dibatalkan', 'color' => 'red']
                        ];
                        
                        $currentStatus = $statusMessages[$pesanan->status_pesanan] ?? ['text' => 'Status tidak diketahui', 'color' => 'gray'];
                    @endphp
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-{{ $currentStatus['color'] }}-100 text-{{ $currentStatus['color'] }}-800">
                                {{ ucwords(str_replace('_', ' ', $pesanan->status_pesanan)) }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">{{ $currentStatus['text'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Biaya Ongkir -->
        @if($pesanan->status_pesanan == 'menunggu_input_ongkir')
        <div class="bg-gradient-to-r from-orange-50 to-yellow-50 border border-orange-200 rounded-xl shadow-lg">
            <div class="px-6 py-5">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-orange-800">Input Biaya Ongkir</h3>
                        <p class="text-sm text-orange-600">Tentukan biaya pengiriman untuk pesanan ini</p>
                    </div>
                </div>
                
                <form action="{{ route('admin.pesanan.input-shipping-cost', $pesanan->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    
                    <div class="bg-white rounded-lg p-4 border border-orange-100">
                        <label for="biaya_ongkir" class="block text-sm font-medium text-gray-700 mb-2">Biaya Ongkir</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500 font-medium">Rp</span>
                            <input type="number" name="biaya_ongkir" id="biaya_ongkir" 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                                   min="0" step="1000" placeholder="0" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Set Biaya Ongkir
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Input Nomor Resi -->
        @if($pesanan->status_pesanan == 'menunggu_input_resi')
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl shadow-lg">
            <div class="px-6 py-5">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-800">Input Nomor Resi</h3>
                        <p class="text-sm text-blue-600">Masukkan informasi pengiriman pesanan</p>
                    </div>
                </div>
                
                <form action="{{ route('admin.pesanan.input-tracking', $pesanan->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    
                    <div class="bg-white rounded-lg p-4 border border-blue-100">
                        <label for="nama_jasa_pengiriman" class="block text-sm font-medium text-gray-700 mb-2">Nama Jasa Pengiriman</label>
                        <input type="text" name="nama_jasa_pengiriman" id="nama_jasa_pengiriman" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               value="{{ $pesanan->nama_jasa_pengiriman }}" placeholder="contoh: JNE, JNT, SiCepat" required>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4 border border-blue-100">
                        <label for="nomor_resi" class="block text-sm font-medium text-gray-700 mb-2">Nomor Resi</label>
                        <input type="text" name="nomor_resi" id="nomor_resi" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               value="{{ $pesanan->nomor_resi }}" placeholder="Masukkan nomor resi" required>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        {{ $pesanan->nomor_resi ? 'Update' : 'Input' }} Resi & Kirim Pesanan
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Pembayaran Carousel -->
        @php 
            $pembayaranProduk = $pesanan->getPembayaranProduk(); 
            $pembayaranOngkir = $pesanan->getPembayaranOngkir();
        @endphp
        @if($pembayaranProduk || $pembayaranOngkir)
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl shadow-lg">
            <div class="px-6 py-5">
                <!-- Header -->
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-3 rounded-xl mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-blue-800">Informasi Pembayaran</h3>
                        <p class="text-sm text-blue-600">Pembayaran produk dan ongkir</p>
                    </div>
                </div>
                
                <!-- Tab Navigation -->
                <div class="flex justify-center mb-6">
                    <div class="inline-flex bg-gray-100 rounded-lg p-1 shadow-inner">
                        @if($pembayaranProduk)
                        <button onclick="switchPaymentTab('produk')" 
                                id="tab-produk"
                                class="payment-tab active flex items-center px-4 py-2 text-sm font-medium rounded-md transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Produk
                        </button>
                        @endif
                        @if($pembayaranOngkir)
                        <button onclick="switchPaymentTab('ongkir')" 
                                id="tab-ongkir"
                                class="payment-tab {{ !$pembayaranProduk ? 'active' : '' }} flex items-center px-4 py-2 text-sm font-medium rounded-md transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Ongkir
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Carousel Container -->
                <div class="relative overflow-hidden">
                    <!-- Pembayaran Produk Panel -->
                    @if($pembayaranProduk)
                    <div id="panel-produk" class="payment-panel {{ $pembayaranProduk ? 'active' : '' }}">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200 mb-4">
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
                            <button onclick="openPaymentModal('{{ Storage::url($pembayaranProduk->bukti_pembayaran) }}', 'Bukti Pembayaran Produk')" 
                                    class="w-full bg-blue-100 text-blue-700 py-2 px-3 rounded-lg text-sm font-medium hover:bg-blue-200 transition-colors flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <a href="{{ Storage::url($pembayaranProduk->bukti_pembayaran) }}" download 
                               class="w-full bg-green-100 text-green-700 py-2 px-3 rounded-lg text-sm font-medium hover:bg-green-200 transition-colors flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                
                @if($pembayaranProduk->status_pembayaran == 'menunggu_konfirmasi')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                            <h4 class="text-lg font-semibold text-blue-800 mb-3">Konfirmasi Pembayaran Produk</h4>
                            <p class="text-sm text-blue-700 mb-4">Setelah konfirmasi, status pesanan akan otomatis berubah ke langkah berikutnya.</p>
                            
                            <div class="flex space-x-3">
                                <form action="{{ route('admin.pesanan.confirm-payment', $pesanan->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="jenis_pembayaran" value="produk">
                                    <input type="hidden" name="status" value="dikonfirmasi">
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                        ✓ Terima Pembayaran
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.pesanan.confirm-payment', $pesanan->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="jenis_pembayaran" value="produk">
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" onclick="return confirm('Yakin ingin menolak pembayaran ini?')" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                        ✗ Tolak Pembayaran
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

                    <!-- Pembayaran Ongkir Panel -->
                    @if($pembayaranOngkir)
                    <div id="panel-ongkir" class="payment-panel {{ !$pembayaranProduk ? 'active' : '' }}">
                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-4 border border-purple-200 mb-4">
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
                                        <button onclick="openPaymentModal('{{ Storage::url($pembayaranOngkir->bukti_pembayaran) }}', 'Bukti Pembayaran Ongkir')" 
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
                            
                            @if($pembayaranOngkir->status_pembayaran == 'menunggu_konfirmasi')
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mt-6">
                                <h4 class="text-lg font-semibold text-purple-800 mb-3">Konfirmasi Pembayaran Ongkir</h4>
                                <p class="text-sm text-purple-700 mb-4">Setelah konfirmasi, status pesanan akan otomatis berubah ke langkah berikutnya.</p>
                                
                                <div class="flex space-x-3">
                                    <form action="{{ route('admin.pesanan.confirm-payment', $pesanan->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="jenis_pembayaran" value="ongkir">
                                        <input type="hidden" name="status" value="dikonfirmasi">
                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                            ✓ Terima Pembayaran
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.pesanan.confirm-payment', $pesanan->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="jenis_pembayaran" value="ongkir">
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit" onclick="return confirm('Yakin ingin menolak pembayaran ini?')" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                            ✗ Tolak Pembayaran
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Payment Modal with Animation -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4 backdrop-blur-sm" onclick="closePaymentModal()">
    <div class="bg-white rounded-2xl max-w-4xl max-h-[90vh] overflow-hidden shadow-2xl transform transition-all duration-300 scale-95 opacity-0" onclick="event.stopPropagation()" id="modalContent">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-xl font-bold" id="modalTitle">Bukti Pembayaran</h3>
            </div>
            <button onclick="closePaymentModal()" class="text-white hover:text-gray-200 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 max-h-[calc(90vh-140px)] overflow-auto">
            <div class="text-center">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full h-auto rounded-lg shadow-lg mx-auto">
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t">
            <div class="text-sm text-gray-600">
                Klik dan drag untuk menggeser gambar
            </div>
            <div class="flex space-x-3">
                <button onclick="downloadImage()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download
                </button>
                <button onclick="openInNewTab()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Buka di Tab Baru
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentImageUrl = '';

// Payment Tab Functions
function switchPaymentTab(tabType) {
    // Remove active class from all tabs and panels  
    document.querySelectorAll('.payment-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.payment-panel').forEach(panel => {
        panel.classList.remove('active');
    });
    
    // Add active class to clicked tab and corresponding panel
    document.getElementById(`tab-${tabType}`).classList.add('active');
    document.getElementById(`panel-${tabType}`).classList.add('active');
}

function openPaymentModal(imageUrl, title) {
    currentImageUrl = imageUrl;
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalTitle').textContent = title;
    
    const modal = document.getElementById('paymentModal');
    const modalContent = document.getElementById('modalContent');
    
    // Show modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Animate modal appearance
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closePaymentModal() {
    const modal = document.getElementById('paymentModal');
    const modalContent = document.getElementById('modalContent');
    
    // Animate modal disappearance
    modalContent.classList.add('scale-95', 'opacity-0');
    modalContent.classList.remove('scale-100', 'opacity-100');
    
    // Hide modal after animation
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }, 300);
}

function downloadImage() {
    const link = document.createElement('a');
    link.href = currentImageUrl;
    link.download = 'bukti-pembayaran-' + Date.now() + '.jpg';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function openInNewTab() {
    window.open(currentImageUrl, '_blank');
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closePaymentModal();
    }
});

// Image zoom and pan functionality
let isImageDragging = false;
let startX, startY, initialX, initialY;

document.getElementById('modalImage').addEventListener('mousedown', function(e) {
    isImageDragging = true;
    startX = e.clientX;
    startY = e.clientY;
    initialX = parseInt(this.style.transform?.match(/translateX\((-?\d+)px\)/)?.[1] || 0);
    initialY = parseInt(this.style.transform?.match(/translateY\((-?\d+)px\)/)?.[1] || 0);
    this.style.cursor = 'grabbing';
    e.preventDefault();
});

document.addEventListener('mousemove', function(e) {
    if (!isImageDragging) return;
    
    const img = document.getElementById('modalImage');
    const deltaX = e.clientX - startX;
    const deltaY = e.clientY - startY;
    
    img.style.transform = `translateX(${initialX + deltaX}px) translateY(${initialY + deltaY}px)`;
});

document.addEventListener('mouseup', function() {
    if (isImageDragging) {
        isImageDragging = false;
        document.getElementById('modalImage').style.cursor = 'grab';
    }
});

// Reset image position when modal opens
function resetImagePosition() {
    const img = document.getElementById('modalImage');
    img.style.transform = 'translateX(0px) translateY(0px)';
    img.style.cursor = 'grab';
}

// Double click to reset position
document.getElementById('modalImage').addEventListener('dblclick', resetImagePosition);
</script>

<style>
.payment-tab {
    @apply text-sm font-medium rounded-lg transition-all duration-200 cursor-pointer;
    @apply bg-white text-gray-600 hover:bg-green-50 hover:text-green-600;
    @apply whitespace-nowrap;
}

.payment-tab.active {
    @apply bg-gradient-to-r from-green-500 to-green-600 text-white;
    @apply shadow-md;
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
}

.payment-carousel {
    min-height: 300px;
}

/* Animation for smooth transitions */
.payment-panel.active {
    animation: slideIn 0.3s ease-out forwards;
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