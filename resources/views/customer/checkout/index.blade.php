@extends('customer.layouts.app')

@section('title', 'Checkout - Seka Boga')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Checkout</h1>
            <p class="text-gray-600">Lengkapi data pesanan Anda</p>
        </div>

        <form action="{{ route('customer.checkout.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column - Form -->
                <div class="space-y-6">
                    <!-- Informasi Penerima -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informasi Penerima
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_penerima" class="block text-sm font-medium text-gray-700 mb-2">Nama Penerima</label>
                                <input type="text" name="nama_penerima" id="nama_penerima" 
                                       value="{{ old('nama_penerima', $user->nama_lengkap) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                       required>
                                @error('nama_penerima')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="nomor_telepon_penerima" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="text" name="nomor_telepon_penerima" id="nomor_telepon_penerima" 
                                       value="{{ old('nomor_telepon_penerima', $user->nomor_telepon) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                       required>
                                @error('nomor_telepon_penerima')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Alamat Pengiriman
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="alamat_pengiriman" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="3" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                          placeholder="Masukkan alamat lengkap..."
                                          required>{{ old('alamat_pengiriman', $user->alamat) }}</textarea>
                                @error('alamat_pengiriman')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="kota_pengiriman" class="block text-sm font-medium text-gray-700 mb-2">Kota</label>
                                    <input type="text" name="kota_pengiriman" id="kota_pengiriman" 
                                           value="{{ old('kota_pengiriman', $user->kota) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                           required>
                                    @error('kota_pengiriman')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="provinsi_pengiriman" class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                                    <input type="text" name="provinsi_pengiriman" id="provinsi_pengiriman" 
                                           value="{{ old('provinsi_pengiriman', $user->provinsi) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                           required>
                                    @error('provinsi_pengiriman')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="kode_pos_pengiriman" class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                                    <input type="text" name="kode_pos_pengiriman" id="kode_pos_pengiriman" 
                                           value="{{ old('kode_pos_pengiriman', $user->kode_pos) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                           required>
                                    @error('kode_pos_pengiriman')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Acara -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Waktu Acara
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tanggal_acara" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Acara</label>
                                <input type="date" name="tanggal_acara" id="tanggal_acara" 
                                       value="{{ old('tanggal_acara') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                       required>
                                @error('tanggal_acara')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="waktu_acara" class="block text-sm font-medium text-gray-700 mb-2">Waktu Acara</label>
                                <input type="time" name="waktu_acara" id="waktu_acara" 
                                       value="{{ old('waktu_acara') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                       required>
                                @error('waktu_acara')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Catatan Pesanan
                        </h3>
                        
                        <textarea name="catatan_pesanan" id="catatan_pesanan" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                  placeholder="Catatan khusus untuk pesanan (opsional)...">{{ old('catatan_pesanan') }}</textarea>
                        @error('catatan_pesanan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:sticky lg:top-8 lg:self-start">
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-4 mb-6">
                            @foreach($cartItems as $item)
                            <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                                @if($item->produk->gambarUtama)
                                    <img src="{{ Storage::url($item->produk->gambarUtama->file_path) }}" 
                                         alt="{{ $item->produk->nama_produk }}"
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $item->produk->nama_produk }}</h4>
                                    <p class="text-sm text-gray-600">{{ $item->jumlah }} x Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">Rp {{ number_format($item->jumlah * $item->produk->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkos Kirim</span>
                                <span>Gratis</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-gray-900 border-t pt-2">
                                <span>Total</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-6 space-y-4">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 px-6 rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                Buat Pesanan
                            </button>
                            
                            <a href="{{ route('customer.cart') }}" 
                               class="block w-full text-center bg-gray-100 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-200 transition-colors duration-200">
                                Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection