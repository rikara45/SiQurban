<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Pengguna - {{ config('app.name', 'Laravel') }}</title>
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
            /* Warna hijau terang dari palet */
            border-radius: 1.5rem;
            /* rounded-2xl */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            /* shadow-lg */
        }

        .input-light {
            background-color: #ffffff !important;
            border-color: #d1d5db !important;
            /* border-gray-300 */
            color: #000000 !important;
        }

        .input-light::placeholder {
            color: #6b7280;
            /* text-gray-500 */
        }

        .custom-btn {
            background-color: #93c47d;
            color: #000000;
        }

        .custom-btn:hover {
            background-color: #6aa84f;
        }

        .custom-btn-reset {
            background-color: #a3a3a3;
            /* Warna abu-abu netral */
            color: #000000;
        }

        .custom-btn-reset:hover {
            background-color: #737373;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-2xl text-black leading-tight">
                    {{ __('Manajemen Pengguna') }}
                </h2>
            </div>
        </header>
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="content-card overflow-hidden">
                        <div class="p-6 text-black">
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
                            <div class="mb-4">
                                <form action="{{ route('admin.users.index') }}" method="GET"
                                    class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <input type="text" name="search" placeholder="Cari Nama/Email..."
                                        value="{{ request('search') }}" class="input-light rounded-md shadow-sm">
                                    <select name="role" class="input-light rounded-md shadow-sm">
                                        <option value="">Semua Role</option>
                                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="penjual" {{ request('role') == 'penjual' ? 'selected' : '' }}>
                                            Penjual</option>
                                        <option value="pembeli" {{ request('role') == 'pembeli' ? 'selected' : '' }}>
                                            Pembeli</option>
                                    </select>
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-4 py-2 custom-btn border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest">Cari</button>
                                    <a href="{{ route('admin.users.index') }}"
                                        class="inline-flex items-center justify-center px-4 py-2 custom-btn-reset border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest">Reset</a>
                                </form>
                            </div>
                            <div class="overflow-x-auto">
                                {{-- PERUBAHAN: Menghapus 'divide-y' dan menambahkan 'border-collapse' --}}
                                <table class="min-w-full border-collapse border border-black">
                                    <thead>
                                        <tr>
                                            {{-- PERUBAHAN: Menambahkan border hitam di setiap header --}}
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Nama</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Email</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Role</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Status</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider border border-black">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr>
                                                {{-- PERUBAHAN: Menambahkan border hitam di setiap sel --}}
                                                <td class="px-6 py-4 whitespace-nowrap text-black border border-black">
                                                    {{ $user->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-black border border-black">
                                                    {{ $user->email }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border border-black">
                                                    @foreach ($user->getRoleNames() as $role)
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#93c47d] text-black">
                                                            {{ ucfirst($role) }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap border border-black">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->status == 'active' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                                        {{ ucfirst($user->status) }}
                                                    </span>
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium border border-black">
                                                    @if(!$user->hasRole('admin'))
                                                        <form action="{{ route('admin.users.updateStatus', $user) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            @if($user->status == 'active')
                                                                <input type="hidden" name="status" value="suspended">
                                                                <button type="submit" class="text-red-600 hover:text-red-800"
                                                                    onclick="return confirm('Anda yakin ingin men-suspend pengguna ini?')">Suspend</button>
                                                            @else
                                                                <input type="hidden" name="status" value="active">
                                                                <button type="submit" class="text-green-600 hover:text-green-800"
                                                                    onclick="return confirm('Anda yakin ingin mengaktifkan pengguna ini?')">Activate</button>
                                                            @endif
                                                        </form>
                                                    @else
                                                        <span class="text-black">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"
                                                    class="px-6 py-4 whitespace-nowrap text-center text-sm text-black border border-black">
                                                    Tidak ada data pengguna.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 text-black">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>