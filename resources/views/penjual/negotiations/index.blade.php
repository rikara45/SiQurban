<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Negosiasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hewan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembeli</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Nego Yang Diajukan</th>
                                    {{-- KOLOM BARU --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Nego Yang Disetujui</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($negotiations as $nego)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $nego->animal->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $nego->buyer->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($nego->offer_price) }}</td>

                                        {{-- KOLOM BARU UNTUK HARGA DISETUJUI --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($nego->status == 'accepted')
                                                <span class="font-bold text-green-700">
                                                    Rp {{ number_format($nego->counter_price ?? $nego->offer_price) }}
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($nego->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                            @if($nego->status == 'accepted') bg-green-100 text-green-800 @endif
                                            @if($nego->status == 'rejected') bg-red-100 text-red-800 @endif
                                            @if($nego->status == 'countered') bg-blue-100 text-blue-800 @endif
                                            ">
                                                {{ ucfirst($nego->status) }}
                                            </span>
                                            @if($nego->status == 'countered')
                                                <p class="text-xs">Anda: Rp {{number_format($nego->counter_price)}}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($nego->status == 'pending')
                                                <div class="flex items-center space-x-2">
                                                    <form action="{{ route('penjual.negotiations.accept', $nego) }}" method="POST"> @csrf @method('PATCH') <button class="text-green-600 hover:text-green-900">Terima</button></form>
                                                    <form action="{{ route('penjual.negotiations.reject', $nego) }}" method="POST"> @csrf @method('PATCH') <button class="text-red-600 hover:text-red-900">Tolak</button></form>
                                                    <form action="{{ route('penjual.negotiations.counter', $nego) }}" method="POST" class="flex items-center space-x-1">
                                                        @csrf @method('PATCH')
                                                        <input type="number" name="counter_price" placeholder="Harga balik" class="w-24 text-xs p-1 border-gray-300 rounded-md">
                                                        <button type="submit" class="text-blue-600 hover:text-blue-900">Ajukan Tawaran</button>
                                                    </form>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="p-4 text-center">Tidak ada negosiasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $negotiations->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>