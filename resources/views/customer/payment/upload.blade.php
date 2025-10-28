@extends('customer.layouts.app')

@section('title', 'Upload Bukti Pembayaran - Seka Boga')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Upload Bukti Pembayaran</h1>
            <p class="text-gray-600">Pesanan #{{ $pesanan->kode_pesanan }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Payment Form -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Upload Bukti Pembayaran
                </h3>

                <form action="{{ route('customer.payment.store', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Pilih Rekening Admin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Rekening Tujuan</label>
                        <div class="space-y-3">
                            @foreach($rekeningAdmin as $rekening)
                            <label class="relative flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="rekening_admin_id" value="{{ $rekening->id }}" 
                                       class="mt-1 text-green-600 focus:ring-green-500 border-gray-300" required>
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/banks/' . strtolower($rekening->nama_bank) . '.png') }}" 
                                             alt="{{ $rekening->nama_bank }}" 
                                             class="w-8 h-8 object-contain"
                                             onerror="this.src='{{ asset('images/banks/default.png') }}'">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $rekening->nama_bank }}</p>
                                            <p class="text-sm text-gray-600">{{ $rekening->nomor_rekening }}</p>
                                            <p class="text-sm text-gray-600">a.n. {{ $rekening->nama_pemilik }}</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('rekening_admin_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Bukti Pembayaran -->
                    <div>
                        <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Bukti Pembayaran *
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-green-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="bukti_pembayaran" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                        <span>Upload gambar</span>
                                        <input id="bukti_pembayaran" name="bukti_pembayaran" type="file" accept="image/*" class="sr-only" required>
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG hingga 2MB</p>
                            </div>
                        </div>
                        @error('bukti_pembayaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="catatan_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan (Opsional)
                        </label>
                        <textarea name="catatan_pembayaran" id="catatan_pembayaran" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                  placeholder="Catatan tambahan untuk pembayaran...">{{ old('catatan_pembayaran') }}</textarea>
                        @error('catatan_pembayaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex space-x-4">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white py-3 px-6 rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transform hover:scale-105 transition-all duration-200 shadow-lg">
                            Upload Bukti Pembayaran
                        </button>
                        
                        <a href="{{ route('customer.orders.show', $pesanan->id) }}" 
                           class="flex-1 text-center bg-gray-100 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-200 transition-colors duration-200">
                            Nanti Saja
                        </a>
                    </div>
                </form>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="space-y-6">
                <!-- Order Details -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pesanan</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kode Pesanan:</span>
                            <span class="font-medium">{{ $pesanan->kode_pesanan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Pesanan:</span>
                            <span class="font-medium">{{ $pesanan->tanggal_pesanan->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                Menunggu Pembayaran
                            </span>
                        </div>
                        <div class="flex justify-between border-t pt-3 text-lg font-bold">
                            <span>Total Pembayaran:</span>
                            <span class="text-green-600">Rp {{ number_format($pesanan->total_keseluruhan ?: $pesanan->total_harga_produk, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Pesanan</h3>
                    
                    <div class="space-y-4">
                        @foreach($pesanan->detailPesanan as $detail)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            @if($detail->produk->gambarUtama)
                                <img src="{{ Storage::url($detail->produk->gambarUtama->file_path) }}" 
                                     alt="{{ $detail->produk->nama_produk }}"
                                     class="w-12 h-12 object-cover rounded-lg">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 text-sm">{{ $detail->produk->nama_produk }}</h4>
                                <p class="text-xs text-gray-600">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="text-right">
                                <p class="font-semibold text-gray-900 text-sm">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="bg-blue-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Petunjuk Pembayaran
                    </h3>
                    <ol class="text-sm text-blue-800 space-y-2 list-decimal list-inside">
                        <li>Transfer sesuai total pembayaran ke rekening yang dipilih</li>
                        <li>Ambil screenshot atau foto bukti transfer</li>
                        <li>Upload bukti pembayaran melalui form di samping</li>
                        <li>Admin akan memverifikasi dalam 24 jam</li>
                        <li>Pesanan akan diproses setelah pembayaran dikonfirmasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview uploaded image
document.getElementById('bukti_pembayaran').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add image preview here if needed
            console.log('Image uploaded:', file.name);
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection