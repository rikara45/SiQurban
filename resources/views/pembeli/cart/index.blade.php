<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(empty($cartItems))
                        <p>Keranjang Anda kosong.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 bg-gray-50"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cartItems as $id => $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap">{{ $item['name'] }}</td>
                                        <td class="px-6 py-4 whitespace-no-wrap">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                            <form action="{{ route('pembeli.cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button>Hapus</x-danger-button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                         <div class="text-right mt-4">
                            <p class="text-lg"><strong>Total:</strong> Rp {{ number_format($total, 0, ',', '.') }}</p>
                            <a href="#" class="mt-2 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">
                                Lanjutkan ke Checkout
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>