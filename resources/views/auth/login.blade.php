<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Seka Boga Catering</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-container">
    <div class="auth-card">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <h1 class="auth-logo">🍽️ Seka Boga</h1>
            <p class="auth-subtitle">Admin Dashboard - Masuk ke akun Anda</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

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
                       autofocus 
                       autocomplete="username"
                       class="input-field @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                       placeholder="admin@sekaboga.com">
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
                       autocomplete="current-password"
                       class="input-field @error('password') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                       placeholder="••••••••">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="remember" 
                           class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" 
                       class="text-sm text-green-600 hover:text-green-700 hover:underline transition-colors duration-200">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary w-full">
                Masuk ke Dashboard
            </button>

            <!-- Register Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" 
                       class="text-green-600 hover:text-green-700 font-medium hover:underline transition-colors duration-200">
                        Daftar sekarang
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
