@extends('layouts.dashboard')

@section('title', 'Manage Comments - MyAnimeList Admin')
    @push('styles')
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
        .badge-anime {
            background-color: rgba(139, 92, 246, 0.2);
            color: #a78bfa;
        }
        .badge-manga {
            background-color: rgba(45, 212, 191, 0.2);
            color: #5eead4;
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
            transition: transform 0.3s ease;
        }
        /* Main content area */
        .main-wrapper {
            transition: margin-left 0.3s ease;
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
        /* Card styling */
        .dashboard-card {
            background-color: #1f2937;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0 !important;
            }
        }
        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 30;
        }
        .sidebar-overlay.show {
            display: block;
        }
        /* Comment text truncation */
        .comment-text {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            height: 18px;
            width: 18px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* Collapsed sidebar styles */
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        .sidebar.collapsed .sidebar-logo-text {
            display: none;
        }
        .sidebar.collapsed .sidebar-group-label {
            display: none;
        }
        .main-wrapper.sidebar-collapsed {
            margin-left: 70px;
        }
    </style>
    @endpush

    @section('content')
    <!-- Main Content -->
    <main class="p-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="dashboard-card p-4 flex items-center">
                <div class="rounded-full bg-purple-900/30 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Total Komentar</p>
                    <h3 class="text-2xl font-bold text-white">5,721</h3>
                    <p class="text-green-500 text-xs flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        8.5% dari bulan lalu
                    </p>
                </div>
            </div>
            
            <div class="dashboard-card p-4 flex items-center">
                <div class="rounded-full bg-blue-900/30 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Komentar Hari Ini</p>
                    <h3 class="text-2xl font-bold text-white">128</h3>
                    <p class="text-green-500 text-xs flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        12.2% dari kemarin
                    </p>
                </div>
            </div>
            
            <div class="dashboard-card p-4 flex items-center">
                <div class="rounded-full bg-pink-900/30 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Komentar Dilaporkan</p>
                    <h3 class="text-2xl font-bold text-white">23</h3>
                    <p class="text-red-500 text-xs flex items-center mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        5.3% dari bulan lalu
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Comments Section -->
        <div class="dashboard-card p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-purple-400">Kelola Komentar</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" placeholder="Cari komentar..." class="input-dark rounded-md pl-10 pr-4 py-2 w-64">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <select class="input-dark rounded-md px-4 py-2">
                        <option value="all">Semua Komentar</option>
                        <option value="anime">Anime</option>
                        <option value="manga">Manga</option>
                        <option value="reported">Dilaporkan</option>
                    </select>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="admin-table w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Komentar</th>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Konten</th>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-right text-xs text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <!-- Comment Row 1 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                        <span class="font-bold text-white">N</span>
                                    </div>
                                    <div class="text-sm font-medium text-white">naruto_uzumaki</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-300 comment-text">Anime ini sangat bagus! Saya sangat menyukai alur ceritanya dan karakter-karakternya sangat menarik. Tidak sabar menunggu episode selanjutnya!</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="badge badge-anime">One Piece</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2023-05-20 14:30</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/anime/one-piece#comment-1" class="text-blue-400 hover:text-blue-300 mr-3" title="Lihat Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <button onclick="openEditModal('1')" class="text-purple-400 hover:text-purple-300 mr-3" title="Edit Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <button onclick="confirmDelete('1')" class="text-red-400 hover:text-red-300" title="Hapus Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Comment Row 2 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                        <span class="font-bold text-white">S</span>
                                    </div>
                                    <div class="text-sm font-medium text-white">sasuke_uchiha</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-300 comment-text">Manga ini terlalu lambat perkembangannya. Sudah 3 chapter dan ceritanya masih di tempat yang sama. Saya harap penulis bisa mempercepat alur ceritanya.</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="badge badge-manga">Naruto</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2023-05-19 09:15</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/manga/naruto#comment-2" class="text-blue-400 hover:text-blue-300 mr-3" title="Lihat Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <button onclick="openEditModal('2')" class="text-purple-400 hover:text-purple-300 mr-3" title="Edit Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <button onclick="confirmDelete('2')" class="text-red-400 hover:text-red-300" title="Hapus Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Comment Row 3 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                        <span class="font-bold text-white">S</span>
                                    </div>
                                    <div class="text-sm font-medium text-white">sakura_haruno</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-300 comment-text">Animasi pertarungan di episode ini luar biasa! Studio animasi benar-benar melakukan pekerjaan yang hebat. Saya menonton adegan pertarungan itu berulang kali.</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="badge badge-anime">Demon Slayer</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2023-05-18 22:45</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/anime/demon-slayer#comment-3" class="text-blue-400 hover:text-blue-300 mr-3" title="Lihat Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <button onclick="openEditModal('3')" class="text-purple-400 hover:text-purple-300 mr-3" title="Edit Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <button onclick="confirmDelete('3')" class="text-red-400 hover:text-red-300" title="Hapus Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Comment Row 4 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                        <span class="font-bold text-white">H</span>
                                    </div>
                                    <div class="text-sm font-medium text-white">hinata_hyuga</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-300 comment-text">Saya pikir ending manga ini sangat mengecewakan. Setelah bertahun-tahun mengikuti cerita, saya berharap lebih dari ini. Banyak plot hole yang tidak terselesaikan.</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="badge badge-manga">Bleach</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2023-05-17 16:20</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/manga/bleach#comment-4" class="text-blue-400 hover:text-blue-300 mr-3" title="Lihat Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <button onclick="openEditModal('4')" class="text-purple-400 hover:text-purple-300 mr-3" title="Edit Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <button onclick="confirmDelete('4')" class="text-red-400 hover:text-red-300" title="Hapus Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Comment Row 5 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                        <span class="font-bold text-white">S</span>
                                    </div>
                                    <div class="text-sm font-medium text-white">shikamaru_nara</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-300 comment-text">Film anime ini adalah salah satu yang terbaik yang pernah saya tonton. Cerita, animasi, musik, semuanya sempurna. Saya sangat merekomendasikannya kepada semua penggemar anime.</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="badge badge-anime">Your Name</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2023-05-16 11:05</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/anime/your-name#comment-5" class="text-blue-400 hover:text-blue-300 mr-3" title="Lihat Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <button onclick="openEditModal('5')" class="text-purple-400 hover:text-purple-300 mr-3" title="Edit Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <button onclick="confirmDelete('5')" class="text-red-400 hover:text-red-300" title="Hapus Komentar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-between items-center mt-6">
                <div class="text-sm text-gray-400">
                    Menampilkan 1-5 dari 5,721 komentar
                </div>
                <div class="flex space-x-1">
                    <button class="px-3 py-1 rounded bg-gray-800 text-gray-400 hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button class="px-3 py-1 rounded bg-purple-700 text-white">1</button>
                    <button class="px-3 py-1 rounded bg-gray-800 text-gray-400 hover:bg-gray-700">2</button>
                    <button class="px-3 py-1 rounded bg-gray-800 text-gray-400 hover:bg-gray-700">3</button>
                    <button class="px-3 py-1 rounded bg-gray-800 text-gray-400 hover:bg-gray-700">...</button>
                    <button class="px-3 py-1 rounded bg-gray-800 text-gray-400 hover:bg-gray-700">573</button>
                    <button class="px-3 py-1 rounded bg-gray-800 text-gray-400 hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </main>
    @endsection

    <!-- Edit Comment Modal -->
    <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                Edit Komentar
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="edit-username" class="block text-sm font-medium text-gray-300">Pengguna</label>
                                    <input type="text" id="edit-username" class="mt-1 input-dark w-full rounded-md" disabled>
                                </div>
                                <div>
                                    <label for="edit-content" class="block text-sm font-medium text-gray-300">Konten</label>
                                    <input type="text" id="edit-content-type" class="mt-1 input-dark w-full rounded-md" disabled>
                                </div>
                                <div>
                                    <label for="edit-comment" class="block text-sm font-medium text-gray-300">Komentar</label>
                                    <textarea id="edit-comment" rows="4" class="mt-1 input-dark w-full rounded-md"></textarea>
                                </div>
                                <input type="hidden" id="edit-comment-id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="saveComment()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm btn-glow">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
            <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                Hapus Komentar
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-300">
                                    Apakah Anda yakin ingin menghapus komentar ini? Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="deleteComment()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Hapus
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
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
        
        // Sidebar toggle functionality
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainWrapper = document.getElementById('mainWrapper');
        
        // Function to toggle sidebar in desktop mode
        function toggleDesktopSidebar() {
            if (window.innerWidth >= 768) {
                sidebar.classList.toggle('collapsed');
                mainWrapper.classList.toggle('sidebar-collapsed');
                
                if (sidebar.classList.contains('collapsed')) {
                    mainWrapper.style.marginLeft = '70px';
                } else {
                    mainWrapper.style.marginLeft = '260px';
                }
            }
        }
        
        // Function to open sidebar in mobile mode
        function openMobileSidebar() {
            if (window.innerWidth < 768) {
                sidebar.classList.add('show');
                sidebarOverlay.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent scrolling when sidebar is open
            }
        }
        
        // Function to close sidebar in mobile mode
        function closeMobileSidebar() {
            if (window.innerWidth < 768) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = ''; // Re-enable scrolling
            }
        }
        
        // Toggle sidebar on button click
        if (toggleSidebarBtn) {
            toggleSidebarBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (window.innerWidth >= 768) {
                    // Desktop mode
                    toggleDesktopSidebar();
                } else {
                    // Mobile mode
                    if (sidebar.classList.contains('show')) {
                        closeMobileSidebar();
                    } else {
                        openMobileSidebar();
                    }
                }
            });
        }
        
        // Close sidebar when clicking the close button
        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', closeMobileSidebar);
        }
        
        // Close sidebar when clicking the overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeMobileSidebar);
        }
        
        // Edit Modal Functions
        const editModal = document.getElementById('editModal');
        const deleteModal = document.getElementById('deleteModal');
        let currentCommentId = null;
        
        // Comment data (in a real app, this would come from a database)
        const commentData = {
            '1': {
                username: 'naruto_uzumaki',
                content: 'One Piece',
                comment: 'Anime ini sangat bagus! Saya sangat menyukai alur ceritanya dan karakter-karakternya sangat menarik. Tidak sabar menunggu episode selanjutnya!'
            },
            '2': {
                username: 'sasuke_uchiha',
                content: 'Naruto',
                comment: 'Manga ini terlalu lambat perkembangannya. Sudah 3 chapter dan ceritanya masih di tempat yang sama. Saya harap penulis bisa mempercepat alur ceritanya.'
            },
            '3': {
                username: 'sakura_haruno',
                content: 'Demon Slayer',
                comment: 'Animasi pertarungan di episode ini luar biasa! Studio animasi benar-benar melakukan pekerjaan yang hebat. Saya menonton adegan pertarungan itu berulang kali.'
            },
            '4': {
                username: 'hinata_hyuga',
                content: 'Bleach',
                comment: 'Saya pikir ending manga ini sangat mengecewakan. Setelah bertahun-tahun mengikuti cerita, saya berharap lebih dari ini. Banyak plot hole yang tidak terselesaikan.'
            },
            '5': {
                username: 'shikamaru_nara',
                content: 'Your Name',
                comment: 'Film anime ini adalah salah satu yang terbaik yang pernah saya tonton. Cerita, animasi, musik, semuanya sempurna. Saya sangat merekomendasikannya kepada semua penggemar anime.'
            }
        };
        
        function openEditModal(commentId) {
            currentCommentId = commentId;
            const comment = commentData[commentId];
            
            document.getElementById('edit-username').value = comment.username;
            document.getElementById('edit-content-type').value = comment.content;
            document.getElementById('edit-comment').value = comment.comment;
            document.getElementById('edit-comment-id').value = commentId;
            
            editModal.classList.remove('hidden');
        }
        
        function closeEditModal() {
            editModal.classList.add('hidden');
        }
        
        function saveComment() {
            const commentId = document.getElementById('edit-comment-id').value;
            const newComment = document.getElementById('edit-comment').value;
            
            // In a real app, you would send this to the server
            // For this demo, we'll just update our local data
            commentData[commentId].comment = newComment;
            
            // Update the UI
            const commentElements = document.querySelectorAll('.comment-text');
            commentElements[parseInt(commentId) - 1].textContent = newComment;
            
            closeEditModal();
            
            // Show success notification
            alert('Komentar berhasil diperbarui!');
        }
        
        function confirmDelete(commentId) {
            currentCommentId = commentId;
            deleteModal.classList.remove('hidden');
        }
        
        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }
        
        function deleteComment() {
            // In a real app, you would send this to the server
            // For this demo, we'll just hide the row
            const commentRow = document.querySelector(`tr:nth-child(${currentCommentId})`);
            if (commentRow) {
                commentRow.style.display = 'none';
            }
            
            closeDeleteModal();
            
            // Show success notification
            alert('Komentar berhasil dihapus!');
        }
        
        // Handle window resize for sidebar
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                // Reset mobile sidebar state
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = '';
                
                // Maintain desktop sidebar state
                if (sidebar.classList.contains('collapsed')) {
                    mainWrapper.style.marginLeft = '70px';
                } else {
                    mainWrapper.style.marginLeft = '260px';
                }
            } else {
                // Reset to mobile view
                mainWrapper.style.marginLeft = '0';
            }
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (editModal && !editModal.classList.contains('hidden')) {
                const modalContent = editModal.querySelector('.inline-block');
                if (modalContent && !modalContent.contains(e.target) && e.target !== modalContent) {
                    closeEditModal();
                }
            }
            
            if (deleteModal && !deleteModal.classList.contains('hidden')) {
                const modalContent = deleteModal.querySelector('.inline-block');
                if (modalContent && !modalContent.contains(e.target) && e.target !== modalContent) {
                    closeDeleteModal();
                }
            }
        });
    </script>
    @endpush