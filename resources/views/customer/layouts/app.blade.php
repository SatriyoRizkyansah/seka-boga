<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Seka Boga Catering')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .floating-sidebar {
            position: fixed;
            right: -320px;
            top: 0;
            width: 320px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.15);
            transition: right 0.3s ease;
            z-index: 1000;
        }
        
        .floating-sidebar.open {
            right: 0;
        }
        
        .floating-sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .floating-sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .floating-btn {
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3);
            cursor: pointer;
            z-index: 998;
            transition: all 0.3s ease;
        }
        
        .floating-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 35px rgba(34, 197, 94, 0.4);
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
        
        .category-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3);
        }
        
        .btn-secondary {
            background: white;
            color: #374151;
            padding: 12px 24px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-secondary:hover {
            border-color: #22c55e;
            color: #22c55e;
        }
        
        .navbar-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="navbar-glass sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('customer.home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                            <i class="fas fa-utensils text-white"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Seka Boga</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('customer.home') }}" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
                        Beranda
                    </a>
                    
                    <!-- Categories Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-700 hover:text-green-600 font-medium transition-colors flex items-center">
                            Kategori
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute top-full left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border">
                            @php
                                $navCategories = \App\Models\Kategori::where('aktif', true)->get();
                            @endphp
                            @foreach($navCategories as $category)
                                <a href="{{ route('customer.category', $category->id) }}" 
                                   class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                                    {{ $category->nama_kategori }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('customer.cart') }}" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
                            Keranjang
                        </a>
                    @endauth
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm">Daftar</a>
                    @endguest

                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-green-600">
                                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <span class="font-medium">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute top-full right-0 mt-1 w-48 bg-white rounded-lg shadow-lg border">
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600">
                                    Profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600">
                                    Pesanan Saya
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Floating Action Button -->
    @auth
    <div class="floating-btn" onclick="toggleSidebar()" id="floatingBtn">
        <i class="fas fa-shopping-cart"></i>
        <div class="cart-badge" id="cartBadge">{{ $cartCount ?? 0 }}</div>
    </div>
    @endauth

    <!-- Floating Sidebar -->
    <div class="floating-sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <div class="floating-sidebar" id="floatingSidebar">
        <div class="p-6 h-full flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Menu</h3>
                <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-3 mb-6">
                <a href="{{ route('customer.cart') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-green-600"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Keranjang</div>
                        <div class="text-sm text-gray-500"><span id="sidebarCartCount">{{ $cartCount ?? 0 }}</span> item</div>
                    </div>
                </a>

                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-list-alt text-blue-600"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Pesanan Saya</div>
                        <div class="text-sm text-gray-500">Lihat status pesanan</div>
                    </div>
                </a>

                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-yellow-600"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Profil</div>
                        <div class="text-sm text-gray-500">Pengaturan akun</div>
                    </div>
                </a>
            </div>

            <!-- Categories -->
            <div class="mb-6">
                <h4 class="font-semibold text-gray-900 mb-3">Kategori</h4>
                <div class="space-y-2">
                    @php
                        $sidebarCategories = \App\Models\Kategori::where('aktif', true)->take(5)->get();
                    @endphp
                    @foreach($sidebarCategories as $category)
                        <a href="{{ route('customer.category', $category->id) }}" 
                           class="block p-2 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                            {{ $category->nama_kategori }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-auto pt-6 border-t">
                <div class="text-center text-sm text-gray-500">
                    <p>&copy; 2024 Seka Boga Catering</p>
                    <p class="mt-1">Melayani dengan sepenuh hati</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                            <i class="fas fa-utensils text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Seka Boga Catering</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Menyajikan hidangan berkualitas dengan cita rasa terbaik untuk acara spesial Anda.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('customer.home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            <span>+62 123 456 789</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>info@sekaboga.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span>Jakarta, Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Seka Boga Catering. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Floating Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('floatingSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        // Update cart count
        function updateCartCount(count) {
            document.getElementById('cartBadge').textContent = count;
            document.getElementById('sidebarCartCount').textContent = count;
        }

        // Add to Cart
        function addToCart(productId, quantity = 1) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cartCount);
                    
                    // Show success message
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    toast.innerHTML = '<i class="fas fa-check mr-2"></i>' + data.message;
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }

        // Set CSRF token for AJAX requests
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        }
    </script>

    @stack('scripts')
</body>
</html>