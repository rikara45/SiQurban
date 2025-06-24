<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - SiQurban</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Gaya yang diadaptasi dari welcome.blade.php dan login.blade.php */
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .feature-icon {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0));
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="gradient-bg relative text-white">
        <nav class="px-6 py-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold">SiQurban</h1>
                </a>
                <div>
                    <a href="{{ route('home') }}" class="font-medium hover:text-gray-200 transition-colors duration-300">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            </div>
        </nav>

        <div class="text-center py-20 px-6">
            <h1 class="text-5xl font-bold mb-4">Tentang SiQurban</h1>
            <p class="text-xl text-white text-opacity-80 max-w-3xl mx-auto">
                Platform digital modern untuk mempermudah, mengamankan, dan mengefisienkan transaksi jual beli hewan untuk ibadah kurban Anda.
            </p>
        </div>
    </div>

    <main class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 space-y-16">

            <div>
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-3">Ekosistem Lengkap untuk Semua</h2>
                    <p class="text-lg text-gray-600">Fitur yang dirancang khusus untuk memenuhi kebutuhan setiap peran dalam platform.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Untuk Pembeli</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start"><span class="text-purple-500 mr-2">&#10003;</span> Katalog dan pencarian hewan.</li>
                            <li class="flex items-start"><span class="text-purple-500 mr-2">&#10003;</span> Fitur negosiasi harga langsung dengan penjual.</li>
                            <li class="flex items-start"><span class="text-purple-500 mr-2">&#10003;</span> Opsi pengiriman fleksibel (diantar, diambil, disalurkan).</li>
                            <li class="flex items-start"><span class="text-purple-500 mr-2">&#10003;</span> Riwayat transaksi dan konfirmasi penerimaan.</li>
                            <li class="flex items-start"><span class="text-purple-500 mr-2">&#10003;</span> Sistem ulasan dan rating untuk hewan.</li>
                        </ul>
                    </div>
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Untuk Penjual</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start"><span class="text-green-500 mr-2">&#10003;</span> Dasbor statistik penjualan dan pendapatan.</li>
                            <li class="flex items-start"><span class="text-green-500 mr-2">&#10003;</span> Manajemen produk hewan (tambah, edit, hapus).</li>
                            <li class="flex items-start"><span class="text-green-500 mr-2">&#10003;</span> Manajemen pesanan (terima atau tolak).</li>
                            <li class="flex items-start"><span class="text-green-500 mr-2">&#10003;</span> Manajemen negosiasi (terima, tolak, tawar balik).</li>
                            <li class="flex items-start"><span class="text-green-500 mr-2">&#10003;</span> Profil penjual yang terverifikasi.</li>
                        </ul>
                    </div>
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Untuk Admin</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-start"><span class="text-blue-500 mr-2">&#10003;</span> Dasbor global dengan statistik platform.</li>
                            <li class="flex items-start"><span class="text-blue-500 mr-2">&#10003;</span> Manajemen semua pengguna dan statusnya.</li>
                            <li class="flex items-start"><span class="text-blue-500 mr-2">&#10003;</span> Manajemen kategori hewan kurban.</li>
                            <li class="flex items-start"><span class="text-blue-500 mr-2">&#10003;</span> Pemantauan semua transaksi dan hewan.</li>
                            <li class="flex items-start"><span class="text-blue-500 mr-2">&#10003;</span> Kontrol penuh atas konten platform.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div>
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-3">Dibangun dengan Teknologi Modern</h2>
                    <p class="text-lg text-gray-600">Mengandalkan tumpukan teknologi yang kuat dan andal.</p>
                </div>
                <div class="max-w-4xl mx-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-center">
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <p class="font-bold text-lg">Laravel 12</p>
                        <p class="text-sm text-gray-500">Backend Framework</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <p class="font-bold text-lg">Tailwind CSS</p>
                        <p class="text-sm text-gray-500">CSS Framework</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <p class="font-bold text-lg">Alpine.js</p>
                        <p class="text-sm text-gray-500">JavaScript Framework</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <p class="font-bold text-lg">Vite</p>
                        <p class="text-sm text-gray-500">Build Tool</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md sm:col-span-3 md:col-span-4">
                        <p class="font-bold text-lg">Spatie Permission</p>
                        <p class="text-sm text-gray-500">Manajemen Peran & Izin Akses</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="bg-gray-900 text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-gray-500">© {{ date('Y') }} SiQurban. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>