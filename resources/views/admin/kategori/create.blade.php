@extends('admin.layout.app')

@section('title', 'Tambah Kategori Produk')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Kategori Produk</h1>
        <a href="{{ route('admin.kategori.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow rounded-lg">
    <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data" class="px-4 py-5 sm:p-6">
        @csrf
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Nama Kategori -->
            <div>
                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama_kategori" 
                       id="nama_kategori" 
                       value="{{ old('nama_kategori') }}"
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
                          placeholder="Masukkan deskripsi kategori">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar Kategori -->
            <div>
                <label for="gambar_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Kategori
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
            </div>

            <!-- Status Aktif -->
            <div>
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="aktif" 
                           id="aktif" 
                           value="1"
                           {{ old('aktif', true) ? 'checked' : '' }}
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
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection