@extends('admin.layout.app')

@section('title', 'Edit Produk')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Edit Produk</h1>
        <a href="{{ route('admin.produk.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow rounded-lg">
    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="px-4 py-5 sm:p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="space-y-6">
                <!-- Nama Produk -->
                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama_produk" 
                           id="nama_produk" 
                           value="{{ old('nama_produk', $produk->nama_produk) }}"
                           class="input-field @error('nama_produk') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                           placeholder="Masukkan nama produk"
                           required>
                    @error('nama_produk')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori_produk_id" 
                            id="kategori_id" 
                            class="input-field @error('kategori_produk_id') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_produk_id', $produk->kategori_produk_id) == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_produk_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" 
                               name="harga" 
                               id="harga" 
                               value="{{ old('harga', $produk->harga) }}"
                               class="input-field pl-12 @error('harga') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="0"
                               min="0"
                               step="100"
                               required>
                    </div>
                    @error('harga')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="stok" 
                           id="stok" 
                           value="{{ old('stok', $produk->stok) }}"
                           class="input-field @error('stok') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                           placeholder="0"
                           min="0"
                           required>
                    @error('stok')
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
                               {{ old('aktif', $produk->aktif) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                        <label for="aktif" class="ml-2 text-sm text-gray-700">
                            Produk Aktif
                        </label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Centang untuk mengaktifkan produk ini.</p>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-6">
                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" 
                              id="deskripsi" 
                              rows="6"
                              class="input-field @error('deskripsi') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                              placeholder="Masukkan deskripsi produk">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar Saat Ini -->
                @if($produk->gambar->count() > 0)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Saat Ini
                    </label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($produk->gambar as $gambar)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $gambar->path_gambar) }}" 
                                     alt="Gambar {{ $produk->nama_produk }}"
                                     class="w-full h-24 object-cover rounded-lg">
                                <button type="button" 
                                        onclick="deleteImage({{ $gambar->id }})"
                                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700">
                                    ×
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Gambar Baru -->
                <div>
                    <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $produk->gambar->count() > 0 ? 'Tambah Gambar' : 'Gambar Produk' }}
                    </label>
                    <input type="file" 
                           name="gambar[]" 
                           id="gambar" 
                           accept="image/*"
                           multiple
                           class="input-field @error('gambar') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                           onchange="previewImages(this)">
                    <p class="mt-1 text-sm text-gray-500">
                        Format: JPEG, PNG, JPG, GIF. Maksimal 2MB per gambar. 
                        <br>Anda dapat memilih beberapa gambar sekaligus.
                    </p>
                    @error('gambar')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('gambar.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <!-- Preview Images -->
                    <div id="imagePreview" class="mt-4 grid-cols-2 gap-4 hidden"></div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.produk.index') }}" class="btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                Update Produk
            </button>
        </div>
    </form>
</div>

<script>
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    preview.classList.add('hidden');
    preview.classList.remove('grid');
    
    if (input.files && input.files.length > 0) {
        preview.classList.remove('hidden');
        preview.classList.add('grid');
        
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Preview ${index + 1}"
                             class="w-full h-32 object-cover rounded-lg">
                        <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                            ${index + 1}
                        </div>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

function deleteImage(imageId) {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
        fetch(`/admin/produk/{{ $produk->id }}/gambar/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Terjadi kesalahan saat menghapus gambar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus gambar');
        });
    }
}

// Format number input for harga
document.getElementById('harga').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value) {
        e.target.value = parseInt(value);
    }
});
</script>
@endsection