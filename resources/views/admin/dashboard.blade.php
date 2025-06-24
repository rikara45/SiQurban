<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - {{ config('app.name', 'Laravel') }}</title>

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
                    {{ __('Admin Dashboard') }}
                </h2>
            </div>
        </header>

        <main class="relative z-10">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <div class="glass p-6 rounded-2xl shadow-lg text-white">
                            <h3 class="text-sm font-medium text-gray-300">Total Pengguna</h3>
                            <p class="mt-1 text-3xl font-semibold">{{ $totalUsers }}</p>
                            <div class="text-sm text-gray-300 mt-2">
                                <span>{{ $totalSellers }} Penjual</span> | 
                                <span>{{ $totalBuyers }} Pembeli</span>
                            </div>
                        </div>
                        <div class="glass p-6 rounded-2xl shadow-lg text-white">
                            <h3 class="text-sm font-medium text-gray-300">Total Transaksi</h3>
                            <p class="mt-1 text-3xl font-semibold">{{ $totalOrders }}</p>
                        </div>
                        <div class="glass p-6 rounded-2xl shadow-lg text-white">
                            <h3 class="text-sm font-medium text-gray-300">Total Pendapatan</h3>
                            <p class="mt-1 text-3xl font-semibold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="glass overflow-hidden shadow-lg rounded-2xl mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium leading-6 text-white">Manajemen</h3>
                            <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <a href="{{ route('admin.users.index') }}" class="w-full text-center px-4 py-3 bg-white bg-opacity-20 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-30 transition">
                                    Manajemen User
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="w-full text-center px-4 py-3 bg-white bg-opacity-20 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-30 transition">
                                    Kategori Hewan
                                </a>
                                 <a href="{{ route('admin.transactions.index') }}" class="w-full text-center px-4 py-3 bg-white bg-opacity-20 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-30 transition">
                                    Semua Transaksi
                                </a>
                                <a href="#" class="w-full text-center px-4 py-3 bg-yellow-500 bg-opacity-80 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 transition">
                                    Handle Dispute
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="glass overflow-hidden shadow-lg rounded-2xl">
                        <div class="p-6">
                            <h3 class="text-lg font-medium leading-6 text-white">5 Pengguna Terbaru</h3>
                            <div class="mt-4 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 divide-opacity-20">
                                    <thead class="bg-transparent">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Role</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal Bergabung</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-transparent divide-y divide-gray-200 divide-opacity-20">
                                        @forelse($recentUsers as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                                @foreach ($user->getRoleNames() as $role)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-white bg-opacity-20 text-white">
                                                        {{ ucfirst($role) }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $user->created_at->format('d M Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-400">
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