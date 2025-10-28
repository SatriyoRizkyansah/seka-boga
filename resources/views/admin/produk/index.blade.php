@extends('admin.layout.app')

@section('title', 'Manajemen Produk')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Produk</h1>
        <a href="{{ route('admin.produk.create') }}" class="btn-primary">
            Tambah Produk
        </a>
    </div>
@endsection

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <!-- Filter dan Search -->
    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div class="flex space-x-3">
                <select class="input-field max-w-xs" onchange="filterByCategory(this.value)">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                
                <select class="input-field max-w-xs" onchange="filterByStatus(this.value)">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            
            <div class="flex space-x-3">
                <form method="GET" class="flex">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari produk..." 
                           class="input-field rounded-r-none">
                    <button type="submit" class="btn-primary rounded-l-none">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if($produk->count() > 0)
    <ul class="divide-y divide-gray-200">
        @foreach($produk as $item)
        <li>
            <div class="px-4 py-4 flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Gambar Produk -->
                    <div class="flex-shrink-0 h-20 w-20">
                        @if($item->gambar->first())
                            <img class="h-20 w-20 rounded-lg object-cover" 
                                 src="{{ asset('storage/' . $item->gambar->first()->path_gambar) }}" 
                                 alt="{{ $item->nama_produk }}">
                        @else
                            <div class="h-20 w-20 rounded-lg bg-gray-200 flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Info Produk -->
                    <div class="ml-4 flex-1">
                        <div class="flex items-center">
                            <h3 class="text-lg font-medium text-gray-900">{{ $item->nama_produk }}</h3>
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->aktif ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                        
                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                            <span class="font-medium">Kategori: {{ $item->kategori->nama_kategori }}</span>
                            <span>•</span>
                            <span class="font-medium text-green-600">{{ $item->formatHarga() }}</span>
                            <span>•</span>
                            <span>Stok: {{ $item->stok }}</span>
                            <span>•</span>
                            <span>{{ $item->gambar->count() }} gambar</span>
                        </div>
                        
                        @if($item->deskripsi)
                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                            {{ Str::limit($item->deskripsi, 100) }}
                        </p>
                        @endif
                        
                        <!-- Additional Info -->
                        <div class="mt-2 flex items-center space-x-4 text-xs text-gray-400">
                            <span>Dibuat: {{ $item->created_at->format('d M Y') }}</span>
                            @if($item->updated_at != $item->created_at)
                                <span>•</span>
                                <span>Diperbarui: {{ $item->updated_at->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.produk.show', $item->id) }}" 
                       class="text-gray-600 hover:text-gray-900" title="Lihat Detail">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                    
                    <a href="{{ route('admin.produk.edit', $item->id) }}" 
                       class="text-green-600 hover:text-green-900" title="Edit">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    
                    <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" class="inline"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    
    <!-- Pagination -->
    @if($produk->hasPages())
    <div class="px-4 py-3 border-t border-gray-200">
        {{ $produk->links() }}
    </div>
    @endif
    
    @else
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada produk</h3>
        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan produk pertama.</p>
        <div class="mt-6">
            <a href="{{ route('admin.produk.create') }}" class="btn-primary">
                Tambah Produk
            </a>
        </div>
    </div>
    @endif
</div>

<script>
function filterByCategory(categoryId) {
    const url = new URL(window.location);
    if (categoryId) {
        url.searchParams.set('kategori', categoryId);
    } else {
        url.searchParams.delete('kategori');
    }
    window.location = url;
}

function filterByStatus(status) {
    const url = new URL(window.location);
    if (status !== '') {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    window.location = url;
}
</script>
@endsection