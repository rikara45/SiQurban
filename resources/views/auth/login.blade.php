<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Masuk - SiQurban</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; }
            .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
            .glass { backdrop-filter: blur(16px); background: rgba(255, 255, 255, 0.1); }
            .animate-float { animation: float 6s ease-in-out infinite; }
            @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
            .input-focus:focus { box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1); }
        </style>
    </head>
    <body class="gradient-bg min-h-screen">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-32 w-80 h-80 bg-white opacity-10 rounded-full animate-float"></div>
            <div class="absolute top-20 -left-20 w-60 h-60 bg-white opacity-5 rounded-full animate-float" style="animation-delay: -2s;"></div>
            <div class="absolute bottom-20 right-20 w-40 h-40 bg-white opacity-10 rounded-full animate-float" style="animation-delay: -4s;"></div>
        </div>

        <div class="relative z-10 min-h-screen flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-md">
                <!-- Header -->
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-white">SiQurban</h1>
                    </a>
                    <h2 class="text-2xl font-bold text-white mb-2">Selamat Datang Kembali</h2>
                    <p class="text-white text-opacity-80">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <!-- Login Form -->
                <div class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white border-opacity-20">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-300 bg-green-500 bg-opacity-20 p-3 rounded-lg border border-green-400 border-opacity-30">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-white mb-2">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input id="email" 
                                       name="email" 
                                       type="email" 
                                       autocomplete="username"
                                       required 
                                       autofocus
                                       value="{{ old('email') }}"
                                       class="input-focus block w-full pl-10 pr-3 py-3 border border-white border-opacity-30 rounded-xl bg-white bg-opacity-20 text-white placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200"
                                       placeholder="nama@email.com">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-white mb-2">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input id="password" 
                                       name="password" 
                                       type="password" 
                                       autocomplete="current-password"
                                       required
                                       class="input-focus block w-full pl-10 pr-3 py-3 border border-white border-opacity-30 rounded-xl bg-white bg-opacity-20 text-white placeholder-white placeholder-opacity-70 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200"
                                       placeholder="Masukkan kata sandi">
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center">
                                <input id="remember_me" 
                                       name="remember" 
                                       type="checkbox" 
                                       class="h-4 w-4 text-purple-600 focus:ring-purple-500 rounded bg-white bg-opacity-20 border-white border-opacity-30">
                                <span class="ml-2 text-sm text-white text-opacity-90">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" 
                                   class="text-sm text-white text-opacity-90 hover:text-white transition-colors duration-200">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-400 to-pink-500 hover:from-orange-500 hover:to-pink-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2 focus:ring-offset-transparent">
                            <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Masuk ke Akun
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white border-opacity-30"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-transparent text-white text-opacity-70">atau</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-white text-opacity-90 text-sm">
                            Belum punya akun?
                            <a href="{{ route('register') }}" 
                               class="font-medium text-white hover:text-yellow-300 transition-colors duration-200 ml-1">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-6">
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center text-white text-opacity-80 hover:text-white transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Scripts for enhanced UX -->
        <script>
            // Add floating label effect
            document.querySelectorAll('input[type="email"], input[type="password"]').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });
            });

            // Form validation feedback
            document.querySelector('form').addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = `
                    <svg class="animate-spin inline w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                `;
                submitBtn.disabled = true;
            });
        </script>
    </body>
</html>