@extends('admin.layout.app')

@section('title', 'Detail Rekening Admin')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Rekening Admin</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.rekening.edit', $rekening->id) }}" class="btn-primary">
                Edit Rekening
            </a>
            <a href="{{ route('admin.rekening.index') }}" class="btn-secondary">
                Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <div class="grid grid-cols-1 gap-6">
            <!-- Nama Bank -->
            <div>
                <dt class="text-sm font-medium text-gray-500">Nama Bank</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $rekening->nama_bank }}</dd>
            </div>

            <!-- Nomor Rekening -->
            <div>
                <dt class="text-sm font-medium text-gray-500">Nomor Rekening</dt>
                <dd class="mt-1 text-lg font-mono font-semibold text-gray-900">{{ $rekening->nomor_rekening }}</dd>
            </div>

            <!-- Nama Pemilik -->
            <div>
                <dt class="text-sm font-medium text-gray-500">Nama Pemilik Rekening</dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $rekening->nama_pemilik_rekening }}</dd>
            </div>

            <!-- Jenis Rekening -->
            <div>
                <dt class="text-sm font-medium text-gray-500">Jenis Rekening</dt>
                <dd class="mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($rekening->jenis_rekening) }}
                    </span>
                </dd>
            </div>

            <!-- Status -->
            <div>
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1">
                    @if($rekening->aktif)
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

            <!-- Catatan -->
            @if($rekening->catatan)
            <div>
                <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                <dd class="mt-1 text-gray-900">{{ $rekening->catatan }}</dd>
            </div>
            @endif

            <!-- Tanggal Dibuat -->
            <div>
                <dt class="text-sm font-medium text-gray-500">Dibuat Pada</dt>
                <dd class="mt-1 text-gray-900">{{ $rekening->created_at->format('d M Y, H:i') }}</dd>
            </div>

            <!-- Tanggal Diperbarui -->
            <div>
                <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                <dd class="mt-1 text-gray-900">{{ $rekening->updated_at->format('d M Y, H:i') }}</dd>
            </div>
        </div>
    </div>
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
            <h3 class="text-sm font-medium text-blue-800">Informasi Rekening</h3>
            <div class="mt-2 text-sm text-blue-700">
                <p>Rekening ini akan muncul pada halaman checkout untuk menerima pembayaran dari pelanggan. Pastikan informasi rekening akurat dan masih aktif.</p>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="mt-6 flex items-center justify-between">
    <form action="{{ route('admin.rekening.destroy', $rekening->id) }}" method="POST" 
          onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekening ini? Aksi ini tidak dapat dibatalkan.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-danger">
            Hapus Rekening
        </button>
    </form>
    
    <div class="flex space-x-3">
        <a href="{{ route('admin.rekening.edit', $rekening->id) }}" class="btn-primary">
            Edit Rekening
        </a>
        <a href="{{ route('admin.rekening.index') }}" class="btn-secondary">
            Kembali ke Daftar
        </a>
    </div>
</div>
@endsection