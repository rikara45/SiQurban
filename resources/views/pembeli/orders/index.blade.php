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
        {{-- Teks header diubah menjadi hitam --}}
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Menggunakan .content-card untuk warna kolom #d9ead3 --}}
            <div class="content-card overflow-hidden">
                <div class="p-6 text-black bg-white rounded">
                    <div class="overflow-x-auto">
                        {{-- Tabel diubah menjadi bergaris hitam --}}
                        <table class="min-w-full border-collapse border border-black bg-green-50">
                            <thead class="bg-green-200">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase border border-black">
                                        Nomor Order</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase border border-black">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase border border-black">
                                        Total</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase border border-black">
                                        Status</th>
                                    <th class="px-6 py-3 border border-black"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-transparent">
                                @forelse ($orders as $order)
                                    <tr>
                                        {{-- Semua teks sel diubah menjadi hitam --}}
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-black border border-black">
                                            {{ $order->order_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-black border border-black">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-black border border-black">Rp
                                            {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border border-black">
                                            {{-- Badge status disesuaikan agar lebih kontras --}}
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500 text-white">
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm border border-black">
                                            {{-- Tautan disesuaikan --}}
                                            <a href="{{ route('pembeli.orders.show', $order->id) }}"
                                                class="text-blue-600 hover:text-blue-800">Lihat Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-black border border-black">
                                            Anda belum memiliki riwayat pesanan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>