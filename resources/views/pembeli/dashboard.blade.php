<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-t">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .glass { backdrop-filter: blur(16px); background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen gradient-bg">
        
        @include('layouts.navigation')

        <div class="absolute inset-0 overflow-hidden -z-10">
            <div class="absolute -top-40 -right-32 w-80 h-80 bg-white opacity-10 rounded-full animate-float"></div>
            <div class="absolute top-20 -left-20 w-60 h-60 bg-white opacity-5 rounded-full animate-float" style="animation-delay: -2s;"></div>
            <div class="absolute bottom-20 right-20 w-40 h-40 bg-white opacity-10 rounded-full animate-float" style="animation-delay: -4s;"></div>
        </div>

        <header class="relative z-10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-2xl text-white leading-tight">
                    {{ __('Dashboard Pembeli') }}
                </h2>
            </div>
        </header>

        <main class="relative z-10">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="glass overflow-hidden shadow-lg rounded-2xl">
                        <div class="p-6 text-white">
                            <h3 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h3>
                            <p class="mt-2 text-gray-300">
                                Anda berhasil login. Siap untuk mencari hewan kurban terbaik untuk Anda?
                            </p>

                            <div class="mt-6 pt-6 border-t border-white border-opacity-20 grid grid-cols-1 sm:grid-cols-2 gap-4">
                               <a href="{{ route('home') }}" class="w-full text-center px-4 py-3 bg-white bg-opacity-20 rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-opacity-30 transition">
                                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    Cari Hewan Kurban
                                </a>
                               <a href="{{ route('pembeli.cart.index') }}" class="w-full text-center px-4 py-3 bg-white bg-opacity-20 rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-opacity-30 transition">
                                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Lihat Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>