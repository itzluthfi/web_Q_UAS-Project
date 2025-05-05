<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - MyAnimeList Admin</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font yang cocok untuk tema anime -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #0f1116;
    }

    .glow-effect {
        box-shadow: 0 0 15px rgba(101, 31, 255, 0.4);
    }

    .btn-glow:hover {
        box-shadow: 0 0 20px rgba(101, 31, 255, 0.6);
    }

    .input-dark {
        background-color: rgba(30, 32, 44, 0.8);
        border-color: #2e3346;
        color: #e2e8f0;
    }

    .input-dark::placeholder {
        color: #64748b;
    }

    .input-dark:focus {
        border-color: #651fff;
        box-shadow: 0 0 0 2px rgba(101, 31, 255, 0.2);
    }

    .sidebar-link {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-link:hover {
        background-color: rgba(79, 70, 229, 0.1);
        border-left-color: #a855f7;
    }

    .sidebar-link.active {
        background-color: rgba(79, 70, 229, 0.2);
        border-left-color: #a855f7;
    }

    /* Custom scrollbar for webkit browsers */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #1f2937;
    }

    ::-webkit-scrollbar-thumb {
        background: #4c1d95;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #6d28d9;
    }

    /* Table styling */
    .admin-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .admin-table th {
        background-color: #1f2937;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }

    .admin-table tr {
        transition: all 0.2s ease;
    }

    .admin-table tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.1);
    }

    /* Modal animation */
    .modal {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .modal.hidden {
        opacity: 0;
        transform: scale(0.95);
        pointer-events: none;
    }

    /* Badge styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        font-weight: 500;
    }

    .badge-admin {
        background-color: rgba(139, 92, 246, 0.2);
        color: #a78bfa;
    }

    .badge-user {
        background-color: rgba(45, 212, 191, 0.2);
        color: #5eead4;
    }

    .badge-moderator {
        background-color: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
    }

    /* Sidebar fixed */
    .sidebar {
        width: 260px;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        z-index: 40;
        overflow-y: auto;
    }

    /* Main content area */
    .main-wrapper {
        margin-left: 260px;
    }

    /* Dropdown menu */
    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background-color: #1f2937;
        border-radius: 0.375rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        z-index: 50;
        min-width: 10rem;
        margin-top: 0.5rem;
    }

    .dropdown-menu.show {
        display: block;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .main-wrapper {
            margin-left: 0;
        }

        .mobile-menu-button {
            display: block;
        }
    }

    @media (min-width: 769px) {
        .mobile-menu-button {
            display: none;
        }
    }

    /* Action buttons */
    .action-button {
        transition: all 0.2s ease;
    }

    .action-button:hover {
        transform: translateY(-2px);
    }

    /* Tooltip */
    .tooltip {
        position: relative;
    }

    .tooltip .tooltip-text {
        visibility: hidden;
        width: 120px;
        background-color: #1f2937;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -60px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .tooltip:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100">
    <!-- Sidebar -->
    <aside class="sidebar bg-gray-900 border-r border-gray-800">
        <!-- Logo -->
        <div class="p-4 border-b border-gray-800">
            <div class="flex items-center">
                <div class="h-10 w-10 bg-purple-700 rounded-full flex items-center justify-center mr-2 glow-effect">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                    </svg>
                </div>
                <span class="text-white font-bold text-xl">MyAnimeList</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-4">
            <div class="px-4 py-2">
                <h5 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</h5>
            </div>

            <a href="admin-dashboard.php"
                class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Halaman Utama
            </a>

            <a href="<?= route('admin.dashboard')?>"
                class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                </svg>
                Dashboard
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd" />
                </svg>
                Profil Saya
            </a>

            <div class="px-4 py-2 mt-4">
                <h5 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen</h5>
            </div>

            <a href="user-management.php" class="sidebar-link active flex items-center px-4 py-3 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                </svg>
                Pengguna
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                        clip-rule="evenodd" />
                </svg>
                Anime
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
                Manga
            </a>

            <div class="px-4 py-2 mt-4">
                <h5 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Sistem</h5>
            </div>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                        clip-rule="evenodd" />
                </svg>
                Pengaturan
            </a>

            <a href="#" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                Informasi Penting
            </a>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <nav class="bg-gray-900 border-b border-gray-800 sticky top-0 z-30">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Page Title -->
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button
                            class="mobile-menu-button mr-2 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <h1 class="text-xl font-medium text-white">Manajemen Pengguna</h1>
                    </div>

                    <!-- User Profile -->
                    <div class="flex items-center">
                        <div class="relative" id="user-menu">
                            <button class="flex items-center space-x-3 focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center">
                                    <span class="font-bold text-white">A</span>
                                </div>
                                <span class="hidden md:block text-sm font-medium text-white">Admin User</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu" id="user-dropdown">
                                <div class="py-1">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">Profil
                                        Saya</a>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">Pengaturan</a>
                                    <div class="border-t border-gray-700 my-1"></div>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">Keluar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="p-6">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-purple-400">Manajemen Pengguna</h2>
                    <p class="text-gray-400 mt-1">Kelola semua pengguna yang terdaftar di MyAnimeList</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <button onclick="openAddUserModal()"
                        class="bg-purple-700 hover:bg-purple-600 text-white px-4 py-2 rounded-md flex items-center btn-glow transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah Pengguna
                    </button>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-gray-800 rounded-lg p-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="relative flex-grow">
                        <input type="text" placeholder="Cari berdasarkan username, email, atau ID..."
                            class="input-dark w-full pl-10 pr-4 py-2 rounded-lg text-sm focus:outline-none">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <select class="input-dark rounded-lg px-4 py-2 text-sm focus:outline-none">
                            <option value="">Semua Peran</option>
                            <option value="admin">Admin</option>
                            <option value="moderator">Moderator</option>
                            <option value="user">User</option>
                        </select>
                        <select class="input-dark rounded-lg px-4 py-2 text-sm focus:outline-none">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                            <option value="banned">Diblokir</option>
                        </select>
                        <select class="input-dark rounded-lg px-4 py-2 text-sm focus:outline-none">
                            <option value="10">10 per halaman</option>
                            <option value="25">25 per halaman</option>
                            <option value="50">50 per halaman</option>
                            <option value="100">100 per halaman</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg mb-6">
                <div class="overflow-x-auto">
                    <table class="admin-table w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="form-checkbox h-4 w-4 text-purple-600 transition duration-150 ease-in-out">
                                        <span class="ml-2">ID</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Username
                                </th>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Peran
                                </th>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Tanggal
                                    Daftar</th>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Login
                                    Terakhir</th>
                                <th class="px-6 py-3 text-right text-xs text-gray-300 uppercase tracking-wider">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php
                            // Contoh data pengguna (dalam implementasi nyata, ini akan diambil dari database)
                            $users = [
                                ['id' => 1, 'username' => 'admin', 'email' => 'admin@myanimelist.com', 'role' => 'admin', 'status' => 'active', 'created_at' => '2023-01-15', 'last_login' => '2023-05-01 14:30:22'],
                                ['id' => 2, 'username' => 'naruto_uzumaki', 'email' => 'naruto@konoha.com', 'role' => 'user', 'status' => 'active', 'created_at' => '2023-02-20', 'last_login' => '2023-05-01 10:15:45'],
                                ['id' => 3, 'username' => 'sasuke_uchiha', 'email' => 'sasuke@konoha.com', 'role' => 'user', 'status' => 'active', 'created_at' => '2023-02-21', 'last_login' => '2023-04-30 22:45:12'],
                                ['id' => 4, 'username' => 'sakura_haruno', 'email' => 'sakura@konoha.com', 'role' => 'user', 'status' => 'inactive', 'created_at' => '2023-03-05', 'last_login' => '2023-04-25 09:20:33'],
                                ['id' => 5, 'username' => 'kakashi_sensei', 'email' => 'kakashi@konoha.com', 'role' => 'moderator', 'status' => 'active', 'created_at' => '2023-01-10', 'last_login' => '2023-05-01 08:10:05'],
                                ['id' => 6, 'username' => 'hinata_hyuga', 'email' => 'hinata@konoha.com', 'role' => 'user', 'status' => 'active', 'created_at' => '2023-03-15', 'last_login' => '2023-04-29 16:40:18'],
                                ['id' => 7, 'username' => 'shikamaru_nara', 'email' => 'shikamaru@konoha.com', 'role' => 'moderator', 'status' => 'active', 'created_at' => '2023-03-20', 'last_login' => '2023-04-30 11:25:37'],
                                ['id' => 8, 'username' => 'rock_lee', 'email' => 'lee@konoha.com', 'role' => 'user', 'status' => 'inactive', 'created_at' => '2023-04-01', 'last_login' => '2023-04-15 14:50:22'],
                                ['id' => 9, 'username' => 'gaara_sand', 'email' => 'gaara@sand.com', 'role' => 'user', 'status' => 'active', 'created_at' => '2023-04-10', 'last_login' => '2023-04-28 20:05:41'],
                                ['id' => 10, 'username' => 'itachi_uchiha', 'email' => 'itachi@akatsuki.com', 'role' => 'user', 'status' => 'banned', 'created_at' => '2023-04-15', 'last_login' => '2023-04-20 07:30:'],
                            ];
                            
                            foreach ($users as $user):
                            ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="form-checkbox h-4 w-4 text-purple-600 transition duration-150 ease-in-out">
                                        <span class="ml-2 text-sm text-gray-300"><?= $user['id'] ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                            <span
                                                class="font-bold text-white"><?= strtoupper(substr($user['username'], 0, 1)) ?></span>
                                        </div>
                                        <div class="text-sm font-medium text-white"><?= $user['username'] ?></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?= $user['email'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="badge <?= $user['role'] === 'admin' ? 'badge-admin' : ($user['role'] === 'moderator' ? 'badge-moderator' : 'badge-user') ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($user['status'] === 'active'): ?>
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                    <?php elseif ($user['status'] === 'inactive'): ?>
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Tidak Aktif
                                    </span>
                                    <?php else: ?>
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Diblokir
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?= $user['created_at'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?= $user['last_login'] ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <button onclick="openViewModal(<?= $user['id'] ?>)"
                                            class="action-button text-blue-400 hover:text-blue-300 transition-colors tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="tooltip-text">Lihat Detail</span>
                                        </button>
                                        <button onclick="openEditModal(<?= $user['id'] ?>)"
                                            class="action-button text-indigo-400 hover:text-indigo-300 transition-colors tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                            <span class="tooltip-text">Edit</span>
                                        </button>
                                        <button onclick="confirmDelete(<?= $user['id'] ?>, '<?= $user['username'] ?>')"
                                            class="action-button text-red-400 hover:text-red-300 transition-colors tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="tooltip-text">Hapus</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Bulk Actions and Pagination -->
                <div class="bg-gray-800 px-6 py-4 border-t border-gray-700">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <select class="input-dark rounded-lg px-4 py-2 text-sm focus:outline-none mr-2">
                                <option value="">Aksi Massal</option>
                                <option value="activate">Aktifkan</option>
                                <option value="deactivate">Nonaktifkan</option>
                                <option value="delete">Hapus</option>
                            </select>
                            <button
                                class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm transition-all">
                                Terapkan
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-400 mr-4">
                                Menampilkan 1-10 dari 100 pengguna
                            </div>
                            <div class="flex space-x-2">
                                <button
                                    class="px-3 py-1 rounded bg-gray-700 text-gray-300 hover:bg-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button class="px-3 py-1 rounded bg-purple-700 text-white">1</button>
                                <button
                                    class="px-3 py-1 rounded bg-gray-700 text-gray-300 hover:bg-gray-600 transition-colors">2</button>
                                <button
                                    class="px-3 py-1 rounded bg-gray-700 text-gray-300 hover:bg-gray-600 transition-colors">3</button>
                                <button
                                    class="px-3 py-1 rounded bg-gray-700 text-gray-300 hover:bg-gray-600 transition-colors">4</button>
                                <button
                                    class="px-3 py-1 rounded bg-gray-700 text-gray-300 hover:bg-gray-600 transition-colors">5</button>
                                <button
                                    class="px-3 py-1 rounded bg-gray-700 text-gray-300 hover:bg-gray-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 border-t border-gray-800 py-4 px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; 2023, Dibuat dengan
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-red-500" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd" />
                    </svg>
                    oleh MyAnimeList Team
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">Bantuan</a>
                    <a href="#" class="text-gray-400 hover:text-white">FAQ</a>
                    <a href="#" class="text-gray-400 hover:text-white">Kebijakan Privasi</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- View User Modal -->
    <div id="viewModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-white" id="view-modal-title">
                                Detail Pengguna
                            </h3>
                            <div class="mt-4">
                                <div class="bg-gray-700 rounded-lg p-4 mb-4">
                                    <div class="flex flex-col items-center sm:flex-row sm:items-start">
                                        <div
                                            class="h-20 w-20 rounded-full bg-purple-600 flex items-center justify-center mb-4 sm:mb-0 sm:mr-4">
                                            <span class="font-bold text-white text-2xl" id="view-user-initial">N</span>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-medium text-white" id="view-username">naruto_uzumaki
                                            </h4>
                                            <p class="text-gray-300" id="view-email">naruto@konoha.com</p>
                                            <div class="mt-2 flex items-center">
                                                <span class="badge badge-user mr-2" id="view-role">User</span>
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                                                    id="view-status">
                                                    Aktif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">ID:</span>
                                        <span class="text-white" id="view-id">2</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Tanggal Daftar:</span>
                                        <span class="text-white" id="view-created-at">2023-02-20</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Login Terakhir:</span>
                                        <span class="text-white" id="view-last-login">2023-05-01 10:15:45</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Anime Favorit:</span>
                                        <span class="text-white" id="view-favorite-anime">15</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Manga Favorit:</span>
                                        <span class="text-white" id="view-favorite-manga">8</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Komentar:</span>
                                        <span class="text-white" id="view-comments">42</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="openEditModal(2)"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Edit Pengguna
                    </button>
                    <button type="button" onclick="closeViewModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                Tambah Pengguna Baru
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="add-username"
                                        class="block text-sm font-medium text-gray-300">Username</label>
                                    <input type="text" id="add-username" class="mt-1 input-dark w-full rounded-md">
                                </div>
                                <div>
                                    <label for="add-email" class="block text-sm font-medium text-gray-300">Email</label>
                                    <input type="email" id="add-email" class="mt-1 input-dark w-full rounded-md">
                                </div>
                                <div>
                                    <label for="add-password"
                                        class="block text-sm font-medium text-gray-300">Password</label>
                                    <input type="password" id="add-password" class="mt-1 input-dark w-full rounded-md">
                                </div>
                                <div>
                                    <label for="add-confirm-password"
                                        class="block text-sm font-medium text-gray-300">Konfirmasi Password</label>
                                    <input type="password" id="add-confirm-password"
                                        class="mt-1 input-dark w-full rounded-md">
                                </div>
                                <div>
                                    <label for="add-role" class="block text-sm font-medium text-gray-300">Peran</label>
                                    <select id="add-role" class="mt-1 input-dark w-full rounded-md">
                                        <option value="user">User</option>
                                        <option value="moderator">Moderator</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="add-status"
                                        class="block text-sm font-medium text-gray-300">Status</label>
                                    <select id="add-status" class="mt-1 input-dark w-full rounded-md">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm btn-glow">
                        Tambah Pengguna
                    </button>
                    <button type="button" onclick="closeAddUserModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-white" id="edit-modal-title">
                                Edit Pengguna
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="edit-username"
                                        class="block text-sm font-medium text-gray-300">Username</label>
                                    <input type="text" id="edit-username" class="mt-1 input-dark w-full rounded-md">
                                </div>
                                <div>
                                    <label for="edit-email"
                                        class="block text-sm font-medium text-gray-300">Email</label>
                                    <input type="email" id="edit-email" class="mt-1 input-dark w-full rounded-md">
                                </div>
                                <div>
                                    <label for="edit-password" class="block text-sm font-medium text-gray-300">Password
                                        Baru (kosongkan jika tidak ingin mengubah)</label>
                                    <input type="password" id="edit-password" class="mt-1 input-dark w-full rounded-md">
                                </div>
                                <div>
                                    <label for="edit-role" class="block text-sm font-medium text-gray-300">Peran</label>
                                    <select id="edit-role" class="mt-1 input-dark w-full rounded-md">
                                        <option value="user">User</option>
                                        <option value="moderator">Moderator</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="edit-status"
                                        class="block text-sm font-medium text-gray-300">Status</label>
                                    <select id="edit-status" class="mt-1 input-dark w-full rounded-md">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                        <option value="banned">Diblokir</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                Hapus Pengguna
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-300" id="delete-confirmation-text">
                                    Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirm-delete-btn"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Hapus
                    </button>
                    <button type="button" onclick="closeDeleteModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal and Sidebar Functionality -->
    <script>
    // Toggle user dropdown
    const userMenu = document.getElementById('user-menu');
    const userDropdown = document.getElementById('user-dropdown');

    if (userMenu && userDropdown) {
        userMenu.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            userDropdown.classList.remove('show');
        });
    }

    // Mobile menu toggle
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const sidebar = document.querySelector('.sidebar');

    if (mobileMenuButton && sidebar) {
        mobileMenuButton.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 769 &&
                !sidebar.contains(e.target) &&
                !mobileMenuButton.contains(e.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    }

    // View Modal Functions
    const viewModal = document.getElementById('viewModal');

    function openViewModal(userId) {
        // In a real application, you would fetch user data based on userId
        // For this example, we'll just show the modal with placeholder data
        document.getElementById('view-username').textContent = 'naruto_uzumaki';
        document.getElementById('view-email').textContent = 'naruto@konoha.com';
        document.getElementById('view-role').textContent = 'User';
        document.getElementById('view-status').textContent = 'Aktif';
        document.getElementById('view-id').textContent = userId;
        document.getElementById('view-created-at').textContent = '2023-02-20';
        document.getElementById('view-last-login').textContent = '2023-05-01 10:15:45';
        document.getElementById('view-favorite-anime').textContent = '15';
        document.getElementById('view-favorite-manga').textContent = '8';
        document.getElementById('view-comments').textContent = '42';
        document.getElementById('view-user-initial').textContent = 'N';

        viewModal.classList.remove('hidden');
    }

    function closeViewModal() {
        viewModal.classList.add('hidden');
    }

    // Add User Modal Functions
    const addUserModal = document.getElementById('addUserModal');

    function openAddUserModal() {
        addUserModal.classList.remove('hidden');
    }

    function closeAddUserModal() {
        addUserModal.classList.add('hidden');
    }

    // Edit Modal Functions
    const editModal = document.getElementById('editModal');

    function openEditModal(userId) {
        // In a real application, you would fetch user data based on userId
        // For this example, we'll just show the modal with placeholder data
        document.getElementById('edit-username').value = 'username_' + userId;
        document.getElementById('edit-email').value = 'user' + userId + '@example.com';

        editModal.classList.remove('hidden');
    }

    function closeEditModal() {
        editModal.classList.add('hidden');
    }

    // Delete Modal Functions
    const deleteModal = document.getElementById('deleteModal');
    let userIdToDelete = null;

    function confirmDelete(userId, username) {
        userIdToDelete = userId;
        document.getElementById('delete-confirmation-text').textContent =
            `Apakah Anda yakin ingin menghapus pengguna "${username}"? Tindakan ini tidak dapat dibatalkan.`;

        deleteModal.classList.remove('hidden');

        // Set up the delete button action
        document.getElementById('confirm-delete-btn').onclick = function() {
            deleteUser(userIdToDelete);
        };
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        userIdToDelete = null;
    }

    function deleteUser(userId) {
        // In a real application, you would send a request to delete the user
        // For this example, we'll just close the modal and show an alert
        alert('Pengguna dengan ID ' + userId + ' telah dihapus.');
        closeDeleteModal();

        // In a real application, you would refresh the table or remove the row
    }

    // Close modals when clicking outside
    window.addEventListener('click', (event) => {
        if (event.target === viewModal) {
            closeViewModal();
        }
        if (event.target === addUserModal) {
            closeAddUserModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });

    // Handle window resize for sidebar
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 769) {
            sidebar.classList.remove('show');
        }
    });
    </script>
</body>

</html>