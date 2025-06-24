<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total Pengguna</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalUsers }}</p>
                    <div class="text-sm text-gray-500 mt-2">
                        <span>{{ $totalSellers }} Penjual</span> | 
                        <span>{{ $totalBuyers }} Pembeli</span>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total Transaksi</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalOrders }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total Pendapatan</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Manajemen</h3>
                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4">
                        {{-- Tambahkan route ke controller yang sesuai nanti --}}
                        <a href="#" class="w-full text-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 transition">
                            Manajemen User
                        </a>
                        <a href="#" class="w-full text-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 transition">
                            Kategori Hewan
                        </a>
                         <a href="#" class="w-full text-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 transition">
                            Semua Transaksi
                        </a>
                        <a href="#" class="w-full text-center px-4 py-3 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 transition">
                            Handle Dispute
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">5 Pengguna Terbaru</h3>
                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Bergabung</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentUsers as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @foreach ($user->getRoleNames() as $role)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($role) }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
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
</x-app-layout>

