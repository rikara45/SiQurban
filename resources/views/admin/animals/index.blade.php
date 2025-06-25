<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stok Semua Hewan - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            /* Latar belakang netral */
        }

        .content-card {
            background-color: #d9ead3;
            /* Warna hijau terang */
            border-radius: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{-- PERUBAHAN: Teks header menjadi hitam --}}
                <h2 class="font-semibold text-2xl text-black leading-tight">
                    {{ __('Stok Semua Hewan') }}
                </h2>
            </div>
        </header>
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {{-- PERUBAHAN: Menggunakan .content-card --}}
                    <div class="content-card overflow-hidden">
                        <div class="p-6 text-black">
                            <div class="overflow-x-auto">
                                {{-- PERUBAHAN: Tabel dengan border hitam --}}
                                <table class="min-w-full border-collapse border border-black">
                                    <thead>
                                        <tr>
                                            {{-- PERUBAHAN: Header tabel dengan border dan teks hitam --}}
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Nama Hewan</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Penjual</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Kategori</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Harga</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($animals as $animal)
                                            <tr>
                                                {{-- PERUBAHAN: Sel tabel dengan border dan teks hitam --}}
                                                <td class="px-6 py-4 whitespace-nowrap border border-black">
                                                    {{ $animal->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border border-black">
                                                    {{ $animal->user->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border border-black">
                                                    {{ $animal->category->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border border-black">Rp
                                                    {{ number_format($animal->price) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border border-black">
                                                    {{-- PERUBAHAN: Badge status disesuaikan agar kontras --}}
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $animal->status == 'available' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                                        {{ ucfirst($animal->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"
                                                    class="px-6 py-4 whitespace-nowrap text-center text-sm text-black border border-black">
                                                    Tidak ada data hewan.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-black">
                                {{-- PERUBAHAN: Teks paginasi menjadi hitam --}}
                                {{ $animals->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>