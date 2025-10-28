@extends('admin.layout.app')

@section('title', 'Edit Rekening Admin')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Edit Rekening Admin</h1>
        <a href="{{ route('admin.rekening.index') }}" class="btn-secondary">
            Kembali
        </a>
    </div>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow rounded-lg">
    <form action="{{ route('admin.rekening.update', $rekening->id) }}" method="POST" class="px-4 py-5 sm:p-6">
        @csrf
        @method('PUT')
        
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
                    <option value="BCA" {{ old('nama_bank', $rekening->nama_bank) == 'BCA' ? 'selected' : '' }}>BCA</option>
                    <option value="BRI" {{ old('nama_bank', $rekening->nama_bank) == 'BRI' ? 'selected' : '' }}>BRI</option>
                    <option value="BNI" {{ old('nama_bank', $rekening->nama_bank) == 'BNI' ? 'selected' : '' }}>BNI</option>
                    <option value="Mandiri" {{ old('nama_bank', $rekening->nama_bank) == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                    <option value="CIMB Niaga" {{ old('nama_bank', $rekening->nama_bank) == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                    <option value="Danamon" {{ old('nama_bank', $rekening->nama_bank) == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                    <option value="BTN" {{ old('nama_bank', $rekening->nama_bank) == 'BTN' ? 'selected' : '' }}>BTN</option>
                    <option value="Permata" {{ old('nama_bank', $rekening->nama_bank) == 'Permata' ? 'selected' : '' }}>Permata</option>
                    <option value="OCBC NISP" {{ old('nama_bank', $rekening->nama_bank) == 'OCBC NISP' ? 'selected' : '' }}>OCBC NISP</option>
                    <option value="Bank Mega" {{ old('nama_bank', $rekening->nama_bank) == 'Bank Mega' ? 'selected' : '' }}>Bank Mega</option>
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
                       value="{{ old('nomor_rekening', $rekening->nomor_rekening) }}"
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
                <label for="nama_pemilik_rekening" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Pemilik Rekening <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama_pemilik_rekening" 
                       id="nama_pemilik_rekening" 
                       value="{{ old('nama_pemilik_rekening', $rekening->nama_pemilik_rekening) }}"
                       class="input-field @error('nama_pemilik_rekening') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                       placeholder="Masukkan nama pemilik rekening"
                       required>
                @error('nama_pemilik_rekening')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div>
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan
                </label>
                <textarea name="catatan" 
                          id="catatan" 
                          rows="3"
                          class="input-field @error('catatan') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                          placeholder="Masukkan catatan (opsional)">{{ old('catatan', $rekening->catatan) }}</textarea>
                @error('catatan')
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
                           {{ old('aktif', $rekening->aktif) ? 'checked' : '' }}
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
                Update Rekening
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
document.getElementById('nama_pemilik_rekening').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>
@endsection