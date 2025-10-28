@extends('admin.layout.app')

@section('title', 'Edit Kategori Produk')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Edit Kategori Produk</h1>
        <a href="{{ route('admin.kategori.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow rounded-lg">
    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data" class="px-4 py-5 sm:p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Nama Kategori -->
            <div>
                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama_kategori" 
                       id="nama_kategori" 
                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                       class="input-field @error('nama_kategori') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                       placeholder="Masukkan nama kategori"
                       required>
                @error('nama_kategori')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea name="deskripsi" 
                          id="deskripsi" 
                          rows="4"
                          class="input-field @error('deskripsi') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                          placeholder="Masukkan deskripsi kategori">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar Kategori - Hidden -->
            {{-- @if($kategori->gambar_kategori)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Saat Ini
                </label>
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $kategori->gambar_kategori) }}" 
                         alt="{{ $kategori->nama_kategori }}"
                         class="h-20 w-20 object-cover rounded-lg">
                    <div>
                        <p class="text-sm text-gray-600">{{ basename($kategori->gambar_kategori) }}</p>
                        <p class="text-xs text-gray-500">Unggah gambar baru untuk mengganti</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Gambar Kategori Baru -->
            <div>
                <label for="gambar_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $kategori->gambar_kategori ? 'Ganti Gambar Kategori' : 'Gambar Kategori' }}
                </label>
                <input type="file" 
                       name="gambar_kategori" 
                       id="gambar_kategori" 
                       accept="image/*"
                       class="input-field @error('gambar_kategori') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</p>
                @error('gambar_kategori')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}

            <!-- Status Aktif -->
            <div>
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="aktif" 
                           id="aktif" 
                           value="1"
                           {{ old('aktif', $kategori->aktif) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                    <label for="aktif" class="ml-2 text-sm text-gray-700">
                        Kategori Aktif
                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-500">Centang untuk mengaktifkan kategori ini.</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.kategori.index') }}" class="btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                Update Kategori
            </button>
        </div>
    </form>
</div>
@endsection