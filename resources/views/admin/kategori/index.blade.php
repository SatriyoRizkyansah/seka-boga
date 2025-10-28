@extends('admin.layout.app')

@section('title', 'Kategori Produk')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Kategori Produk</h1>
        <a href="{{ route('admin.kategori.create') }}" class="btn-primary">
            Tambah Kategori
        </a>
    </div>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        @if($kategoris->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($kategoris as $kategori)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($kategori->gambar_kategori)
                                        <img class="h-10 w-10 rounded-lg mr-3 object-cover" src="{{ Storage::url($kategori->gambar_kategori) }}" alt="{{ $kategori->nama_kategori }}">
                                    @else
                                        <div class="h-10 w-10 rounded-lg mr-3 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500 text-xs">No Img</span>
                                        </div>
                                    @endif
                                    <div class="text-sm font-medium text-gray-900">{{ $kategori->nama_kategori }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ Str::limit($kategori->deskripsi, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $kategori->produk_count ?? $kategori->produk->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($kategori->aktif)
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
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.kategori.show', $kategori) }}" class="text-green-600 hover:text-green-900">Lihat</a>
                                    <a href="{{ route('admin.kategori.edit', $kategori) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $kategoris->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kategori</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat kategori produk baru.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.kategori.create') }}" class="btn-primary">
                        Tambah Kategori
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection