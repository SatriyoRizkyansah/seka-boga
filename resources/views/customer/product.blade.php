@extends('customer.layouts.app')

@section('title', $product->nama_produk . ' - Seka Boga Catering')

@section('content')
<div class="bg-gradient-to-br from-green-50 to-white min-h-screen">
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-6 py-4">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('customer.home') }}" class="hover:text-green-600 transition-colors">Beranda</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('customer.category', $product->kategori->id) }}" class="hover:text-green-600 transition-colors">{{ $product->kategori->nama_kategori }}</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-800 font-medium">{{ $product->nama_produk }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Detail -->
    <section class="py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="aspect-square rounded-2xl overflow-hidden bg-gradient-to-br from-green-100 to-green-200">
                        @if($product->gambarUtama)
                        <img id="mainImage" 
                             src="{{ Storage::url($product->gambarUtama->path_gambar) }}" 
                             alt="{{ $product->nama_produk }}" 
                             class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Thumbnail Images -->
                    @if($product->gambarProduk->count() > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->gambarProduk->sortBy('urutan') as $gambar)
                        <div class="aspect-square rounded-lg overflow-hidden bg-gray-100 cursor-pointer hover:ring-2 hover:ring-green-500 transition-all"
                             onclick="changeMainImage('{{ Storage::url($gambar->path_gambar) }}')">
                            <img src="{{ Storage::url($gambar->path_gambar) }}" 
                                 alt="{{ $product->nama_produk }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <!-- Category Badge -->
                    <div>
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $product->kategori->nama_kategori }}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800">{{ $product->nama_produk }}</h1>

                    <!-- Price -->
                    <div class="text-4xl font-bold text-green-600">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                        <span class="text-lg text-gray-500 font-normal">/ {{ $product->satuan }}</span>
                    </div>

                    <!-- Stock & Minimum Order -->
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600">Stok:</span>
                            @if($product->stok > 0)
                            <span class="text-sm font-medium text-green-600">{{ $product->stok }} {{ $product->satuan }}</span>
                            @else
                            <span class="text-sm font-medium text-red-600">Habis</span>
                            @endif
                        </div>
                        @if($product->minimal_pemesanan > 1)
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600">Minimal Pesan:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $product->minimal_pemesanan }} {{ $product->satuan }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-gray-800">Deskripsi</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->deskripsi }}</p>
                    </div>

                    <!-- Main Ingredients -->
                    @if($product->bahan_utama)
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-gray-800">Bahan Utama</h3>
                        <p class="text-gray-600">{{ $product->bahan_utama }}</p>
                    </div>
                    @endif

                    <!-- Special Notes -->
                    @if($product->catatan_khusus)
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-gray-800">Catatan Khusus</h3>
                        <p class="text-gray-600">{{ $product->catatan_khusus }}</p>
                    </div>
                    @endif

                    <!-- Add to Cart Form -->
                    @if($product->stok > 0)
                    <form action="{{ route('customer.cart.add', $product->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <!-- Quantity Selector -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Jumlah</label>
                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-32">
                                <button type="button" onclick="decreaseQuantity()" 
                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" 
                                       name="quantity" 
                                       id="quantity" 
                                       value="{{ $product->minimal_pemesanan }}" 
                                       min="{{ $product->minimal_pemesanan }}" 
                                       max="{{ $product->stok }}"
                                       class="flex-1 px-3 py-2 text-center border-0 focus:ring-0 focus:outline-none">
                                <button type="button" onclick="increaseQuantity()" 
                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500">Minimal pemesanan {{ $product->minimal_pemesanan }} {{ $product->satuan }}</p>
                        </div>

                        <!-- Special Notes -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                            <textarea name="catatan" 
                                      rows="3" 
                                      placeholder="Tambahkan catatan khusus untuk pesanan ini..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                                Tambah ke Keranjang
                            </button>
                            <a href="{{ route('customer.category', $product->kategori->id) }}" 
                               class="px-6 py-3 border-2 border-green-600 text-green-600 rounded-lg font-semibold hover:bg-green-600 hover:text-white transition-colors duration-300 flex items-center justify-center">
                                Lihat Kategori
                            </a>
                        </div>

                        <!-- Total Preview -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">Total Estimasi:</span>
                                <span id="totalPrice" class="text-xl font-bold text-green-600">
                                    Rp {{ number_format($product->harga * $product->minimal_pemesanan, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center gap-2 text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="font-medium">Stok Habis</span>
                        </div>
                        <p class="text-red-600 text-sm mt-1">Produk ini sedang tidak tersedia. Silakan hubungi kami untuk informasi lebih lanjut.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="py-16 bg-gradient-to-r from-green-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Produk Sejenis</h2>
                <p class="text-gray-600 text-lg">Produk lainnya dari kategori {{ $product->kategori->nama_kategori }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($relatedProducts as $related)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                    <div class="relative overflow-hidden">
                        @if($related->gambarUtama)
                        <img src="{{ Storage::url($related->gambarUtama->path_gambar) }}" 
                             alt="{{ $related->nama_produk }}" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                        <div class="w-full h-48 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                        
                        <!-- Stock Badge -->
                        <div class="absolute top-3 right-3">
                            @if($related->stok > 0)
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Tersedia
                            </span>
                            @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Habis
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">
                            {{ $related->nama_produk }}
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $related->deskripsi }}
                        </p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-xl font-bold text-green-600">
                                Rp {{ number_format($related->harga, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Stok: {{ $related->stok }}
                            </div>
                        </div>
                        
                        <a href="{{ route('customer.product', $related->id) }}" 
                           class="block w-full bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors duration-300 text-center">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Image gallery
function changeMainImage(imageSrc) {
    document.getElementById('mainImage').src = imageSrc;
}

// Quantity controls
function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const minQuantity = parseInt(quantityInput.getAttribute('min'));
    const currentQuantity = parseInt(quantityInput.value);
    
    if (currentQuantity > minQuantity) {
        quantityInput.value = currentQuantity - 1;
        updateTotalPrice();
    }
}

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const maxQuantity = parseInt(quantityInput.getAttribute('max'));
    const currentQuantity = parseInt(quantityInput.value);
    
    if (currentQuantity < maxQuantity) {
        quantityInput.value = currentQuantity + 1;
        updateTotalPrice();
    }
}

// Update total price
function updateTotalPrice() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const price = {{ $product->harga }};
    const total = quantity * price;
    
    document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Listen for quantity input changes
document.getElementById('quantity').addEventListener('input', function() {
    const minQuantity = parseInt(this.getAttribute('min'));
    const maxQuantity = parseInt(this.getAttribute('max'));
    let currentQuantity = parseInt(this.value);
    
    if (currentQuantity < minQuantity) {
        this.value = minQuantity;
    } else if (currentQuantity > maxQuantity) {
        this.value = maxQuantity;
    }
    
    updateTotalPrice();
});

// Form submission handling
document.querySelector('form[action*="cart/add"]').addEventListener('submit', function(e) {
    const submitButton = this.querySelector('button[type="submit"]');
    const originalContent = submitButton.innerHTML;
    
    submitButton.innerHTML = '<svg class="w-5 h-5 animate-spin mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
    submitButton.disabled = true;
    
    setTimeout(() => {
        submitButton.innerHTML = originalContent;
        submitButton.disabled = false;
    }, 2000);
});
</script>
@endpush