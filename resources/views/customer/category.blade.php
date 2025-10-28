@extends('customer.layouts.app')

@section('title', $category->nama_kategori . ' - Seka Boga Catering')

@section('content')
<div class="bg-gradient-to-br from-green-50 to-white min-h-screen">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h1 class="text-3xl md:text-5xl font-bold mb-4">{{ $category->nama_kategori }}</h1>
                @if($category->deskripsi)
                <p class="text-xl mb-6 opacity-90">{{ $category->deskripsi }}</p>
                @endif
                <div class="flex items-center justify-center gap-4 text-sm">
                    <span class="bg-white/20 px-4 py-2 rounded-full">
                        {{ $products->total() }} Produk Tersedia
                    </span>
                    <a href="{{ route('customer.home') }}" 
                       class="hover:bg-white/20 px-4 py-2 rounded-full transition-colors duration-300 inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                    <div class="relative overflow-hidden">
                        @if($product->gambarUtama)
                        <img src="{{ Storage::url($product->gambarUtama->path_gambar) }}" 
                             alt="{{ $product->nama_produk }}" 
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
                            @if($product->stok > 0)
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Tersedia
                            </span>
                            @else
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                Habis
                            </span>
                            @endif
                        </div>

                        <!-- Minimal Order Badge -->
                        @if($product->minimal_pemesanan > 1)
                        <div class="absolute top-3 left-3">
                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-medium">
                                Min {{ $product->minimal_pemesanan }} {{ $product->satuan }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">
                            {{ $product->nama_produk }}
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $product->deskripsi }}
                        </p>

                        @if($product->bahan_utama)
                        <div class="mb-4">
                            <span class="text-xs text-gray-500 font-medium">Bahan Utama:</span>
                            <p class="text-sm text-gray-600 line-clamp-1">{{ $product->bahan_utama }}</p>
                        </div>
                        @endif
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-2xl font-bold text-green-600">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Stok: {{ $product->stok }} {{ $product->satuan }}
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('customer.product', $product->id) }}" 
                               class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors duration-300 text-center">
                                Lihat Detail
                            </a>
                            @if($product->stok > 0)
                            <form action="{{ route('customer.cart.add', $product->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="quantity" value="{{ $product->minimal_pemesanan }}">
                                <button type="submit" 
                                        class="bg-white border-2 border-green-600 text-green-600 px-4 py-2 rounded-lg font-medium hover:bg-green-600 hover:text-white transition-colors duration-300"
                                        title="Tambah ke keranjang (Min {{ $product->minimal_pemesanan }} {{ $product->satuan }})">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-12">
                {{ $products->links() }}
            </div>
            @endif

            @else
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Produk</h3>
                <p class="text-gray-500 mb-6">Produk untuk kategori {{ $category->nama_kategori }} belum tersedia</p>
                <a href="{{ route('customer.home') }}" 
                   class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition-colors duration-300 inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Other Categories Section -->
    @if($products->count() > 0)
    <section class="py-16 bg-gradient-to-r from-green-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Kategori Lainnya</h2>
                <p class="text-gray-600 text-lg">Jelajahi kategori makanan catering lainnya</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @php
                    $otherCategories = \App\Models\Kategori::where('aktif', true)
                        ->where('id', '!=', $category->id)
                        ->withCount(['produk' => function ($query) {
                            $query->where('aktif', true)->where('tersedia', true);
                        }])
                        ->orderBy('nama_kategori')
                        ->take(6)
                        ->get();
                @endphp
                
                @foreach($otherCategories as $otherCategory)
                <a href="{{ route('customer.category', $otherCategory->id) }}" 
                   class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center hover:-translate-y-1">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center group-hover:from-green-200 group-hover:to-green-300 transition-colors duration-300">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c1.1045695 0 2 .8954305 2 2v1M7 7l5 5M7 7v10a2 2 0 002 2h8a2 2 0 002-2V7M7 7H5a2 2 0 00-2 2v8a2 2 0 002 2h2m5-13v5a2 2 0 01-2 2H7"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-green-600 transition-colors duration-300 mb-2">
                        {{ $otherCategory->nama_kategori }}
                    </h3>
                    <div class="text-sm text-green-600 font-medium">
                        {{ $otherCategory->produk_count }} Produk
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart notification
    const addToCartForms = document.querySelectorAll('form[action*="cart/add"]');
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const button = form.querySelector('button[type="submit"]');
            const originalContent = button.innerHTML;
            
            button.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
            button.disabled = true;
            
            setTimeout(() => {
                button.innerHTML = originalContent;
                button.disabled = false;
            }, 1000);
        });
    });
});
</script>
@endpush