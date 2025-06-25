{{-- Lokasi: resources/views/penjual/animals/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Hewan Kurban Saya') }}
            </h2>
            <a href="{{ route('penjual.animals.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('+ Tambah Hewan') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y border border-black">
                            <thead class="bg-green-200">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-black">
                                        Nama</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-black">
                                        Kategori</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-black">
                                        Harga</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-black">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border border-black">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-green-50 divide-y divide-green-200">
                                @forelse ($animals as $animal)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap border border-black">{{ $animal->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border border-black">
                                            {{ $animal->category->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border border-black">Rp
                                            {{ number_format($animal->price) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border border-black">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $animal->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($animal->status) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium border border-black">
                                            <a href="{{ route('penjual.animals.edit', $animal) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('penjual.animals.destroy', $animal) }}" method="POST"
                                                class="inline-block ml-4"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus hewan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 border border-green-300">
                                            Anda belum memiliki data hewan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $animals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>