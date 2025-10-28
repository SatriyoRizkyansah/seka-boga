@extends('admin.layout.app')

@section('title', 'Dashboard Admin')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <div class="text-sm text-gray-500">
            Selamat datang, {{ Auth::user()->name }}!
        </div>
    </div>
@endsection

@section('content')
<!-- Statistik Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Penjualan -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Penjualan</dt>
                        <dd class="text-lg font-medium text-gray-900">Rp {{ number_format($stats['total_penjualan'], 0, ',', '.') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Bulan Ini -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pesanan Bulan Ini</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['pesanan_bulan_ini'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Aktif -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Menu Aktif</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['menu_aktif'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pelanggan -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Pelanggan</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['total_pelanggan'] }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Pesanan Terbaru -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Pesanan Terbaru</h3>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse($pesanan_terbaru as $pesanan)
                    <li class="py-3">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">{{ substr($pesanan->kode_pesanan, -3) }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $pesanan->kode_pesanan }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $pesanan->user->name }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $pesanan->formatHarga() }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    @if($pesanan->status_pesanan == 'menunggu_pembayaran')
                                        <span class="text-yellow-600">Menunggu Pembayaran</span>
                                    @elseif($pesanan->status_pesanan == 'dibayar')
                                        <span class="text-blue-600">Dibayar</span>
                                    @elseif($pesanan->status_pesanan == 'diproses')
                                        <span class="text-purple-600">Diproses</span>
                                    @elseif($pesanan->status_pesanan == 'dikirim')
                                        <span class="text-indigo-600">Dikirim</span>
                                    @elseif($pesanan->status_pesanan == 'selesai')
                                        <span class="text-green-600">Selesai</span>
                                    @else
                                        <span class="text-red-600">{{ ucfirst($pesanan->status_pesanan) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="py-4 text-center text-gray-500">
                        Belum ada pesanan
                    </li>
                    @endforelse
                </ul>
            </div>
            @if($pesanan_terbaru->count() > 0)
            <div class="mt-4">
                <a href="{{ route('admin.pesanan.index') }}" class="text-sm text-green-600 hover:text-green-500">
                    Lihat semua pesanan →
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Menu Populer -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Menu Populer</h3>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse($menu_populer as $produk)
                    <li class="py-3">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                @if($produk->gambarUtama)
                                    <img class="w-12 h-12 rounded-lg object-cover mr-3" 
                                         src="{{ Storage::url($produk->gambarUtama->file_path) }}" 
                                         alt="{{ $produk->nama_produk }}">
                                @else
                                    <div class="h-10 w-10 bg-gray-300 rounded-full flex items-center justify-center">
                                        <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z"/>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $produk->nama_produk }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $produk->formatHarga() }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $produk->detail_pesanan_count }} pesanan
                                </p>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="py-4 text-center text-gray-500">
                        Belum ada data pesanan
                    </li>
                    @endforelse
                </ul>
            </div>
            @if($menu_populer->count() > 0)
            <div class="mt-4">
                <a href="{{ route('admin.produk.index') }}" class="text-sm text-green-600 hover:text-green-500">
                    Kelola menu →
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection