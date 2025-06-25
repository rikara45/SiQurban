<x-app-layout>
    {{-- Menambahkan blok style untuk konsistensi tema --}}
    <x-slot name="head_styles">
        <style>
            .content-card {
                background-color: #d9ead3;
                /* Warna kolom paling terang */
                border-radius: 0.75rem;
                /* sm:rounded-lg */
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
                /* shadow-sm */
            }
        </style>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Negosiasi Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Menggunakan .content-card untuk warna kolom --}}
            <div class="content-card overflow-hidden">
                <div class="p-6 text-black bg-white rounded">
                    <h3 class="text-xl font-bold mb-4">Riwayat Penawaran Anda</h3>
                    <div class="overflow-x-auto">
                        {{-- Tabel diubah menjadi bergaris hitam --}}
                        <table class="min-w-full border-collapse border border-black bg-green-50">
                            <thead class="bg-green-200">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase border border-black">
                                        Hewan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase border border-black">
                                        Penawaran Saya</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase border border-black">
                                        Tawaran Penjual</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase border border-black">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase border border-black">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-transparent">
                                @forelse ($negotiations as $nego)
                                    <tr>
                                        <td class="px-6 py-4 border border-black">{{ $nego->animal->name }}</td>
                                        <td class="px-6 py-4 border border-black">Rp {{ number_format($nego->offer_price) }}
                                        </td>
                                        <td class="px-6 py-4 border border-black">
                                            @if($nego->counter_price)
                                                <span class="font-bold">Rp {{ number_format($nego->counter_price) }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 border border-black">
                                            {{-- Badge status disesuaikan agar lebih kontras --}}
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white
                                                                    @if($nego->status == 'pending') bg-yellow-500 @endif
                                                                    @if($nego->status == 'accepted') bg-green-500 @endif
                                                                    @if($nego->status == 'rejected') bg-red-500 @endif
                                                                    @if($nego->status == 'countered') bg-blue-500 @endif
                                                                    ">
                                                {{ ucfirst($nego->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium border border-black">
                                            @if($nego->status == 'countered')
                                                <div class="flex space-x-2">
                                                    {{-- Form untuk Terima --}}
                                                    <form action="{{ route('pembeli.negotiations.acceptCounter', $nego) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="text-green-600 hover:text-green-800">Terima</button>
                                                    </form>
                                                    {{-- Form untuk Tolak --}}
                                                    <form action="{{ route('pembeli.negotiations.rejectCounter', $nego) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="text-red-600 hover:text-red-800">Tolak</button>
                                                    </form>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-4 text-center border border-black">Anda belum pernah
                                            melakukan negosiasi.</td>
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