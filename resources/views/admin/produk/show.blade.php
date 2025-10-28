@extends('admin.layout.app')

@section('title', 'Detail Produk')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Produk</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn-primary">
                Edit Produk
            </a>
            <a href="{{ route('admin.produk.index') }}" class="btn-secondary">
                Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Produk -->
    <div class="lg:col-span-2">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Nama Produk -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Produk</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $produk->nama_produk }}</dd>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                        <dd class="mt-1 text-gray-900">{{ $produk->kategori->nama_kategori ?? 'N/A' }}</dd>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                        <dd class="mt-1 text-gray-900">
                            {{ $produk->deskripsi ?: 'Tidak ada deskripsi' }}
                        </dd>
                    </div>

                    <!-- Harga -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Harga</dt>
                        <dd class="mt-1 text-lg font-semibold text-green-600">{{ $produk->formatHarga() }}</dd>
                    </div>

                    <!-- Stok -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Stok</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $produk->stok }} {{ $produk->satuan }}</dd>
                    </div>

                    <!-- Minimal Pemesanan -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Minimal Pemesanan</dt>
                        <dd class="mt-1 text-gray-900">{{ $produk->minimal_pemesanan }} {{ $produk->satuan }}</dd>
                    </div>

                    <!-- Bahan Utama -->
                    @if($produk->bahan_utama)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Bahan Utama</dt>
                        <dd class="mt-1 text-gray-900">{{ $produk->bahan_utama }}</dd>
                    </div>
                    @endif

                    <!-- Catatan Khusus -->
                    @if($produk->catatan_khusus)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Catatan Khusus</dt>
                        <dd class="mt-1 text-gray-900">{{ $produk->catatan_khusus }}</dd>
                    </div>
                    @endif

                    <!-- Status -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 flex space-x-2">
                            @if($produk->aktif)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Tidak Aktif
                                </span>
                            @endif

                            @if($produk->tersedia)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Tidak Tersedia
                                </span>
                            @endif
                        </dd>
                    </div>

                    <!-- Tanggal Dibuat -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Dibuat Pada</dt>
                        <dd class="mt-1 text-gray-900">{{ $produk->created_at->format('d M Y, H:i') }}</dd>
                    </div>

                    <!-- Tanggal Diperbarui -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                        <dd class="mt-1 text-gray-900">{{ $produk->updated_at->format('d M Y, H:i') }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gambar Produk -->
    <div class="lg:col-span-1">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Gambar Produk</h3>
                @if($produk->gambar && $produk->gambar->count() > 0)
                    <div class="space-y-4">
                        @foreach($produk->gambar as $index => $gambar)
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $gambar->path_gambar) }}" 
                                     alt="{{ $produk->nama_produk }} - {{ $index + 1 }}"
                                     class="w-full h-48 object-cover rounded-lg mb-2">
                                <p class="text-sm text-gray-500">Gambar {{ $index + 1 }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="mx-auto h-24 w-24 text-gray-300">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Tidak ada gambar</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistik Pesanan -->
<div class="mt-6 bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Pesanan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $produk->detailPesanan->count() }}</div>
                <div class="text-sm text-gray-500">Total Pesanan</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $produk->detailPesanan->sum('jumlah') }}</div>
                <div class="text-sm text-gray-500">Total Kuantitas Terjual</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">
                    Rp {{ number_format($produk->detailPesanan->sum(function($detail) { return $detail->jumlah * $detail->harga_satuan; }), 0, ',', '.') }}
                </div>
                <div class="text-sm text-gray-500">Total Pendapatan</div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="mt-6 flex items-center justify-between">
    <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" 
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Aksi ini tidak dapat dibatalkan.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-danger">
            Hapus Produk
        </button>
    </form>
    
    <div class="flex space-x-3">
        <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn-primary">
            Edit Produk
        </a>
        <a href="{{ route('admin.produk.index') }}" class="btn-secondary">
            Kembali ke Daftar
        </a>
    </div>
</div>
@endsection