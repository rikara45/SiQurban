<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            /* Latar belakang netral agar kolom menonjol */
        }

        .content-card {
            background-color: #d9ead3;
            /* Warna paling terang dari palet */
            border-radius: 1.5rem;
            /* rounded-2xl */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            /* shadow-lg */
        }

        .custom-btn {
            background-color: #93c47d;
            /* Warna hijau yang lebih gelap untuk kontras */
        }

        .custom-btn:hover {
            background-color: #6aa84f;
            /* Warna hijau paling gelap untuk hover */
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">

        @include('layouts.navigation')

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-2xl text-black leading-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
            </div>
        </header>

        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    {{-- Kartu Statistik --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div class="content-card p-6">
                            <h3 class="text-sm font-medium text-black">Total Pengguna</h3>
                            <p class="mt-1 text-3xl font-semibold text-black">{{ $totalUsers }}</p>
                            <div class="text-sm text-black mt-2">
                                <span>{{ $totalSellers }} Penjual</span> |
                                <span>{{ $totalBuyers }} Pembeli</span>
                            </div>
                        </div>
                        <div class="content-card p-6">
                            <h3 class="text-sm font-medium text-black">Total Transaksi</h3>
                            <p class="mt-1 text-3xl font-semibold text-black">{{ $totalOrders }}</p>
                        </div>
                        <div class="content-card p-6">
                            <h3 class="text-sm font-medium text-black">Total Pendapatan</h3>
                            <p class="mt-1 text-3xl font-semibold text-black">Rp
                                {{ number_format($totalRevenue, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Tombol Manajemen --}}
                    <div class="content-card overflow-hidden mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium leading-6 text-black">Manajemen</h3>
                            <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <a href="{{ route('admin.users.index') }}"
                                    class="w-full text-center px-4 py-3 custom-btn rounded-md font-semibold text-xs text-black uppercase tracking-widest transition">
                                    Manajemen User
                                </a>
                                <a href="{{ route('admin.categories.index') }}"
                                    class="w-full text-center px-4 py-3 custom-btn rounded-md font-semibold text-xs text-black uppercase tracking-widest transition">
                                    Kategori Hewan
                                </a>
                                <a href="{{ route('admin.transactions.index') }}"
                                    class="w-full text-center px-4 py-3 custom-btn rounded-md font-semibold text-xs text-black uppercase tracking-widest transition">
                                    Semua Transaksi
                                </a>
                                <a href="#"
                                    class="w-full text-center px-4 py-3 bg-yellow-500 bg-opacity-80 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 transition">
                                    Handle Dispute
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Tabel Pengguna Terbaru --}}
                    <div class="content-card overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-medium leading-6 text-black">5 Pengguna Terbaru</h3>
                            <div class="mt-4 overflow-x-auto">
                                {{-- PERUBAHAN: Menghapus 'divide-y' dan menambahkan 'border-collapse' --}}
                                <table class="min-w-full border-collapse border border-black">
                                    <thead>
                                        <tr>
                                            {{-- PERUBAHAN: Menambahkan border hitam di setiap header --}}
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Nama</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Email</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Role</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Tanggal Bergabung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentUsers as $user)
                                            <tr>
                                                {{-- PERUBAHAN: Menambahkan border hitam di setiap sel --}}
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black border border-black">
                                                    {{ $user->name }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-black border border-black">
                                                    {{ $user->email }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-black border border-black">
                                                    @foreach ($user->getRoleNames() as $role)
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#93c47d] text-black">
                                                            {{ ucfirst($role) }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-black border border-black">
                                                    {{ $user->created_at->format('d M Y') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="px-6 py-4 whitespace-nowrap text-center text-sm text-black border border-black">
                                                    Tidak ada data pengguna.
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