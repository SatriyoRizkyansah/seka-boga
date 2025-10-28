@extends('customer.layouts.app')

@section('title', 'Edit Profil - Seka Boga Catering')

@section('content')
<div class="bg-gradient-to-br from-green-50 to-white min-h-screen">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h1 class="text-3xl md:text-5xl font-bold mb-4">Edit Profil</h1>
                <p class="text-xl mb-6 opacity-90">Perbarui informasi profil Anda</p>
                <a href="{{ route('customer.profile.show') }}" 
                   class="inline-flex items-center gap-2 text-white hover:text-green-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <section class="py-12">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">Informasi Personal</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror"
                                           required>
                                    @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror"
                                           required>
                                    @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone Number -->
                                <div class="md:col-span-2">
                                    <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon
                                    </label>
                                    <input type="text" 
                                           id="nomor_telepon" 
                                           name="nomor_telepon" 
                                           value="{{ old('nomor_telepon', $user->nomor_telepon) }}" 
                                           placeholder="Contoh: 08123456789"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('nomor_telepon') border-red-500 @enderror">
                                    @error('nomor_telepon')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-2">Informasi Alamat</h3>
                            
                            <div class="space-y-6">
                                <!-- Full Address -->
                                <div>
                                    <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat Lengkap
                                    </label>
                                    <textarea id="alamat_lengkap" 
                                              name="alamat_lengkap" 
                                              rows="3"
                                              placeholder="Masukkan alamat lengkap termasuk nomor rumah, nama jalan, RT/RW"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none @error('alamat_lengkap') border-red-500 @enderror">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
                                    @error('alamat_lengkap')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- City -->
                                    <div>
                                        <label for="kota" class="block text-sm font-medium text-gray-700 mb-2">
                                            Kota
                                        </label>
                                        <input type="text" 
                                               id="kota" 
                                               name="kota" 
                                               value="{{ old('kota', $user->kota) }}" 
                                               placeholder="Contoh: Jakarta"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('kota') border-red-500 @enderror">
                                        @error('kota')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Province -->
                                    <div>
                                        <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-2">
                                            Provinsi
                                        </label>
                                        <input type="text" 
                                               id="provinsi" 
                                               name="provinsi" 
                                               value="{{ old('provinsi', $user->provinsi) }}" 
                                               placeholder="Contoh: DKI Jakarta"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('provinsi') border-red-500 @enderror">
                                        @error('provinsi')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Postal Code -->
                                    <div>
                                        <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-2">
                                            Kode Pos
                                        </label>
                                        <input type="text" 
                                               id="kode_pos" 
                                               name="kode_pos" 
                                               value="{{ old('kode_pos', $user->kode_pos) }}" 
                                               placeholder="Contoh: 12345"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('kode_pos') border-red-500 @enderror">
                                        @error('kode_pos')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-end">
                            <a href="{{ route('customer.profile.show') }}" 
                               class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors duration-300 text-center">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
// Auto format phone number
document.getElementById('nomor_telepon').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
    
    // Add +62 prefix if starts with 0
    if (value.startsWith('0')) {
        value = '62' + value.substring(1);
    }
    
    // Format: +62 812-3456-7890
    if (value.length > 2) {
        if (value.length <= 5) {
            value = value.replace(/(\d{2})(\d+)/, '+$1 $2');
        } else if (value.length <= 9) {
            value = value.replace(/(\d{2})(\d{3})(\d+)/, '+$1 $2-$3');
        } else {
            value = value.replace(/(\d{2})(\d{3})(\d{4})(\d+)/, '+$1 $2-$3-$4');
        }
    }
    
    e.target.value = value;
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    
    if (!name) {
        alert('Nama lengkap harus diisi');
        e.preventDefault();
        return;
    }
    
    if (!email) {
        alert('Email harus diisi');
        e.preventDefault();
        return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Format email tidak valid');
        e.preventDefault();
        return;
    }
});
</script>
@endpush