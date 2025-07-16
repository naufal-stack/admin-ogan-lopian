<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Manajemen</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Use Inter font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js for modern graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5; /* Soft background color */
        }
        /* Styles for the draggable sidebar on mobile */
        .sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%); /* Hide sidebar by default for mobile */
            /* On desktop, the sidebar will always be visible because it's fixed */
        }
        .sidebar.open {
            transform: translateX(0); /* Show sidebar when opened on mobile */
        }

        /* Rules for desktop (md: and larger) */
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0) !important; /* Ensure sidebar is always visible on desktop */
                position: fixed; /* Keep it fixed on desktop */
                height: 100vh; /* Ensure sidebar fills the screen height */
            }
            /* Adjust content-wrapper's margin for desktop to make space for the sidebar */
            .content-wrapper {
                margin-left: 256px; /* Adjust to sidebar width (w-64 = 256px) */
                width: calc(100% - 256px); /* Ensure content fills the remaining width */
            }
        }

        /* Custom style for message box */
        .message-box {
            transition: transform 0.3s ease-out;
        }

        /* Hide content sections by default */
        .content-section {
            display: none;
        }

        /* Show active content section */
        .content-section.active {
            display: block;
        }

        /* Modal specific styles */
        .modal-overlay {
        transition: opacity 0.3s ease-out;
        }
        .modal-overlay.show {
            opacity: 1;
        }
        .modal-overlay .modal-content {
            transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        }
        .modal-overlay.show .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        /* Custom scrollbar for better aesthetics */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-40 w-64 bg-gray-800 text-white p-4 shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Admin Panel</h1>
            <button id="sidebarToggleClose" class="md:hidden text-gray-400 hover:text-white">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="#dashboard" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#manajemen-pengguna" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-users mr-3"></i> Manajemen Pengguna
                    </a>
                </li>
                <li class="mb-2 mt-4 text-gray-400 text-sm uppercase font-semibold">Manajemen Data</li>
                <li class="mb-2">
                    <a href="#manajemen-wisata" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-map-marked-alt mr-3"></i> Manajemen Wisata
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#manajemen-hotel" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-hotel mr-3"></i> Manajemen Hotel
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#manajemen-pariwisata" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-globe-asia mr-3"></i> Manajemen Pariwisata
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#manajemen-loker" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-briefcase mr-3"></i> Manajemen Loker
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#manajemen-sekolah" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-school mr-3"></i> Manajemen Sekolah
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#manajemen-dokter" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-user-md mr-3"></i> Manajemen Dokter
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#manajemen-informasi-penting" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-info-circle mr-3"></i> Manajemen Informasi Penting
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#manajemen-event" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-calendar-alt mr-3"></i> Manajemen Event
                    </a>
                </li>
                <li class="mb-2 mt-4 text-gray-400 text-sm uppercase font-semibold">Lain-lain</li>
                <li class="mb-2">
                    <a href="#laporan-statistik" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-chart-line mr-3"></i> Laporan & Statistik
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#pengaturan-sistem" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <i class="fas fa-cog mr-3"></i> Pengaturan Sistem
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="flex items-center px-4 py-2 rounded-lg text-red-400 hover:bg-gray-700 transition-colors duration-200" id="logoutButton">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col content-wrapper">
        <!-- Header / Navbar (Fixed) -->
        <header class="bg-white shadow-md p-4 flex items-center justify-between fixed top-0 left-0 w-full z-30 md:left-64 md:w-[calc(100%-256px)] h-16">
            <button id="sidebarToggleOpen" class="md:hidden text-gray-600 hover:text-gray-900">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <h2 class="text-xl font-semibold text-gray-800" id="currentViewTitle">Dashboard Admin</h2>
            <div class="flex items-center">
                <span class="text-gray-700 mr-2">Admin</span>
                <i class="fas fa-user-circle text-2xl text-gray-600"></i>
            </div>
        </header>

        <!-- Spacer div to push content below the fixed header -->
        <div class="h-16"></div>

        <!-- Main Content (Scrollable) -->
        <main class="flex-1 p-6 bg-gray-100 overflow-y-auto">

            <!-- Dashboard Section -->
            <section id="dashboard" class="content-section active">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Card Statistik Contoh - Total Wisata -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Wisata</p>
                            <h3 id="totalWisataCount" class="text-3xl font-bold text-gray-800">Memuat...</h3>
                        </div>
                        <i class="fas fa-map-marked-alt text-green-500 text-4xl"></i>
                    </div>
                    <!-- Card Statistik Contoh - Total Hotel -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Hotel</p>
                            <h3 id="totalHotelCount" class="text-3xl font-bold text-gray-800">Memuat...</h3>
                        </div>
                        <i class="fas fa-hotel text-blue-500 text-4xl"></i>
                    </div>
                    <!-- Card Statistik Contoh - Total Loker -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Loker</p>
                            <h3 id="totalLokerCount" class="text-3xl font-bold text-gray-800">Memuat...</h3>
                        </div>
                        <i class="fas fa-briefcase text-yellow-500 text-4xl"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Card Statistik Contoh - Total Sekolah -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Sekolah</p>
                            <h3 id="totalSekolahCount" class="text-3xl font-bold text-gray-800">Memuat...</h3>
                        </div>
                        <i class="fas fa-school text-red-500 text-4xl"></i>
                    </div>
                    <!-- Card Statistik Contoh - Total Dokter -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Dokter</p>
                            <h3 id="totalDokterCount" class="text-3xl font-bold text-gray-800">Memuat...</h3>
                        </div>
                        <i class="fas fa-user-md text-orange-500 text-4xl"></i>
                    </div>
                    <!-- Card Statistik Contoh - Total Informasi Penting -->
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Informasi Penting</p>
                            <h3 id="totalInformasiPentingCount" class="text-3xl font-bold text-gray-800">Memuat...</h3>
                        </div>
                        <i class="fas fa-info-circle text-purple-500 text-4xl"></i>
                    </div>
                </div>

                <!-- Bagian Grafik Modern -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Statistik Jumlah Data</h3>
                    <div class="relative h-80"> <!-- Responsive height for the chart -->
                        <canvas id="totalStatsChart"></canvas>
                    </div>
                </div>

                <!-- Bagian Ringkasan Manajemen -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Manajemen Data</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-700 mb-2">Manajemen Wisata</h4>
                            <p class="text-gray-600 text-sm">Kelola daftar tempat wisata, deskripsi, gambar, dan informasi terkait.</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 mt-2">
                                <li>5 wisata baru minggu ini</li>
                                <li>2 permintaan update data</li>
                            </ul>
                            <button class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                Lihat Detail Wisata
                            </button>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-700 mb-2">Manajemen Hotel</h4>
                            <p class="text-gray-600 text-sm">Atur informasi hotel, ketersediaan kamar, harga, dan fasilitas.</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 mt-2">
                                <li>1 hotel baru terdaftar</li>
                                <li>3 hotel dengan rating rendah</li>
                            </ul>
                            <button class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                Lihat Detail Hotel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Bagian Tabel Contoh - Aktivitas Terbaru -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Log Aktivitas Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aktivitas
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Objek
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengguna
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Menambahkan Wisata
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Pantai Indah
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Admin Utama
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        2023-07-07 11:30
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Mengedit Hotel
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Hotel Bintang Lima
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Manajer Hotel
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        2023-07-06 16:15
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Menghapus Loker
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Kerajinan Lokal
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Admin Konten
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        2023-07-05 09:00
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Manajemen Pengguna Section -->
            <section id="manajemen-pengguna" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Manajemen Pengguna</h3>
                    <p class="text-gray-600">Konten untuk mengelola pengguna akan ditampilkan di sini.</p>
                    <!-- Tambahkan tabel atau form manajemen pengguna di sini -->
                </div>
            </section>

            <!-- Manajemen Wisata Section (Updated) -->
            <section id="manajemen-wisata" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">


                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Manajemen Wisata</h3>
                        <button id="addWisataButton" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                            Tambah Wisata Baru
                        </button>
                    </div>

                    <!-- Tabel Daftar Wisata -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Gambar
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Wisata
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lokasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="wisataTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Data wisata akan dimuat di sini oleh JavaScript -->
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Memuat data wisata...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Manajemen Hotel Section -->
            <section id="manajemen-hotel" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Manajemen Hotel</h3>
                        <button id="addHotelButton" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                            Tambah Hotel Baru
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="hotelTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Hotel data will be loaded here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Manajemen Pariwisata Section -->
            <section id="manajemen-pariwisata" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Manajemen Pariwisata</h3>
                    <p class="text-gray-600">Konten untuk mengelola data pariwisata (sebelumnya kuliner) akan ditampilkan di sini.</p>
                </div>
            </section>

            <!-- Manajemen Loker Section -->
            <section id="manajemen-loker" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Manajemen Loker</h3>
                    <p class="text-gray-600">Konten untuk mengelola data lowongan kerja akan ditampilkan di sini.</p>
                </div>
            </section>

            <!-- Manajemen Sekolah Section -->
            <section id="manajemen-sekolah" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Manajemen Sekolah</h3>
                    <p class="text-gray-600">Konten untuk mengelola data sekolah akan ditampilkan di sini.</p>
                </div>
            </section>

            <!-- Manajemen Dokter Section -->
            <section id="manajemen-dokter" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Manajemen Dokter</h3>
                    <p class="text-gray-600">Konten untuk mengelola data dokter akan ditampilkan di sini.</p>
                </div>
            </section>

            <!-- Manajemen Informasi Penting Section -->
            <section id="manajemen-informasi-penting" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Manajemen Informasi Penting</h3>
                    <p class="text-gray-600">Konten untuk mengelola data informasi penting akan ditampilkan di sini.</p>
                </div>
            </section>

            <!-- Manajemen Event Section -->
            <section id="manajemen-event" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Manajemen Event</h3>
                    <p class="text-gray-600">Konten untuk mengelola data event akan ditampilkan di sini.</p>
                </div>
            </section>

            <!-- Laporan & Statistik Section -->
            <section id="laporan-statistik" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Laporan & Statistik</h3>
                    <p class="text-gray-600">Konten untuk laporan dan statistik akan ditampilkan di sini.</p>
                </div>
            </section>

            <!-- Pengaturan Sistem Section -->
            <section id="pengaturan-sistem" class="content-section">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Pengaturan Sistem</h3>
                    <p class="text-gray-600">Konten untuk pengaturan sistem akan ditampilkan di sini.</p>
                </div>
            </section>

        </main>
    </div>

    <!-- Custom Message Box Container -->
    <div id="messageBoxContainer" class="fixed top-5 right-5 z-50"></div>

    <div id="wisataModal" class="modal-overlay fixed inset-0 flex items-center justify-center p-4 hidden bg-gray-900 bg-opacity-50 z-50">
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl w-full max-w-2xl relative transform transition-all duration-300 scale-95 opacity-0 flex flex-col max-h-[90vh]">
            <h3 id="modalTitle" class="text-2xl font-extrabold text-gray-800 mb-6 text-center flex-shrink-0">Tambah Wisata Baru</h3>
            <button id="closeWisataModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-3xl font-bold flex-shrink-0">
                &times;
            </button>

            <form id="wisataForm" enctype="multipart/form-data" class="flex flex-col flex-grow min-h-0">
                <input type="hidden" id="wisataId">

                <!-- Scrollable content area for form fields -->
                <div class="flex-grow overflow-y-auto pr-4 -mr-4 custom-scrollbar">
                    <div class="space-y-5 pb-4">
                        <!-- Nama Wisata (nama) -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Wisata:</label>
                            <input type="text" id="nama" name="nama"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori:</label>
                            <input type="text" id="kategori" name="kategori"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi:</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4"
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required></textarea>
                        </div>

                        <!-- Gambar (image) -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar:</label>
                            <input type="file" id="image" name="image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer transition duration-150 ease-in-out">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar saat mengedit.</p>
                            <img id="gambarPreview" src="https://placehold.co/128x128/E0E0E0/333333?text=No+Image" alt="Pratinjau Gambar" class="mt-2 hidden w-32 h-32 object-cover rounded-lg border border-gray-200">
                        </div>

                        <!-- Alamat (alamat) - Menggantikan 'lokasi' -->
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat:</label>
                            <input type="text" id="alamat" name="alamat"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website (Opsional):</label>
                            <input type="url" id="website" name="website"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"
                                placeholder="https://www.contoh.com">
                        </div>

                        <!-- Nomor Telepon (no_telp) -->
                        <div>
                            <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon:</label>
                            <input type="tel" id="no_telp" name="no_telp"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required
                                placeholder="081234567890">
                        </div>

                        <!-- Latitude -->
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude:</label>
                            <input type="text" id="latitude" name="latitude"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" placeholder="-6.557084">
                        </div>

                        <!-- Longitude -->
                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude:</label>
                            <input type="text" id="longitude" name="longitude"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" placeholder="107.446163">
                        </div>

                        <!-- Prioritas -->
                        <div>
                            <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-1">Prioritas:</label>
                            <input type="number" id="prioritas" name="prioritas" min="0"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required
                                placeholder="1">
                        </div>

                        <!-- Checkout -->
                        <div class="flex items-center">
                            <input type="checkbox" id="checkout" name="checkout"
                                class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <label for="checkout" class="ml-2 block text-sm font-medium text-gray-700">Tersedia untuk Checkout</label>
                        </div>

                        <!-- Jam Buka -->
                        <div>
                            <label for="jam_buka" class="block text-sm font-medium text-gray-700 mb-1">Jam Buka:</label>
                            <input type="text" id="jam_buka" name="jam_buka"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required
                                placeholder="09:00">
                        </div>

                        <!-- Jam Tutup -->
                        <div>
                            <label for="jam_tutup" class="block text-sm font-medium text-gray-700 mb-1">Jam Tutup:</label>
                            <input type="text" id="jam_tutup" name="jam_tutup"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required
                                placeholder="17:00">
                        </div>

                        <!-- Child Price -->
                        <div>
                            <label for="child_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Anak:</label>
                            <input type="number" id="child_price" name="child_price" min="0"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required
                                placeholder="0">
                        </div>

                        <!-- Adult Price -->
                        <div>
                            <label for="adult_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Dewasa:</label>
                            <input type="number" id="adult_price" name="adult_price" min="0"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required
                                placeholder="0">
                        </div>
                    </div>
                </div>

                <!-- Buttons remain at the bottom, outside the scrollable area -->
                <div class="flex items-center justify-end space-x-4 pt-4 mt-auto flex-shrink-0">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105">
                        Simpan
                    </button>
                    <button type="button" id="cancelWisataModal"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-5 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>






    <!-- Hotel Management Modal (Popup) -->
    <div id="hotelModal" class="modal-overlay fixed inset-0 flex items-center justify-center p-4 hidden bg-gray-900 bg-opacity-50 z-50">
        <div class="modal-content bg-white p-8 rounded-xl shadow-2xl w-full max-w-2xl relative transform transition-all duration-300 scale-95 opacity-0 flex flex-col max-h-[90vh]">
            <h3 id="modalTitle" class="text-2xl font-extrabold text-gray-800 mb-6 text-center flex-shrink-0">Tambah Hotel Baru</h3>
            <button id="closeHotelModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-3xl font-bold flex-shrink-0">
                &times;
            </button>

            <form id="hotelForm" enctype="multipart/form-data" class="flex flex-col flex-grow min-h-0">
                <input type="hidden" id="hotelId">

                <!-- Scrollable content area for form fields -->
                <div class="flex-grow overflow-y-auto pr-4 -mr-4 custom-scrollbar">
                    <div class="space-y-5 pb-4">
                        <!-- Nama Hotel (nama) -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Hotel:</label>
                            <input type="text" id="nama" name="nama"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori:</label>
                            <input type="text" id="kategori" name="kategori"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi:</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4"
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required></textarea>
                        </div>

                        <!-- Gambar (image) -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar:</label>
                            <input type="file" id="image" name="image" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer transition duration-150 ease-in-out">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar saat mengedit.</p>
                            <img id="gambarPreview" src="https://placehold.co/128x128/E0E0E0/333333?text=No+Image" alt="Pratinjau Gambar" class="mt-2 hidden w-32 h-32 object-cover rounded-lg border border-gray-200">
                        </div>

                        <!-- Alamat (alamat) -->
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat:</label>
                            <input type="text" id="alamat" name="alamat"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required>
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website (Opsional):</label>
                            <input type="url" id="website" name="website"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"
                                placeholder="https://www.contoh.com">
                        </div>

                        <!-- Nomor Telepon (no_telp) -->
                        <div>
                            <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon:</label>
                            <input type="tel" id="no_telp" name="no_telp"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required
                                placeholder="081234567890">
                        </div>

                        <!-- Latitude -->
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitude:</label>
                            <input type="text" id="latitude" name="latitude"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" placeholder="-6.557084">
                        </div>

                        <!-- Longitude -->
                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitude:</label>
                            <input type="text" id="longitude" name="longitude"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" placeholder="107.446163">
                        </div>

                        <!-- Jam Buka -->
                        <div>
                            <label for="jam_buka" class="block text-sm font-medium text-gray-700 mb-1">Jam Buka:</label>
                            <input type="text" id="jam_buka" name="jam_buka"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required
                                placeholder="08:00">
                        </div>

                        <!-- Jam Tutup -->
                        <div>
                            <label for="jam_tutup" class="block text-sm font-medium text-gray-700 mb-1">Jam Tutup:</label>
                            <input type="text" id="jam_tutup" name="jam_tutup"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" required
                                placeholder="22:00">
                        </div>
                    </div>
                </div>

                <!-- Buttons remain at the bottom, outside the scrollable area -->
                <div class="flex items-center justify-end space-x-4 pt-4 mt-auto flex-shrink-0">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105">
                        Simpan
                    </button>
                    <button type="button" id="cancelHotelModal"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-5 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out transform hover:scale-105">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>








    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggleOpen = document.getElementById('sidebarToggleOpen');
        const sidebarToggleClose = document.getElementById('sidebarToggleClose');
        const logoutButton = document.getElementById('logoutButton');
        const currentViewTitle = document.getElementById('currentViewTitle'); // Element to update header title

        // Dashboard specific elements
        const totalWisataCountElement = document.getElementById('totalWisataCount');
        const totalHotelCountElement = document.getElementById('totalHotelCount');
        const totalLokerCountElement = document.getElementById('totalLokerCount');
        const totalSekolahCountElement = document.getElementById('totalSekolahCount');
        const totalDokterCountElement = document.getElementById('totalDokterCount');
        const totalInformasiPentingCountElement = document.getElementById('totalInformasiPentingCount');
        const totalStatsChartCanvas = document.getElementById('totalStatsChart');


        const messageBoxContainer = document.getElementById('messageBoxContainer');

        let myChart; // Declare a variable to hold the chart instance

        // Function to show custom message box (replaces alert())
        function showMessageBox(message, type = 'info') {
            const messageBox = document.createElement('div');
            messageBox.className = `message-box p-4 rounded-lg shadow-lg text-white mb-2 transform translate-x-full`;

            if (type === 'success') {
                messageBox.classList.add('bg-green-500');
            } else if (type === 'error') {
                messageBox.classList.add('bg-red-500');
            } else {
                messageBox.classList.add('bg-blue-500');
            }

            messageBox.textContent = message;
            messageBoxContainer.appendChild(messageBox);

            // Animate in
            setTimeout(() => {
                messageBox.style.transform = 'translateX(0)';
            }, 10); // Small delay for transition to work

            // Animate out and remove after 3 seconds
            setTimeout(() => {
                messageBox.style.transform = 'translateX(100%)';
                messageBox.addEventListener('transitionend', () => messageBox.remove());
            }, 3000);
        }

        // Function to toggle sidebar visibility on mobile
        sidebarToggleOpen.addEventListener('click', () => {
            sidebar.classList.add('open');
        });

        sidebarToggleClose.addEventListener('click', () => {
            sidebar.classList.remove('open');
        });

        // Event listener for logout
        logoutButton.addEventListener('click', async (e) => {
            e.preventDefault();
            const token = localStorage.getItem('admin_token');

            if (!token) {
                showMessageBox('Anda tidak login.', 'info');
                window.location.href = 'login.html';
                return;
            }

            try {
                const response = await fetch('http://127.0.0.1:8000/api/auth/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const result = await response.json();

                if (result.status) {
                    showMessageBox(result.message, 'success');
                    localStorage.removeItem('admin_token');
                    window.location.href = 'login.html';
                } else {
                    showMessageBox('Gagal logout: ' + result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessageBox('Terjadi kesalahan saat logout.', 'error');
            }
        });

        // Adjust sidebar visibility for screen size
        function adjustSidebarForScreenSize() {
            if (window.innerWidth < 768) {
                sidebar.classList.remove('open');
                sidebar.style.transform = 'translateX(-100%)';
            } else {
                sidebar.style.transform = 'translateX(0)';
            }
        }

        // Function to fetch total counts from the backend (Dashboard specific)
        async function fetchTotalCounts() {
            const baseUrl = 'http://127.0.0.1:8000/api';
            const token = localStorage.getItem('admin_token');

            const headers = {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            };

            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }

            let wisataCount = 0;
            let hotelCount = 0;
            let lokerCount = parseInt(totalLokerCountElement.textContent) || 0;
            let sekolahCount = 0;
            let dokterCount = 0;
            let informasiPentingCount = 0;

            // Fetch Total Wisata
            try {
                const response = await fetch(`${baseUrl}/wisata/index/jumlah`, { headers: headers });
                const data = await response.json();
                if (response.ok && data.count !== undefined) {
                    wisataCount = parseInt(data.count);
                    totalWisataCountElement.textContent = wisataCount;
                } else {
                    totalWisataCountElement.textContent = 'N/A';
                    console.error('Failed to fetch total wisata:', data.message || 'Unknown error');
                }
            } catch (error) {
                totalWisataCountElement.textContent = 'Error';
                console.error('Error fetching total wisata:', error);
            }

            // Fetch Total Hotel
            try {
                const response = await fetch(`${baseUrl}/hotels/index/jumlah`, { headers: headers });
                const data = await response.json();
                if (response.ok && data.count !== undefined) {
                    hotelCount = parseInt(data.count);
                    totalHotelCountElement.textContent = hotelCount;
                } else {
                    totalHotelCountElement.textContent = 'N/A';
                    console.error('Failed to fetch total hotel:', data.message || 'Unknown error');
                }
            } catch (error) {
                totalHotelCountElement.textContent = 'Error';
                console.error('Error fetching total hotel:', error);
            }

            // Fetch Total Loker
            try {
                const response = await fetch(`${baseUrl}/loker/index/jumlah`, { headers: headers });
                const data = await response.json();
                if (response.ok && data.count !== undefined) {
                    lokerCount = parseInt(data.count);
                    totalLokerCountElement.textContent = lokerCount;
                } else {
                    totalLokerCountElement.textContent = 'N/A';
                    console.error('Failed to fetch total loker:', data.message || 'Unknown error');
                }
            } catch (error) {
                totalLokerCountElement.textContent = 'Error';
                console.error('Error fetching total loker:', error);
            }

            // Fetch Total Sekolah
            try {
                const response = await fetch(`${baseUrl}/sekolah/index/jumlah`, { headers: headers });
                const data = await response.json();
                if (response.ok && data.count !== undefined) {
                    sekolahCount = parseInt(data.count);
                    totalSekolahCountElement.textContent = sekolahCount;
                } else {
                    totalSekolahCountElement.textContent = 'N/A';
                    console.error('Failed to fetch total sekolah:', data.message || 'Unknown error');
                }
            } catch (error) {
                totalSekolahCountElement.textContent = 'Error';
                console.error('Error fetching total sekolah:', error);
            }

            // Fetch Total Dokter
            try {
                const response = await fetch(`${baseUrl}/dokter/index/jumlah`, { headers: headers });
                const data = await response.json();
                if (response.ok && data.count !== undefined) {
                    dokterCount = parseInt(data.count);
                    totalDokterCountElement.textContent = dokterCount;
                } else {
                    totalDokterCountElement.textContent = 'N/A';
                    console.error('Failed to fetch total dokter:', data.message || 'Unknown error');
                }
            } catch (error) {
                totalDokterCountElement.textContent = 'Error';
                console.error('Error fetching total dokter:', error);
            }

            // Fetch Total Informasi Penting
            try {
                const response = await fetch(`${baseUrl}/informasi/index/jumlah`, { headers: headers });
                const data = await response.json();
                if (response.ok && data.count !== undefined) {
                    informasiPentingCount = parseInt(data.count);
                    totalInformasiPentingCountElement.textContent = informasiPentingCount;
                } else {
                    totalInformasiPentingCountElement.textContent = 'N/A';
                    console.error('Failed to fetch total informasi penting:', data.message || 'Unknown error');
                }
            } catch (error) {
                totalInformasiPentingCountElement.textContent = 'Error';
                console.error('Error fetching total informasi penting:', error);
            }

            // After fetching, update the chart
            updateChartWithFetchedData(wisataCount, hotelCount, lokerCount, sekolahCount, dokterCount, informasiPentingCount);
        }

        // Chart.js Initialization and Update (Dashboard specific)
        function updateChartWithFetchedData(wisataCount, hotelCount, lokerCount, sekolahCount, dokterCount, informasiPentingCount) {
            // Ensure the canvas element exists before trying to get its context
            if (!totalStatsChartCanvas) {
                console.error("Canvas element for chart not found.");
                return;
            }

            const ctx = totalStatsChartCanvas.getContext('2d');

            const chartDataConfig = {
                labels: ['Wisata', 'Hotel', 'Loker', 'Sekolah', 'Dokter', 'Info Penting'],
                datasets: [
                    {
                        label: 'Jumlah Total',
                        data: [wisataCount, hotelCount, lokerCount, sekolahCount, dokterCount, informasiPentingCount],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.6)', // Wisata (Teal)
                            'rgba(153, 102, 255, 0.6)', // Hotel (Purple)
                            'rgba(255, 159, 64, 0.6)', // Loker (Orange)
                            'rgba(255, 99, 132, 0.6)', // Sekolah (Red)
                            'rgba(54, 162, 235, 0.6)', // Dokter (Blue)
                            'rgba(201, 203, 207, 0.6)' // Info Penting (Gray)
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(201, 203, 207, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 5,
                    }
                ]
            };

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: '#333',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#555',
                        borderWidth: 1,
                        borderRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y;
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#4a5568',
                            font: {
                                family: 'Inter',
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0'
                        },
                        ticks: {
                            color: '#4a5568',
                            font: {
                                family: 'Inter',
                            }
                        }
                    }
                }
            };

            if (myChart) {
                myChart.destroy();
            }
            myChart = new Chart(ctx, {
                type: 'bar',
                data: chartDataConfig,
                options: chartOptions,
            });
        }

        // --- Manajemen Wisata Specific Functions ---
        const addWisataButton = document.getElementById('addWisataButton');
        const wisataModal = document.getElementById('wisataModal');
        const closeWisataModalButton = document.getElementById('closeWisataModal');
        const wisataForm = document.getElementById('wisataForm');
        const modalTitle = document.getElementById('modalTitle');
        const wisataIdInput = document.getElementById('wisataId');

        // Input fields for the form - IDs must match the HTML form
        const namaInput = document.getElementById('nama'); // Corresponds to 'nama' in JSON
        const kategoriInput = document.getElementById('kategori'); // New field
        const deskripsiInput = document.getElementById('deskripsi');
        const imageInput = document.getElementById('image'); // Corresponds to 'image' in JSON
        const gambarPreview = document.getElementById('gambarPreview');
        const alamatInput = document.getElementById('alamat'); // Corresponds to 'alamat' in JSON (was 'lokasi')
        const websiteInput = document.getElementById('website'); // New field
        const noTelpInput = document.getElementById('no_telp'); // New field
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const prioritasInput = document.getElementById('prioritas'); // New field
        const checkoutCheckbox = document.getElementById('checkout'); // Correctly reference the checkbox
        const jamBukaInput = document.getElementById('jam_buka'); // New field
        const jamTutupInput = document.getElementById('jam_tutup'); // New field
        const childPriceInput = document.getElementById('child_price'); // New field
        const adultPriceInput = document.getElementById('adult_price'); // New field

        const wisataTableBody = document.getElementById('wisataTableBody');

        const baseUrl = 'http://127.0.0.1:8000/api'; // Base URL for Laravel API
        const imageBaseUrl = 'http://127.0.0.1:8000/storage/wisata_images/'; // Base URL for images

        // Function to show a custom message box (replaces alert())
        function showMessageBox(message, type = 'info') {
            const messageBox = document.createElement('div');
            messageBox.className = `fixed bottom-4 right-4 p-4 rounded-lg shadow-lg text-white z-[1000] transition-all duration-300 transform translate-y-full opacity-0`;

            if (type === 'success') {
                messageBox.classList.add('bg-green-500');
            } else if (type === 'error') {
                messageBox.classList.add('bg-red-500');
            } else {
                messageBox.classList.add('bg-blue-500');
            }

            messageBox.textContent = message;
            document.body.appendChild(messageBox);

            // Animate in
            setTimeout(() => {
                messageBox.classList.remove('translate-y-full', 'opacity-0');
                messageBox.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            // Animate out after 3 seconds
            setTimeout(() => {
                messageBox.classList.remove('translate-y-0', 'opacity-100');
                messageBox.classList.add('translate-y-full', 'opacity-0');
                messageBox.addEventListener('transitionend', () => messageBox.remove());
            }, 3000);
        }

        // Function to open the modal
        function openWisataModal(wisata = null) {
            wisataForm.reset();
            gambarPreview.classList.add('hidden');
            gambarPreview.src = "https://placehold.co/128x128/E0E0E0/333333?text=No+Image"; // Reset to placeholder
            wisataIdInput.value = '';
            checkoutCheckbox.checked = false; // Ensure checkbox is unchecked for new entries

            if (wisata) {
                modalTitle.textContent = 'Edit Data Wisata';
                wisataIdInput.value = wisata.id;
                namaInput.value = wisata.nama || ''; // Use 'nama'
                kategoriInput.value = wisata.kategori || ''; // New field
                deskripsiInput.value = wisata.deskripsi || '';
                alamatInput.value = wisata.alamat || ''; // Use 'alamat'
                websiteInput.value = wisata.website || ''; // New field
                noTelpInput.value = wisata.no_telp || ''; // New field
                latitudeInput.value = wisata.latitude || '';
                longitudeInput.value = wisata.longitude || '';
                prioritasInput.value = wisata.prioritas || 0; // New field, default 0

                // Set checkbox state based on the 'checkout' value from the fetched data.
                // Using `!!` (double negation) converts any truthy value (like 1, true, "1") to true,
                // and any falsy value (like 0, false, null, undefined) to false.
                checkoutCheckbox.checked = wisata.checkout == 1;


                jamBukaInput.value = wisata.jam_buka || ''; // New field
                jamTutupInput.value = wisata.jam_tutup || ''; // New field
                childPriceInput.value = wisata.child_price || 0; // New field, default 0
                adultPriceInput.value = wisata.adult_price || 0; // New field, default 0

                if (wisata.image) { // Use 'image'
                    gambarPreview.src = imageBaseUrl + wisata.image; // Construct full image URL
                    gambarPreview.classList.remove('hidden');
                }
            } else {
                modalTitle.textContent = 'Tambah Wisata Baru';
            }
            wisataModal.classList.remove('hidden');
            wisataModal.classList.add('flex'); // Use flex to center
            setTimeout(() => {
                wisataModal.querySelector('.modal-content').classList.add('scale-100', 'opacity-100');
                wisataModal.querySelector('.modal-content').classList.remove('scale-95', 'opacity-0');
            }, 50);
        }

        // Function to close the modal
        function closeWisataModal() {
            wisataModal.querySelector('.modal-content').classList.remove('scale-100', 'opacity-100');
            wisataModal.querySelector('.modal-content').classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                wisataModal.classList.add('hidden');
                wisataModal.classList.remove('flex');
            }, 300); // Match transition duration
        }

        // Event listener for "Tambah Wisata Baru" button
        // Ensure 'addWisataButton' exists in your HTML
        if (addWisataButton) {
            addWisataButton.addEventListener('click', () => openWisataModal());
        }


        // Event listener for closing modal
        closeWisataModalButton.addEventListener('click', closeWisataModal);
        // Ensure 'cancelWisataModal' button also closes the modal
        const cancelWisataModalButton = document.getElementById('cancelWisataModal');
        if (cancelWisataModalButton) {
            cancelWisataModalButton.addEventListener('click', closeWisataModal);
        }

        wisataModal.addEventListener('click', (e) => {
            if (e.target === wisataModal) {
                closeWisataModal();
            }
        });

        // Handle image preview
        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    gambarPreview.src = e.target.result;
                    gambarPreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                gambarPreview.src = "https://placehold.co/128x128/E0E0E0/333333?text=No+Image";
                gambarPreview.classList.add('hidden');
            }
        });

        // Get current location (optional, for latitude/longitude)
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    latitudeInput.value = position.coords.latitude;
                    longitudeInput.value = position.coords.longitude;
                    showMessageBox('Lokasi berhasil didapatkan!', 'success');
                }, (error) => {
                    console.error('Error getting location:', error);
                    showMessageBox('Gagal mendapatkan lokasi. Pastikan izin lokasi diberikan.', 'error');
                });
            } else {
                showMessageBox('Geolocation tidak didukung oleh browser ini.', 'error');
            }
        }

        // Function to fetch and display wisata data (with more robust error handling and logging)
        async function fetchWisata() {
            if (!wisataTableBody) {
                console.error("Element with ID 'wisataTableBody' not found.");
                return;
            }
            wisataTableBody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Memuat data wisata...</td></tr>';
            const token = localStorage.getItem('admin_token');
            const headers = {
                'Accept': 'application/json',
            };
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }

            console.log('Attempting to fetch wisata data...');
            console.log('Request URL:', `${baseUrl}/wisata`);
            console.log('Request Headers:', headers);

            try {
                const response = await fetch(`${baseUrl}/wisata`, { headers: headers });
                console.log('Response received:', response);

                if (!response.ok) {
                    const errorText = await response.text(); // Get raw text to debug
                    console.error('HTTP Error Response Text:', errorText);
                    let errorMessage = `HTTP error! Status: ${response.status}`;
                    try {
                        const errorJson = JSON.parse(errorText);
                        if (errorJson.message) {
                            errorMessage += ` - ${errorJson.message}`;
                        }
                    } catch (e) {
                        // Not a JSON response, use raw text
                    }
                    wisataTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-red-500">Gagal memuat data: ${errorMessage}</td></tr>`;
                    showMessageBox(`Gagal memuat data wisata: ${errorMessage}`, 'error');
                    return;
                }

                const result = await response.json();
                console.log('Parsed JSON result:', result);

                // Check if the response has a 'data' key and if it's an array
                if (result.status && Array.isArray(result.data)) {
                    renderWisataTable(result.data);
                    showMessageBox('Data wisata berhasil dimuat.', 'success');
                } else if (result.status && result.data === null) {
                    // Handle case where data is null but status is true (e.g., empty array)
                    renderWisataTable([]); // Render empty table
                    showMessageBox('Tidak ada data wisata ditemukan.', 'info');
                } else {
                    const message = result.message || 'Format data tidak sesuai atau data tidak ditemukan.';
                    wisataTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-red-500">${message}</td></tr>`;
                    showMessageBox(`Gagal memuat data: ${message}`, 'error');
                    console.error('Unexpected API response structure:', result);
                }
            } catch (error) {
                console.error('Error fetching wisata:', error);
                wisataTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-red-500">Error jaringan atau server: ${error.message}</td></tr>`;
                showMessageBox(`Error jaringan atau server saat memuat data wisata: ${error.message}`, 'error');
            }
        }

        // Function to render wisata data into the table
        function renderWisataTable(wisataList) {
            wisataTableBody.innerHTML = ''; // Clear existing rows
            if (!wisataList || wisataList.length === 0) {
                wisataTableBody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data wisata.</td></tr>';
                return;
            }

            wisataList.forEach(wisata => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${wisata.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${wisata.image ? `<img src="${imageBaseUrl}${wisata.image}" alt="${wisata.nama}" class="w-16 h-16 object-cover rounded-md">` : 'Tidak ada gambar'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${wisata.nama}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${wisata.alamat}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">${wisata.deskripsi}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button data-id="${wisata.id}" class="edit-btn text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                        <button data-id="${wisata.id}" class="delete-btn text-red-600 hover:text-red-900">Hapus</button>
                    </td>
                `;
                wisataTableBody.appendChild(row);
            });

            // Add event listeners for edit and delete buttons
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const id = e.target.dataset.id;
                    const wisataToEdit = wisataList.find(w => w.id == id);
                    if (wisataToEdit) {
                        openWisataModal(wisataToEdit);
                    }
                });
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const id = e.target.dataset.id;
                    // Use a custom confirmation modal instead of browser's confirm()
                    showCustomConfirm('Apakah Anda yakin ingin menghapus data wisata ini?', () => {
                        deleteWisata(id);
                    });
                });
            });
        }

        // Custom Confirmation Modal (replaces browser's confirm())
        function showCustomConfirm(message, onConfirm) {
            const confirmModal = document.createElement('div');
            confirmModal.className = 'modal-overlay fixed inset-0 flex items-center justify-center p-4 bg-gray-900 bg-opacity-50 z-[1001]';
            confirmModal.innerHTML = `
                <div class="modal-content bg-white p-6 rounded-lg shadow-xl w-full max-w-sm relative transform scale-95 opacity-0 transition-all duration-300">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Konfirmasi</h3>
                    <p class="text-gray-700 mb-6">${message}</p>
                    <div class="flex justify-end space-x-4">
                        <button id="cancelConfirm" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out">
                            Batal
                        </button>
                        <button id="confirmAction" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out">
                            Hapus
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(confirmModal);

            const modalContent = confirmModal.querySelector('.modal-content');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 50);

            document.getElementById('confirmAction').addEventListener('click', () => {
                onConfirm();
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => confirmModal.remove(), 300);
            });

            document.getElementById('cancelConfirm').addEventListener('click', () => {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => confirmModal.remove(), 300);
            });

            confirmModal.addEventListener('click', (e) => {
                if (e.target === confirmModal) {
                    modalContent.classList.remove('scale-100', 'opacity-100');
                    modalContent.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => confirmModal.remove(), 300);
                }
            });
        }


        // Handle form submission for Add/Edit Wisata
        wisataForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const id = wisataIdInput.value;
            const formData = new FormData();

            // Append all form fields
            formData.append('nama', namaInput.value);
            formData.append('kategori', kategoriInput.value); // New
            formData.append('deskripsi', deskripsiInput.value);
            // Only append image if a new file is selected
            if (imageInput.files[0]) {
                formData.append('image', imageInput.files[0]);
            }
            formData.append('alamat', alamatInput.value); // Updated from 'lokasi'
            formData.append('website', websiteInput.value); // New
            formData.append('no_telp', noTelpInput.value); // New
            formData.append('latitude', latitudeInput.value);
            formData.append('longitude', longitudeInput.value);
            formData.append('prioritas', prioritasInput.value); // New

            // CORRECTLY append the 0 or 1 value for 'checkout' from the checkbox
            formData.append('checkout', checkoutCheckbox.checked ? 1 : 0); // Send 1 or 0

            formData.append('jam_buka', jamBukaInput.value); // New
            formData.append('jam_tutup', jamTutupInput.value); // New
            formData.append('child_price', childPriceInput.value); // New
            formData.append('adult_price', adultPriceInput.value); // New


            const token = localStorage.getItem('admin_token');
            const headers = {
                'Accept': 'application/json',
                // 'Content-Type': 'multipart/form-data' is automatically set by FormData
            };
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }

            let url = `${baseUrl}/wisata`;
            let method = 'POST';

            if (id) {
                url = `${baseUrl}/wisata/${id}`;
                method = 'POST'; // Still POST for Laravel's _method spoofing
                formData.append('_method', 'PUT'); // Spoof PUT method for Laravel
            }

            console.log('Submitting form...');
            console.log('URL:', url);
            console.log('Method:', method);
            // FormData cannot be easily logged directly, but you can inspect it in network tab
            // To see what's in formData (for debugging, not for production):
            // for (let pair of formData.entries()) {
            //     console.log(pair[0]+ ': ' + pair[1]);
            // }

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: headers,
                    body: formData,
                });

                const result = await response.json();
                console.log('Form submission response result:', result);

                if (response.ok) {
                    showMessageBox(result.message || 'Operasi wisata berhasil!', 'success');
                    closeWisataModal();
                    fetchWisata(); // Refresh the list
                } else {
                    // Handle validation errors or other API errors
                    let errorMessage = result.message || 'Gagal melakukan operasi wisata.';
                    if (result.errors) {
                        for (const key in result.errors) {
                            errorMessage += `\n${key}: ${result.errors[key].join(', ')}`;
                        }
                    }
                    showMessageBox(errorMessage, 'error');
                    console.error('Error response:', result);
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                showMessageBox('Terjadi kesalahan jaringan atau server saat menyimpan data wisata.', 'error');
            }
        });

        // Function to delete wisata data
        async function deleteWisata(id) {
            const token = localStorage.getItem('admin_token');
            const headers = {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            };
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }

            console.log('Attempting to delete wisata data...');
            console.log('Delete URL:', `${baseUrl}/wisata/${id}`);
            console.log('Delete Headers:', headers);

            try {
                const response = await fetch(`${baseUrl}/wisata/${id}`, {
                    method: 'DELETE',
                    headers: headers,
                });

                console.log('Delete response received:', response);
                const result = await response.json();
                console.log('Parsed delete result:', result);

                if (response.ok) {
                    showMessageBox(result.message || 'Data wisata berhasil dihapus!', 'success');
                    fetchWisata(); // Refresh the list
                } else {
                    showMessageBox(result.message || 'Gagal menghapus data wisata.', 'error');
                    console.error('Error response on delete:', result);
                }
            } catch (error) {
                console.error('Error deleting wisata:', error);
                showMessageBox('Terjadi kesalahan jaringan atau server saat menghapus data wisata.', 'error');
            }
        }















        // Script Hotel

        // const addHotelButton = document.getElementById('addHotelButton');
        // const hotelModal = document.getElementById('hotelModal');
        // const closeHotelModalButton = document.getElementById('closeHotelModal');
        // const hotelForm = document.getElementById('hotelForm');
        // const modalTitle = document.getElementById('modalTitle');
        // const hotelIdInput = document.getElementById('hotelId');

        // // Input fields for the form - IDs must match the HTML form
        // const namaInput = document.getElementById('nama');
        // const kategoriInput = document.getElementById('kategori');
        // const deskripsiInput = document.getElementById('deskripsi');
        // const imageInput = document.getElementById('image');
        // const gambarPreview = document.getElementById('gambarPreview');
        // const alamatInput = document.getElementById('alamat');
        // const websiteInput = document.getElementById('website');
        // const noTelpInput = document.getElementById('no_telp');
        // const latitudeInput = document.getElementById('latitude');
        // const longitudeInput = document.getElementById('longitude');
        // // Removed: prioritasInput, checkoutCheckbox, jamBukaInput, jamTutupInput, childPriceInput, adultPriceInput
        // // Based on the provided JSON, these fields are not present.

        // const hotelTableBody = document.getElementById('hotelTableBody');

        // const baseUrl = 'http://127.0.0.1:8000/api'; // Base URL for Laravel API
        // const imageBaseUrl = 'http://127.0.0.1:8000/storage/hotel_images/'; // Base URL for images

        // // Function to show a custom message box (replaces alert())
        // function showMessageBox(message, type = 'info') {
        //     const messageBox = document.createElement('div');
        //     messageBox.className = `fixed bottom-4 right-4 p-4 rounded-lg shadow-lg text-white z-[1000] transition-all duration-300 transform translate-y-full opacity-0`;

        //     if (type === 'success') {
        //         messageBox.classList.add('bg-green-500');
        //     } else if (type === 'error') {
        //         messageBox.classList.add('bg-red-500');
        //     } else {
        //         messageBox.classList.add('bg-blue-500');
        //     }

        //     messageBox.textContent = message;
        //     document.body.appendChild(messageBox);

        //     // Animate in
        //     setTimeout(() => {
        //         messageBox.classList.remove('translate-y-full', 'opacity-0');
        //         messageBox.classList.add('translate-y-0', 'opacity-100');
        //     }, 10);

        //     // Animate out after 3 seconds
        //     setTimeout(() => {
        //         messageBox.classList.remove('translate-y-0', 'opacity-100');
        //         messageBox.classList.add('translate-y-full', 'opacity-0');
        //         messageBox.addEventListener('transitionend', () => messageBox.remove());
        //     }, 3000);
        // }

        // // Function to open the modal
        // function openHotelModal(hotel = null) {
        //     hotelForm.reset();
        //     gambarPreview.classList.add('hidden');
        //     gambarPreview.src = "https://placehold.co/128x128/E0E0E0/333333?text=No+Image"; // Reset to placeholder
        //     hotelIdInput.value = '';

        //     if (hotel) {
        //         modalTitle.textContent = 'Edit Data Hotel';
        //         hotelIdInput.value = hotel.id;
        //         namaInput.value = hotel.nama || '';
        //         kategoriInput.value = hotel.kategori || '';
        //         deskripsiInput.value = hotel.deskripsi || '';
        //         alamatInput.value = hotel.alamat || '';
        //         websiteInput.value = hotel.website || '';
        //         noTelpInput.value = hotel.no_telp || '';
        //         latitudeInput.value = hotel.latitude || '';
        //         longitudeInput.value = hotel.longitude || '';
        //         // Removed: prioritasInput, checkoutCheckbox, jamBukaInput, jamTutupInput, childPriceInput, adultPriceInput
        //         // as they are not in the provided JSON structure.

        //         if (hotel.image) {
        //             gambarPreview.src = imageBaseUrl + hotel.image; // Construct full image URL
        //             gambarPreview.classList.remove('hidden');
        //         }
        //     } else {
        //         modalTitle.textContent = 'Tambah Hotel Baru';
        //     }
        //     hotelModal.classList.remove('hidden');
        //     hotelModal.classList.add('flex'); // Use flex to center
        //     setTimeout(() => {
        //         hotelModal.querySelector('.modal-content').classList.add('scale-100', 'opacity-100');
        //         hotelModal.querySelector('.modal-content').classList.remove('scale-95', 'opacity-0');
        //     }, 50);
        // }

        // // Function to close the modal
        // function closeHotelModal() {
        //     hotelModal.querySelector('.modal-content').classList.remove('scale-100', 'opacity-100');
        //     hotelModal.querySelector('.modal-content').classList.add('scale-95', 'opacity-0');
        //     setTimeout(() => {
        //         hotelModal.classList.add('hidden');
        //         hotelModal.classList.remove('flex');
        //     }, 300); // Match transition duration
        // }

        // // Event listener for "Tambah Hotel Baru" button
        // if (addHotelButton) {
        //     addHotelButton.addEventListener('click', () => openHotelModal());
        // }

        // // Event listener for closing modal
        // closeHotelModalButton.addEventListener('click', closeHotelModal);
        // const cancelHotelModalButton = document.getElementById('cancelHotelModal');
        // if (cancelHotelModalButton) {
        //     cancelHotelModalButton.addEventListener('click', closeHotelModal);
        // }

        // hotelModal.addEventListener('click', (e) => {
        //     if (e.target === hotelModal) {
        //         closeHotelModal();
        //     }
        // });

        // // Handle image preview
        // imageInput.addEventListener('change', (event) => {
        //     const file = event.target.files[0];
        //     if (file) {
        //         const reader = new FileReader();
        //         reader.onload = (e) => {
        //             gambarPreview.src = e.target.result;
        //             gambarPreview.classList.remove('hidden');
        //         };
        //         reader.readAsDataURL(file);
        //     } else {
        //         gambarPreview.src = "https://placehold.co/128x128/E0E0E0/333333?text=No+Image";
        //         gambarPreview.classList.add('hidden');
        //     }
        // });

        // // Get current location (optional, for latitude/longitude)
        // function getCurrentLocation() {
        //     if (navigator.geolocation) {
        //         navigator.geolocation.getCurrentPosition((position) => {
        //             latitudeInput.value = position.coords.latitude;
        //             longitudeInput.value = position.coords.longitude;
        //             showMessageBox('Lokasi berhasil didapatkan!', 'success');
        //         }, (error) => {
        //             console.error('Error getting location:', error);
        //             showMessageBox('Gagal mendapatkan lokasi. Pastikan izin lokasi diberikan.', 'error');
        //         });
        //     } else {
        //         showMessageBox('Geolocation tidak didukung oleh browser ini.', 'error');
        //     }
        // }

        // // Function to fetch and display hotel data
        // async function fetchHotel() {
        //     if (!hotelTableBody) {
        //         console.error("Element with ID 'hotelTableBody' not found.");
        //         return;
        //     }
        //     hotelTableBody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Memuat data hotel...</td></tr>';
        //     const token = localStorage.getItem('admin_token');
        //     const headers = {
        //         'Accept': 'application/json',
        //     };
        //     if (token) {
        //         headers['Authorization'] = `Bearer ${token}`;
        //     }

        //     console.log('Attempting to fetch hotel data...');
        //     console.log('Request URL:', `${baseUrl}/hotel`); // Updated endpoint
        //     console.log('Request Headers:', headers);

        //     try {
        //         const response = await fetch(`${baseUrl}/hotel`, { headers: headers });
        //         console.log('Response received:', response);

        //         if (!response.ok) {
        //             const errorText = await response.text();
        //             console.error('HTTP Error Response Text:', errorText);
        //             let errorMessage = `HTTP error! Status: ${response.status}`;
        //             try {
        //                 const errorJson = JSON.parse(errorText);
        //                 if (errorJson.message) {
        //                     errorMessage += ` - ${errorJson.message}`;
        //                 }
        //             } catch (e) {
        //                 // Not a JSON response, use raw text
        //             }
        //             hotelTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-red-500">Gagal memuat data: ${errorMessage}</td></tr>`;
        //             showMessageBox(`Gagal memuat data hotel: ${errorMessage}`, 'error');
        //             return;
        //         }

        //         const result = await response.json();
        //         console.log('Parsed JSON result:', result);

        //         if (result.status && Array.isArray(result.data)) {
        //             renderHotelTable(result.data);
        //             showMessageBox('Data hotel berhasil dimuat.', 'success');
        //         } else if (result.status && result.data === null) {
        //             renderHotelTable([]);
        //             showMessageBox('Tidak ada data hotel ditemukan.', 'info');
        //         } else {
        //             const message = result.message || 'Format data tidak sesuai atau data tidak ditemukan.';
        //             hotelTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-red-500">${message}</td></tr>`;
        //             showMessageBox(`Gagal memuat data: ${message}`, 'error');
        //             console.error('Unexpected API response structure:', result);
        //         }
        //     } catch (error) {
        //         console.error('Error fetching hotel:', error);
        //         hotelTableBody.innerHTML = `<tr><td colspan="6" class="px-6 py-4 text-center text-red-500">Error jaringan atau server: ${error.message}</td></tr>`;
        //         showMessageBox(`Error jaringan atau server saat memuat data hotel: ${error.message}`, 'error');
        //     }
        // }

        // // Function to render hotel data into the table
        // function renderHotelTable(hotelList) {
        //     hotelTableBody.innerHTML = ''; // Clear existing rows
        //     if (!hotelList || hotelList.length === 0) {
        //         hotelTableBody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data hotel.</td></tr>';
        //         return;
        //     }

        //     hotelList.forEach(hotel => {
        //         const row = document.createElement('tr');
        //         row.innerHTML = `
        //             <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${hotel.id}</td>
        //             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        //                 ${hotel.image ? `<img src="${imageBaseUrl}${hotel.image}" alt="${hotel.nama}" class="w-16 h-16 object-cover rounded-md">` : 'Tidak ada gambar'}
        //             </td>
        //             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${hotel.nama}</td>
        //             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${hotel.alamat}</td>
        //             <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">${hotel.deskripsi}</td>
        //             <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        //                 <button data-id="${hotel.id}" class="edit-btn text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
        //                 <button data-id="${hotel.id}" class="delete-btn text-red-600 hover:text-red-900">Hapus</button>
        //             </td>
        //         `;
        //         hotelTableBody.appendChild(row);
        //     });

        //     // Add event listeners for edit and delete buttons
        //     document.querySelectorAll('.edit-btn').forEach(button => {
        //         button.addEventListener('click', (e) => {
        //             const id = e.target.dataset.id;
        //             const hotelToEdit = hotelList.find(h => h.id == id);
        //             if (hotelToEdit) {
        //                 openHotelModal(hotelToEdit);
        //             }
        //         });
        //     });

        //     document.querySelectorAll('.delete-btn').forEach(button => {
        //         button.addEventListener('click', (e) => {
        //             const id = e.target.dataset.id;
        //             showCustomConfirm('Apakah Anda yakin ingin menghapus data hotel ini?', () => {
        //                 deleteHotel(id);
        //             });
        //         });
        //     });
        // }

        // // Custom Confirmation Modal (replaces browser's confirm())
        // function showCustomConfirm(message, onConfirm) {
        //     const confirmModal = document.createElement('div');
        //     confirmModal.className = 'modal-overlay fixed inset-0 flex items-center justify-center p-4 bg-gray-900 bg-opacity-50 z-[1001]';
        //     confirmModal.innerHTML = `
        //         <div class="modal-content bg-white p-6 rounded-lg shadow-xl w-full max-w-sm relative transform scale-95 opacity-0 transition-all duration-300">
        //             <h3 class="text-xl font-semibold text-gray-800 mb-4">Konfirmasi</h3>
        //             <p class="text-gray-700 mb-6">${message}</p>
        //             <div class="flex justify-end space-x-4">
        //                 <button id="cancelConfirm" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out">
        //                     Batal
        //                 </button>
        //                 <button id="confirmAction" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition duration-300 ease-in-out">
        //                     Hapus
        //                 </button>
        //             </div>
        //         </div>
        //     `;
        //     document.body.appendChild(confirmModal);

        //     const modalContent = confirmModal.querySelector('.modal-content');
        //     setTimeout(() => {
        //         modalContent.classList.remove('scale-95', 'opacity-0');
        //         modalContent.classList.add('scale-100', 'opacity-100');
        //     }, 50);

        //     document.getElementById('confirmAction').addEventListener('click', () => {
        //         onConfirm();
        //         modalContent.classList.remove('scale-100', 'opacity-100');
        //         modalContent.classList.add('scale-95', 'opacity-0');
        //         setTimeout(() => confirmModal.remove(), 300);
        //     });

        //     document.getElementById('cancelConfirm').addEventListener('click', () => {
        //         modalContent.classList.remove('scale-100', 'opacity-100');
        //         modalContent.classList.add('scale-95', 'opacity-0');
        //         setTimeout(() => confirmModal.remove(), 300);
        //     });

        //     confirmModal.addEventListener('click', (e) => {
        //         if (e.target === confirmModal) {
        //             modalContent.classList.remove('scale-100', 'opacity-100');
        //             modalContent.classList.add('scale-95', 'opacity-0');
        //             setTimeout(() => confirmModal.remove(), 300);
        //         }
        //     });
        // }

        // // Handle form submission for Add/Edit Hotel
        // hotelForm.addEventListener('submit', async (e) => {
        //     e.preventDefault();

        //     const id = hotelIdInput.value;
        //     const formData = new FormData();

        //     // Append all form fields present in the provided JSON structure
        //     formData.append('nama', namaInput.value);
        //     formData.append('kategori', kategoriInput.value);
        //     formData.append('deskripsi', deskripsiInput.value);
        //     // Only append image if a new file is selected
        //     if (imageInput.files[0]) {
        //         formData.append('image', imageInput.files[0]);
        //     }
        //     formData.append('alamat', alamatInput.value);
        //     formData.append('website', websiteInput.value);
        //     formData.append('no_telp', noTelpInput.value);
        //     formData.append('latitude', latitudeInput.value);
        //     formData.append('longitude', longitudeInput.value);
        //     // Removed: prioritas, checkout, jam_buka, jam_tutup, child_price, adult_price
        //     // as they are not in the provided JSON structure.

        //     const token = localStorage.getItem('admin_token');
        //     const headers = {
        //         'Accept': 'application/json',
        //     };
        //     if (token) {
        //         headers['Authorization'] = `Bearer ${token}`;
        //     }

        //     let url = `${baseUrl}/hotel`; // Updated endpoint
        //     let method = 'POST';

        //     if (id) {
        //         url = `${baseUrl}/hotel/${id}`; // Updated endpoint
        //         method = 'POST'; // Still POST for Laravel's _method spoofing
        //         formData.append('_method', 'PUT'); // Spoof PUT method for Laravel
        //     }

        //     console.log('Submitting form...');
        //     console.log('URL:', url);
        //     console.log('Method:', method);

        //     try {
        //         const response = await fetch(url, {
        //             method: method,
        //             headers: headers,
        //             body: formData,
        //         });

        //         const result = await response.json();
        //         console.log('Form submission response result:', result);

        //         if (response.ok) {
        //             showMessageBox(result.message || 'Operasi hotel berhasil!', 'success');
        //             closeHotelModal();
        //             fetchHotel(); // Refresh the list
        //         } else {
        //             let errorMessage = result.message || 'Gagal melakukan operasi hotel.';
        //             if (result.errors) {
        //                 for (const key in result.errors) {
        //                     errorMessage += `\n${key}: ${result.errors[key].join(', ')}`;
        //                 }
        //             }
        //             showMessageBox(errorMessage, 'error');
        //             console.error('Error response:', result);
        //         }
        //     } catch (error) {
        //         console.error('Error submitting form:', error);
        //         showMessageBox('Terjadi kesalahan jaringan atau server saat menyimpan data hotel.', 'error');
        //     }
        // });

        // // Function to delete hotel data
        // async function deleteHotel(id) {
        //     const token = localStorage.getItem('admin_token');
        //     const headers = {
        //         'Accept': 'application/json',
        //         'Content-Type': 'application/json',
        //     };
        //     if (token) {
        //         headers['Authorization'] = `Bearer ${token}`;
        //     }

        //     console.log('Attempting to delete hotel data...');
        //     console.log('Delete URL:', `${baseUrl}/hotel/${id}`); // Updated endpoint
        //     console.log('Delete Headers:', headers);

        //     try {
        //         const response = await fetch(`${baseUrl}/hotel/${id}`, {
        //             method: 'DELETE',
        //             headers: headers,
        //         });

        //         console.log('Delete response received:', response);
        //         const result = await response.json();
        //         console.log('Parsed delete result:', result);

        //         if (response.ok) {
        //             showMessageBox(result.message || 'Data hotel berhasil dihapus!', 'success');
        //             fetchHotel(); // Refresh the list
        //         } else {
        //             showMessageBox(result.message || 'Gagal menghapus data hotel.', 'error');
        //             console.error('Error response on delete:', result);
        //         }
        //     } catch (error) {
        //         console.error('Error deleting hotel:', error);
        //         showMessageBox('Terjadi kesalahan jaringan atau server saat menghapus data hotel.', 'error');
        //     }
        // }





































        // Simple Client-Side Router
        function router() {
            const hash = window.location.hash || '#dashboard'; // Default to dashboard
            const viewId = hash.substring(1); // Remove '#'

            // Hide all content sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });

            // Show the active section
            const activeSection = document.getElementById(viewId);
            if (activeSection) {
                activeSection.classList.add('active');
                // Update header title based on the active section
                const sidebarLink = document.querySelector(`a[href="${hash}"]`);
                if (sidebarLink) {
                    currentViewTitle.textContent = sidebarLink.textContent.trim();
                } else {
                    currentViewTitle.textContent = 'Dashboard Admin'; // Fallback
                }

                // If the active section is the dashboard, fetch data and render chart
                if (viewId === 'dashboard') {
                    fetchTotalCounts();
                } else if (myChart) {
                    // Destroy chart if navigating away from dashboard to prevent issues
                    myChart.destroy();
                    myChart = null;
                }

                // If the active section is manajemen-wisata, fetch its data
                if (viewId === 'manajemen-wisata') {
                    fetchWisata();
                }

            } else {
                // If hash doesn't match any section, default to dashboard
                document.getElementById('dashboard').classList.add('active');
                currentViewTitle.textContent = 'Dashboard Admin';
                fetchTotalCounts();
            }

            // Close sidebar on mobile after navigation
            if (window.innerWidth < 768) {
                sidebar.classList.remove('open');
            }
        }

        // Event listeners for routing
        window.addEventListener('hashchange', router);
        window.addEventListener('load', () => {
            adjustSidebarForScreenSize();
            router(); // Initial route load
        });
        window.addEventListener('resize', adjustSidebarForScreenSize);

        // Add click listeners to sidebar links to ensure router is called
        document.querySelectorAll('#sidebar nav ul li a').forEach(link => {
            link.addEventListener('click', (e) => {
                // Prevent default hash behavior if it's a logout button
                if (e.currentTarget.id === 'logoutButton') {
                    return; // Let the logout button's own event listener handle it
                }
                e.preventDefault();
                window.location.hash = e.currentTarget.getAttribute('href');
            });
        });
    </script>
</body>
</html>
