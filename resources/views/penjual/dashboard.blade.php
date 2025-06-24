<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Penjual - {{ config('app.name', 'Laravel') }}</title>

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
                    {{ __('Dashboard Penjual') }}
                </h2>
            </div>
        </header>

        <main class="relative z-10">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6 text-white">
                        <div class="glass p-6 rounded-2xl shadow-lg">
                            <h3 class="text-sm font-medium text-gray-300 truncate">Total Hewan Saya</h3>
                            <p class="mt-1 text-3xl font-semibold">{{ $totalAnimals }}</p>
                        </div>
                        <div class="glass p-6 rounded-2xl shadow-lg">
                            <h3 class="text-sm font-medium text-gray-300 truncate">Hewan Tersedia</h3>
                            <p class="mt-1 text-3xl font-semibold text-green-300">{{ $animalsAvailable }}</p>
                        </div>
                        <div class="glass p-6 rounded-2xl shadow-lg">
                            <h3 class="text-sm font-medium text-gray-300 truncate">Hewan Terjual</h3>
                            <p class="mt-1 text-3xl font-semibold text-red-300">{{ $animalsSold }}</p>
                        </div>
                        <div class="glass p-6 rounded-2xl shadow-lg">
                            <h3 class="text-sm font-medium text-gray-300 truncate">Total Pendapatan</h3>
                            <p class="mt-1 text-3xl font-semibold">Rp {{ number_format($totalEarnings, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="glass overflow-hidden shadow-lg rounded-2xl mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium leading-6 text-white">Aksi Cepat</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <a href="{{ route('penjual.animals.index') }}" class="w-full text-center px-4 py-3 bg-white bg-opacity-20 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-30 transition">
                                    Kelola Hewan
                                </a>
                                <a href="{{ route('penjual.orders.index') }}" class="w-full text-center px-4 py-3 bg-white bg-opacity-20 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-30 transition">
                                    Manajemen Pesanan
                                </a>
                                <a href="{{ route('penjual.negotiations.index') }}" class="w-full text-center px-4 py-3 bg-white bg-opacity-20 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-30 transition">
                                    Negosiasi
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="glass overflow-hidden shadow-lg rounded-2xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium leading-6 text-white">5 Penjualan Terbaru</h3>
                            <div class="mt-4 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 divide-opacity-20">
                                    <thead class="bg-transparent">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Hewan</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pembeli</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Harga</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-transparent divide-y divide-gray-200 divide-opacity-20 text-white">
                                        @forelse($recentSales as $sale)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $sale->animal->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $sale->order->buyer->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">Rp {{ number_format($sale->price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $sale->created_at->format('d M Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-400">
                                                Belum ada penjualan.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>