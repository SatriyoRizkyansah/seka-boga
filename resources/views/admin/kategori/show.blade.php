@extends('admin.layout.app')

@section('title', 'Detail Kategori Produk')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Kategori Produk</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="btn-primary">
                Edit Kategori
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="btn-secondary">
                Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Detail Kategori -->
    <div class="lg:col-span-2">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Nama Kategori -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Kategori</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $kategori->nama_kategori }}</dd>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                        <dd class="mt-1 text-gray-900">
                            {{ $kategori->deskripsi ?: 'Tidak ada deskripsi' }}
                        </dd>
                    </div>

                    <!-- Status -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            @if($kategori->aktif)
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
                        </dd>
                    </div>

                    <!-- Jumlah Produk -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jumlah Produk</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $kategori->produk_count }} produk</dd>
                    </div>

                    <!-- Tanggal Dibuat -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Dibuat Pada</dt>
                        <dd class="mt-1 text-gray-900">{{ $kategori->created_at->format('d M Y, H:i') }}</dd>
                    </div>

                    <!-- Tanggal Diperbarui -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                        <dd class="mt-1 text-gray-900">{{ $kategori->updated_at->format('d M Y, H:i') }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gambar Kategori -->
    <div class="lg:col-span-1">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Gambar Kategori</h3>
                @if($kategori->gambar_kategori)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $kategori->gambar_kategori) }}" 
                             alt="{{ $kategori->nama_kategori }}"
                             class="w-full h-48 object-cover rounded-lg mb-3">
                        <p class="text-sm text-gray-500">{{ basename($kategori->gambar_kategori) }}</p>
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

<!-- Daftar Produk dalam Kategori -->
@if($kategori->produk_count > 0)
<div class="mt-6">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Produk dalam Kategori Ini</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stok
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($kategori->produk as $produk)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($produk->gambar->first())
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ asset('storage/' . $produk->gambar->first()->path_gambar) }}" 
                                                 alt="{{ $produk->nama_produk }}">
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $produk->nama_produk }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $produk->formatHarga() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $produk->stok }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($produk->aktif)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.produk.show', $produk->id) }}" class="text-green-600 hover:text-green-900">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Belum ada produk dalam kategori ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Action Buttons -->
<div class="mt-6 flex items-center justify-between">
    <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" 
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Aksi ini tidak dapat dibatalkan.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-danger">
            Hapus Kategori
        </button>
    </form>
    
    <div class="flex space-x-3">
        <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="btn-primary">
            Edit Kategori
        </a>
        <a href="{{ route('admin.kategori.index') }}" class="btn-secondary">
            Kembali ke Daftar
        </a>
    </div>
</div>
@endsection