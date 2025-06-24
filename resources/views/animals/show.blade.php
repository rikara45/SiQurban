<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $animal->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <img src="{{ $animal->photos->first() ? asset('storage/' . $animal->photos->first()->path) : 'https://via.placeholder.com/600' }}" alt="{{ $animal->name }}" class="w-full h-auto object-cover rounded-lg">
                    </div>
                    <div>
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $animal->category->name }}</span>
                        <h1 class="text-3xl font-bold mb-2">{{ $animal->name }}</h1>
                        <p class="text-2xl font-bold text-green-600 mb-4">Rp {{ number_format($animal->price, 0, ',', '.') }}</p>

                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div><strong>Penjual:</strong> {{ $animal->user->name }}</div>
                            <div><strong>Status:</strong> <span class="font-semibold {{ $animal->status == 'available' ? 'text-green-500' : 'text-red-500' }}">{{ ucfirst($animal->status) }}</span></div>
                            <div><strong>Berat:</strong> {{ $animal->weight }} kg</div>
                            <div><strong>Umur:</strong> {{ $animal->age }} bulan</div>
                        </div>

                        <div class="mb-4">
                            <h4 class="font-bold">Deskripsi:</h4>
                            <p class="text-gray-600">{{ $animal->description ?? 'Tidak ada deskripsi.' }}</p>
                        </div>

                        @hasrole('pembeli')
                            <div class="mt-6">
                                <form action="{{ route('pembeli.cart.add', $animal) }}" method="POST">
                                    @csrf
                                    <x-primary-button>
                                        Tambah ke Keranjang
                                    </x-primary-button>
                                </form>
                            </div>
                        @endhasrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>