<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Seka Boga Catering</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-container">
    <div class="auth-card">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <h1 class="auth-logo">🍽️ Seka Boga</h1>
            <p class="auth-subtitle">Admin Dashboard - Buat akun admin baru</p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap
                </label>
                <input id="name" 
                       type="text" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       autofocus 
                       autocomplete="name"
                       class="input-field @error('name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                       placeholder="John Doe">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="username"
                       class="input-field @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                       placeholder="john@sekaboga.com">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="new-password"
                       class="input-field @error('password') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                       placeholder="••••••••">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password
                </label>
                <input id="password_confirmation" 
                       type="password" 
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password"
                       class="input-field @error('password_confirmation') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                       placeholder="••••••••">
                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary w-full">
                Buat Akun Admin
            </button>

            <!-- Login Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" 
                       class="text-green-600 hover:text-green-700 font-medium hover:underline transition-colors duration-200">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </form>
    </div>

    <!-- Background decoration -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-green-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-green-300 rounded-full opacity-20 animate-pulse delay-1000"></div>
    </div>
</body>
</html>
