<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SiQurban - Platform Jual Beli Hewan Kurban</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; }
            .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
            .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
            .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
            .glass { backdrop-filter: blur(16px); background: rgba(255, 255, 255, 0.1); }
            .animate-float { animation: float 6s ease-in-out infinite; }
            @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        </style>
    </head>
    <body class="bg-gray-50">
        <!-- Hero Section -->
        <div class="gradient-bg min-h-screen relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-32 w-80 h-80 bg-white opacity-10 rounded-full animate-float"></div>
                <div class="absolute top-20 -left-20 w-60 h-60 bg-white opacity-5 rounded-full animate-float" style="animation-delay: -2s;"></div>
                <div class="absolute bottom-20 right-20 w-40 h-40 bg-white opacity-10 rounded-full animate-float" style="animation-delay: -4s;"></div>
            </div>

            <div class="relative z-10">
                {{-- GANTI NAV SEBELUMNYA DENGAN INI --}}
                @include('layouts.navigation')

                <div class="max-w-7xl mx-auto px-6 py-20">
                    <!-- Hero Content -->
                    <div class="text-center">
                        <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                            Temukan Hewan<br>
                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-orange-400">
                                Kurban Terbaik
                            </span>
                        </h1>
                        <p class="text-xl text-white text-opacity-90 mb-12 max-w-2xl mx-auto leading-relaxed">
                            Platform modern untuk jual beli hewan kurban berkualitas. Mudah, aman, dan terpercaya untuk ibadah Anda.
                        </p>
                        
                        <!-- Search Bar -->
                        <div class="max-w-4xl mx-auto mb-16">
                            <form action="{{ route('home') }}" method="GET" class="glass rounded-2xl p-6 shadow-2xl">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <div class="md:col-span-2">
                                        <input type="text" name="search" placeholder="Cari jenis hewan atau nama..." 
                                               class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-purple-400 bg-white bg-opacity-90 placeholder-gray-500" 
                                               value="{{ request('search') }}">
                                    </div>
                                    <select name="category" class="px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-purple-400 bg-white bg-opacity-90">
                                        <option value="">Semua Kategori</option>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <input type="number" name="min_price" placeholder="Harga Min" 
                                           class="px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-purple-400 bg-white bg-opacity-90 placeholder-gray-500" 
                                           value="{{ request('min_price') }}">
                                    <button type="submit" class="bg-gradient-to-r from-orange-400 to-pink-500 hover:from-orange-500 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl md:col-start-5">
                                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                                        </svg>
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-6">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Hewan Kurban Pilihan</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">Koleksi hewan kurban berkualitas tinggi dari peternak terpercaya</p>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @if(isset($animals) && $animals->count() > 0)
                        @foreach($animals as $animal)
                            <div class="card-hover bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                                <a href="{{ route('animals.show', $animal) }}" class="block">
                                    <div class="relative">
                                        <img src="{{ $animal->photos->first() ? asset('storage/' . $animal->photos->first()->path) : 'https://placehold.co/400x300?text=Foto+Hewan' }}" 
                                             alt="{{ $animal->name }}" 
                                             class="w-full h-56 object-cover">

                                        {{-- TAMBAHKAN BLOK KODE INI --}}
                                        @if($animal->status == 'sold')
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                <span class="text-white text-2xl font-bold border-4 border-white px-6 py-2 transform -rotate-12">
                                                    TERJUAL
                                                </span>
                                            </div>
                                        @endif
                                        {{-- AKHIR BLOK --}}

                                        <div class="absolute top-4 left-4">
                                            {{-- PERBAIKAN 1: Cek jika kategori ada --}}
                                            @if($animal->category)
                                                <span class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                                    {{ $animal->category->name }}
                                                </span>
                                            @else
                                                 <span class="bg-gradient-to-r from-red-500 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                                    Tanpa Kategori
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="p-6">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate" title="{{ $animal->name }}">{{ $animal->name }}</h3>
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-2xl font-bold text-purple-600">
                                                Rp {{ number_format($animal->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $animal->weight }} kg
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                                {{ $animal->age }} bulan
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                            {{-- PERBAIKAN 2: Cek jika penjual (user) ada --}}
                                            @if($animal->user)
                                                {{ $animal->user->name }}
                                            @else
                                                Penjual Dihapus
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center py-16">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47.881-6.08 2.33"/>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-500 mb-2">Belum ada hewan tersedia</h3>
                            <p class="text-gray-400">Silakan coba lagi nanti atau ubah filter pencarian Anda.</p>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if(isset($animals) && $animals->hasPages())
                    <div class="mt-16 flex justify-center">
                        <div class="bg-white rounded-2xl shadow-lg p-2">
                             {{ $animals->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih SiQurban?</h2>
                    <p class="text-xl text-gray-600">Platform terpercaya untuk kebutuhan kurban Anda</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-8 bg-white rounded-2xl shadow-lg card-hover">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Hewan Berkualitas</h3>
                        <p class="text-gray-600">Semua hewan telah melalui seleksi ketat untuk memastikan kualitas terbaik</p>
                    </div>

                    <div class="text-center p-8 bg-white rounded-2xl shadow-lg card-hover">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Transaksi Aman</h3>
                        <p class="text-gray-600">Sistem pembayaran yang aman dan terpercaya untuk melindungi transaksi Anda</p>
                    </div>

                    <div class="text-center p-8 bg-white rounded-2xl shadow-lg card-hover">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.5a9.5 9.5 0 119.5 9.5A9.5 9.5 0 0112 2.5z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Mudah Digunakan</h3>
                        <p class="text-gray-600">Interface yang intuitif memudahkan Anda mencari dan memesan hewan kurban</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center">
                    <div class="flex items-center justify-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold">SiQurban</h3>
                    </div>
                    <p class="text-gray-400 mb-8 max-w-md mx-auto">
                        Platform modern untuk kebutuhan hewan kurban Anda. Mudah, aman, dan terpercaya.
                    </p>
                    <div class="border-t border-gray-800 pt-8">
                        <p class="text-gray-500">© {{ date('Y') }} SiQurban. Dibuat dengan ❤️ untuk ibadah yang berkah.</p>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
