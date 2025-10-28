@extends('admin.layout.app')

@section('title', 'Manajemen Rekening Admin')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Rekening Admin</h1>
        <a href="{{ route('admin.rekening.create') }}" class="btn-primary">
            Tambah Rekening
        </a>
    </div>
@endsection

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($rekening->count() > 0)
    <ul class="divide-y divide-gray-200">
        @foreach($rekening as $item)
        <li>
            <div class="px-4 py-4 flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Bank Logo/Icon -->
                    <div class="flex-shrink-0 h-12 w-12">
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Info Rekening -->
                    <div class="ml-4 flex-1">
                        <div class="flex items-center">
                            <h3 class="text-lg font-medium text-gray-900">{{ $item->nama_bank }}</h3>
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->aktif ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                        
                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500">
                            <span class="font-mono font-medium text-gray-900">{{ $item->nomor_rekening }}</span>
                            <span>•</span>
                            <span class="font-medium">{{ $item->nama_pemilik }}</span>
                        </div>
                        
                        @if($item->keterangan)
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $item->keterangan }}
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
                    <a href="{{ route('admin.rekening.show', $item->id) }}" 
                       class="text-gray-600 hover:text-gray-900" title="Lihat Detail">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                    
                    <a href="{{ route('admin.rekening.edit', $item->id) }}" 
                       class="text-green-600 hover:text-green-900" title="Edit">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    
                    <form action="{{ route('admin.rekening.destroy', $item->id) }}" method="POST" class="inline"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekening ini?')">
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
    
    @else
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada rekening</h3>
        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan rekening admin pertama.</p>
        <div class="mt-6">
            <a href="{{ route('admin.rekening.create') }}" class="btn-primary">
                Tambah Rekening
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Info Card -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Informasi Rekening Admin</h3>
            <div class="mt-2 text-sm text-blue-700">
                <p>Rekening admin digunakan untuk menerima pembayaran dari pelanggan. Pastikan informasi rekening yang dimasukkan akurat dan aktif.</p>
            </div>
        </div>
    </div>
</div>
@endsection