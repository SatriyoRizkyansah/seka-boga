@extends('admin.layout.app')

@section('title', 'Tambah Rekening Admin')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Rekening Admin</h1>
        <a href="{{ route('admin.rekening.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow rounded-lg">
    <form action="{{ route('admin.rekening.store') }}" method="POST" class="px-4 py-5 sm:p-6">
        @csrf
        
        <div class="space-y-6">
            <!-- Nama Bank -->
            <div>
                <label for="nama_bank" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Bank <span class="text-red-500">*</span>
                </label>
                <select name="nama_bank" 
                        id="nama_bank" 
                        class="input-field @error('nama_bank') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                        required>
                    <option value="">Pilih Bank</option>
                    <option value="BCA" {{ old('nama_bank') == 'BCA' ? 'selected' : '' }}>BCA</option>
                    <option value="BRI" {{ old('nama_bank') == 'BRI' ? 'selected' : '' }}>BRI</option>
                    <option value="BNI" {{ old('nama_bank') == 'BNI' ? 'selected' : '' }}>BNI</option>
                    <option value="Mandiri" {{ old('nama_bank') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                    <option value="CIMB Niaga" {{ old('nama_bank') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                    <option value="Danamon" {{ old('nama_bank') == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                    <option value="BTN" {{ old('nama_bank') == 'BTN' ? 'selected' : '' }}>BTN</option>
                    <option value="Permata" {{ old('nama_bank') == 'Permata' ? 'selected' : '' }}>Permata</option>
                    <option value="OCBC NISP" {{ old('nama_bank') == 'OCBC NISP' ? 'selected' : '' }}>OCBC NISP</option>
                    <option value="Bank Mega" {{ old('nama_bank') == 'Bank Mega' ? 'selected' : '' }}>Bank Mega</option>
                </select>
                @error('nama_bank')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Rekening -->
            <div>
                <label for="nomor_rekening" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Rekening <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nomor_rekening" 
                       id="nomor_rekening" 
                       value="{{ old('nomor_rekening') }}"
                       class="input-field @error('nomor_rekening') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                       placeholder="Masukkan nomor rekening"
                       maxlength="20"
                       required>
                @error('nomor_rekening')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Pemilik -->
            <div>
                <label for="nama_pemilik" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Pemilik Rekening <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama_pemilik" 
                       id="nama_pemilik" 
                       value="{{ old('nama_pemilik') }}"
                       class="input-field @error('nama_pemilik') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                       placeholder="Masukkan nama pemilik rekening"
                       required>
                @error('nama_pemilik')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                    Keterangan
                </label>
                <textarea name="keterangan" 
                          id="keterangan" 
                          rows="3"
                          class="input-field @error('keterangan') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                          placeholder="Masukkan keterangan (opsional)">{{ old('keterangan') }}</textarea>
                @error('keterangan')
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
                        Rekening Aktif
                    </label>
                </div>
                <p class="mt-1 text-sm text-gray-500">Centang untuk mengaktifkan rekening ini untuk menerima pembayaran.</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.rekening.index') }}" class="btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                Simpan Rekening
            </button>
        </div>
    </form>
</div>

<script>
// Format nomor rekening input
document.getElementById('nomor_rekening').addEventListener('input', function(e) {
    // Remove non-numeric characters
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = value;
});

// Auto uppercase nama pemilik
document.getElementById('nama_pemilik').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>
@endsection