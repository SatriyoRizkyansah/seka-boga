<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Seka Boga Catering Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <!-- Top Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo and Main Navigation -->
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-green-700 text-xl font-bold flex items-center">
                            <span class="text-2xl mr-2">🍽️</span>
                            Seka Boga Admin
                        </h1>
                    </div>

                    <!-- Desktop Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('dashboard') }}" 
                           class="border-green-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="#" 
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Menu Makanan
                        </a>
                        <a href="#" 
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Kategori
                        </a>
                        <a href="#" 
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Pesanan
                        </a>
                        <a href="#" 
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Pelanggan
                        </a>
                        <a href="#" 
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Laporan
                        </a>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = ! open" 
                                    class="bg-white flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <span class="sr-only">Open user menu</span>
                                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-medium">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            </button>
                        </div>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                            
                            <div class="px-4 py-2 text-xs text-gray-400">
                                {{ Auth::user()->email }}
                            </div>
                            
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="sm:hidden flex items-center">
                    <button @click="mobileMenuOpen = ! mobileMenuOpen" 
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': mobileMenuOpen, 'inline-flex': ! mobileMenuOpen }" 
                                  class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! mobileMenuOpen, 'inline-flex': mobileMenuOpen }" 
                                  class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="bg-green-50 border-green-500 text-green-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Dashboard
                </a>
                <a href="#" 
                   class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Menu Makanan
                </a>
                <a href="#" 
                   class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Kategori
                </a>
                <a href="#" 
                   class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Pesanan
                </a>
                <a href="#" 
                   class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Pelanggan
                </a>
                <a href="#" 
                   class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Laporan
                </a>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white font-medium">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="dashboard-card">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Penjualan</p>
                        <p class="text-2xl font-semibold text-gray-900">Rp 12.500.000</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pesanan Bulan Ini</p>
                        <p class="text-2xl font-semibold text-gray-900">156</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Menu Aktif</p>
                        <p class="text-2xl font-semibold text-gray-900">48</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pelanggan</p>
                        <p class="text-2xl font-semibold text-gray-900">1.234</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="dashboard-card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pesanan Terbaru</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">#ORD-001</p>
                            <p class="text-sm text-gray-600">Paket Nasi Box Ayam</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Selesai</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">#ORD-002</p>
                            <p class="text-sm text-gray-600">Catering Wedding 100 Pax</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Proses</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">#ORD-003</p>
                            <p class="text-sm text-gray-600">Snack Box Meeting</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Baru</span>
                    </div>
                </div>
            </div>

            <div class="dashboard-card">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Populer</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                                🍛
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">Nasi Box Ayam Geprek</p>
                                <p class="text-sm text-gray-600">89 pesanan</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                                🍲
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">Paket Catering Premium</p>
                                <p class="text-sm text-gray-600">67 pesanan</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                                🥙
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">Snack Box Deluxe</p>
                                <p class="text-sm text-gray-600">54 pesanan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="dashboard-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Penjualan</p>
                            <p class="text-2xl font-semibold text-gray-900">Rp 12.500.000</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pesanan Bulan Ini</p>
                            <p class="text-2xl font-semibold text-gray-900">156</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Menu Aktif</p>
                            <p class="text-2xl font-semibold text-gray-900">48</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Pelanggan</p>
                            <p class="text-2xl font-semibold text-gray-900">1.234</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="dashboard-card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pesanan Terbaru</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">#ORD-001</p>
                                <p class="text-sm text-gray-600">Paket Nasi Box Ayam</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Selesai</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">#ORD-002</p>
                                <p class="text-sm text-gray-600">Catering Wedding 100 Pax</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Proses</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">#ORD-003</p>
                                <p class="text-sm text-gray-600">Snack Box Meeting</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Baru</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Populer</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                                    🍛
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Nasi Box Ayam Geprek</p>
                                    <p class="text-sm text-gray-600">89 pesanan</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                                    🍲
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Paket Catering Premium</p>
                                    <p class="text-sm text-gray-600">67 pesanan</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                                    🥙
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Snack Box Deluxe</p>
                                    <p class="text-sm text-gray-600">54 pesanan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
