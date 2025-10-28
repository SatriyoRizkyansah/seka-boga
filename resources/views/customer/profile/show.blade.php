@extends('customer.layouts.app')

@section('title', 'Profil Saya - Seka Boga Catering')

@section('content')
<div class="bg-gradient-to-br from-green-50 to-white min-h-screen">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h1 class="text-3xl md:text-5xl font-bold mb-4">Profil Saya</h1>
                <p class="text-xl mb-6 opacity-90">Kelola informasi profil dan akun Anda</p>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <section class="py-12">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <!-- Success Message -->
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Profile Navigation -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <div class="text-center mb-6">
                                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                                <p class="text-gray-600">{{ $user->email }}</p>
                            </div>

                            <nav class="space-y-2">
                                <a href="{{ route('customer.profile.show') }}" 
                                   class="flex items-center gap-3 px-4 py-3 text-green-600 bg-green-50 rounded-lg font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Informasi Profil
                                </a>
                                <a href="{{ route('customer.profile.password') }}" 
                                   class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                    Ubah Password
                                </a>
                                <a href="{{ route('customer.cart') }}" 
                                   class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                    </svg>
                                    Keranjang Belanja
                                </a>
                                <a href="#" 
                                   class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Riwayat Pesanan
                                </a>
                            </nav>
                        </div>
                    </div>

                    <!-- Profile Information -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-800">Informasi Profil</h2>
                                <a href="{{ route('customer.profile.edit') }}" 
                                   class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors duration-300 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Profil
                                </a>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Personal Information -->
                                <div class="space-y-4">
                                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Personal</h3>
                                    
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                                            <p class="text-gray-800 font-medium">{{ $user->name ?: '-' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Email</label>
                                            <p class="text-gray-800 font-medium">{{ $user->email }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Nomor Telepon</label>
                                            <p class="text-gray-800 font-medium">{{ $user->nomor_telepon ?: '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Information -->
                                <div class="space-y-4">
                                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Alamat</h3>
                                    
                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Alamat Lengkap</label>
                                            <p class="text-gray-800 font-medium">{{ $user->alamat_lengkap ?: '-' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Kota</label>
                                            <p class="text-gray-800 font-medium">{{ $user->kota ?: '-' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Provinsi</label>
                                            <p class="text-gray-800 font-medium">{{ $user->provinsi ?: '-' }}</p>
                                        </div>
                                        
                                        <div>
                                            <label class="text-sm font-medium text-gray-600">Kode Pos</label>
                                            <p class="text-gray-800 font-medium">{{ $user->kode_pos ?: '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Information -->
                            <div class="mt-8 pt-6 border-t">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Akun</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Terdaftar Sejak</label>
                                        <p class="text-gray-800 font-medium">{{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-600">Status Akun</label>
                                        <p class="text-gray-800 font-medium">
                                            @if($user->aktif)
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Aktif
                                            </span>
                                            @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Tidak Aktif
                                            </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection