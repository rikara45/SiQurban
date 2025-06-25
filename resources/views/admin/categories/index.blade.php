<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Kategori - {{ config('app.name', 'Laravel') }}</title>
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

        .custom-btn {
            background-color: #93c47d;
            color: #000000;
        }

        .custom-btn:hover {
            background-color: #6aa84f;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                {{-- PERUBAHAN: Teks header menjadi hitam --}}
                <h2 class="font-semibold text-2xl text-black leading-tight">
                    {{ __('Manajemen Kategori Hewan') }}
                </h2>
                {{-- PERUBAHAN: Tombol disesuaikan dengan tema hijau --}}
                <a href="{{ route('admin.categories.create') }}"
                    class="inline-flex items-center px-4 py-2 custom-btn border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition">
                    {{ __('+ Tambah Kategori') }}
                </a>
            </div>
        </header>

        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {{-- PERUBAHAN: Menggunakan .content-card --}}
                    <div class="content-card overflow-hidden">
                        <div class="p-6 text-black">
                            {{-- PERUBAHAN: Notifikasi disesuaikan --}}
                            @if(session('success'))
                                <div class="bg-green-200 border border-green-300 text-green-800 px-4 py-3 rounded relative mb-4"
                                    role="alert">
                                    <span class="block sm:inline">{{ session('success') }}</span>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="bg-red-200 border border-red-300 text-red-800 px-4 py-3 rounded relative mb-4"
                                    role="alert">
                                    <span class="block sm:inline">{{ session('error') }}</span>
                                </div>
                            @endif
                            <div class="overflow-x-auto">
                                {{-- PERUBAHAN: Tabel dengan border hitam --}}
                                <table class="min-w-full border-collapse border border-black">
                                    <thead>
                                        <tr>
                                            {{-- PERUBAHAN: Header tabel dengan border dan teks hitam --}}
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Nama</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Deskripsi</th>
                                            <th
                                                class="px-6 py-3 text-right text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($categories as $category)
                                            <tr>
                                                {{-- PERUBAHAN: Sel tabel dengan border dan teks hitam --}}
                                                <td class="px-6 py-4 whitespace-nowrap border border-black">
                                                    {{ $category->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap border border-black">
                                                    {{ $category->description ?? '-' }}</td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium border border-black">
                                                    {{-- PERUBAHAN: Tautan aksi disesuaikan --}}
                                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                                        class="text-blue-600 hover:text-blue-800">Edit</a>
                                                    <form action="{{ route('admin.categories.destroy', $category) }}"
                                                        method="POST" class="inline-block ml-4"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-800">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3"
                                                    class="px-6 py-4 whitespace-nowrap text-center text-sm text-black border border-black">
                                                    Belum ada data kategori.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-black">
                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>