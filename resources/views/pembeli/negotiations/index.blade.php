<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Negosiasi Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-4">Riwayat Penawaran Anda</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Hewan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Penawaran Saya</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Tawaran Penjual</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($negotiations as $nego)
                                    <tr>
                                        <td class="px-6 py-4">{{ $nego->animal->name }}</td>
                                        <td class="px-6 py-4">Rp {{ number_format($nego->offer_price) }}</td>
                                        <td class="px-6 py-4">
                                            @if($nego->status == 'countered')
                                                <span class="font-bold">Rp {{ number_format($nego->counter_price) }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($nego->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                            @if($nego->status == 'accepted') bg-green-100 text-green-800 @endif
                                            @if($nego->status == 'rejected') bg-red-100 text-red-800 @endif
                                            @if($nego->status == 'countered') bg-blue-100 text-blue-800 @endif
                                            ">
                                                {{ ucfirst($nego->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium">
                                            {{-- Tampilkan aksi hanya jika ada tawaran balik dari penjual --}}
                                            @if($nego->status == 'countered')
                                                <div class="flex space-x-2">
                                                    {{-- Form untuk Terima --}}
                                                    <form action="{{ route('pembeli.negotiations.acceptCounter', $nego) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="text-green-600 hover:text-green-900">Terima</button>
                                                    </form>
                                                    {{-- Form untuk Tolak --}}
                                                    <form action="{{ route('pembeli.negotiations.rejectCounter', $nego) }}" method="POST">
                                                         @csrf
                                                         @method('PATCH')
                                                        <button class="text-red-600 hover:text-red-900">Tolak</button>
                                                    </form>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="p-4 text-center">Anda belum pernah melakukan negosiasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>