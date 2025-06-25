<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Penjual - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            /* Latar belakang netral */
        }

        .content-card {
            background-color: #d9ead3;
            /* Warna hijau terang */
            border-radius: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .custom-btn {
            background-color: #93c47d;
            color: #000000;
        }

        .custom-btn:hover {
            background-color: #6aa84f;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">

        @include('layouts.navigation')

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{-- PERUBAHAN: Teks header menjadi hitam --}}
                <h2 class="font-semibold text-2xl text-black leading-tight">
                    {{ __('Dashboard Penjual') }}
                </h2>
            </div>
        </header>

        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {{-- Kartu Statistik --}}
                    {{-- PERUBAHAN: Menggunakan .content-card dan teks hitam --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="content-card p-6">
                            <h3 class="text-sm font-medium text-black truncate">Total Hewan Saya</h3>
                            <p class="mt-1 text-3xl font-semibold text-black">{{ $totalAnimals }}</p>
                        </div>
                        <div class="content-card p-6">
                            <h3 class="text-sm font-medium text-black truncate">Hewan Tersedia</h3>
                            <p class="mt-1 text-3xl font-semibold text-green-700">{{ $animalsAvailable }}</p>
                        </div>
                        <div class="content-card p-6">
                            <h3 class="text-sm font-medium text-black truncate">Hewan Terjual</h3>
                            <p class="mt-1 text-3xl font-semibold text-gray-700">{{ $animalsSold }}</p>
                        </div>
                        <div class="content-card p-6">
                            <h3 class="text-sm font-medium text-black truncate">Total Pendapatan</h3>
                            <p class="mt-1 text-3xl font-semibold text-black">Rp
                                {{ number_format($totalEarnings, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Aksi Cepat --}}
                    <div class="content-card overflow-hidden mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium leading-6 text-black">Aksi Cepat</h3>
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                                {{-- PERUBAHAN: Tombol disesuaikan dengan tema --}}
                                <a href="{{ route('penjual.animals.index') }}"
                                    class="w-full text-center px-4 py-3 custom-btn rounded-md font-semibold text-xs uppercase tracking-widest transition">
                                    Kelola Hewan
                                </a>
                                <a href="{{ route('penjual.orders.index') }}"
                                    class="w-full text-center px-4 py-3 custom-btn rounded-md font-semibold text-xs uppercase tracking-widest transition">
                                    Manajemen Pesanan
                                </a>
                                <a href="{{ route('penjual.negotiations.index') }}"
                                    class="w-full text-center px-4 py-3 custom-btn rounded-md font-semibold text-xs uppercase tracking-widest transition">
                                    Negosiasi
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel Penjualan Terbaru --}}
                    <div class="content-card overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-medium leading-6 text-black">5 Penjualan Terbaru</h3>
                            <div class="mt-4 overflow-x-auto">
                                {{-- PERUBAHAN: Tabel dengan border hitam --}}
                                <table class="min-w-full border-collapse border border-black">
                                    <thead class="bg-green-200">
                                        <tr>
                                            {{-- PERUBAHAN: Header tabel dengan border dan teks hitam --}}
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Hewan</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Pembeli</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Harga</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-black bg-green-50">
                                        @forelse($recentSales as $sale)
                                            <tr>
                                                {{-- PERUBAHAN: Sel tabel dengan border dan teks hitam --}}
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium border border-black">
                                                    {{ $sale->animal->name ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm border border-black">
                                                    {{ $sale->order->buyer->name ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm border border-black">Rp
                                                    {{ number_format($sale->price, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm border border-black">
                                                    {{ $sale->created_at->format('d M Y') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="px-6 py-4 whitespace-nowrap text-center text-sm border border-black">
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