@extends('layouts.dashboardAdmin')

@section('title', 'Dashboard - MyAnimeList Admin')
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
        .badge-admin {
            background-color: rgba(139, 92, 246, 0.2);
            color: #a78bfa;
        }
        .badge-user {
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
        /* Improved animation for cards */
        .anime-card-image {
            background-size: cover;
            background-position: center;
            transition: transform 0.3s ease;
        }
        .anime-card:hover .anime-card-image {
            transform: scale(1.05);
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="dashboard-card p-4 flex items-center">
                    <div class="rounded-full bg-purple-900/30 p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Kunjungan</p>
                        <h3 class="text-2xl font-bold text-white">12,721</h3>
                        <p class="text-green-500 text-xs flex items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            12.5% dari bulan lalu
                        </p>
                    </div>
                </div>
                
                <div class="dashboard-card p-4 flex items-center">
                    <div class="rounded-full bg-blue-900/30 p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Pengguna</p>
                        <h3 class="text-2xl font-bold text-white">3,428</h3>
                        <p class="text-green-500 text-xs flex items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            8.2% dari bulan lalu
                        </p>
                    </div>
                </div>
                
                <div class="dashboard-card p-4 flex items-center">
                    <div class="rounded-full bg-pink-900/30 p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Anime</p>
                        <h3 class="text-2xl font-bold text-white">1,257</h3>
                        <p class="text-green-500 text-xs flex items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            5.3% dari bulan lalu
                        </p>
                    </div>
                </div>
                
                <div class="dashboard-card p-4 flex items-center">
                    <div class="rounded-full bg-green-900/30 p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Manga</p>
                        <h3 class="text-2xl font-bold text-white">892</h3>
                        <p class="text-green-500 text-xs flex items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            3.7% dari bulan lalu
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Jadwal Kuis Card -->
                <div class="dashboard-card p-6">
                    <h2 class="text-xl font-semibold text-purple-400 mb-2">Jadwal Anime Terbaru</h2>
                    <p class="text-gray-400 mb-4">3 anime akan tayang hari ini</p>
                    
                    <div class="space-y-3">
                        <div class="bg-gray-800 rounded-lg p-3 flex items-center">
                            <div class="h-10 w-10 bg-purple-900/30 rounded-md flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">One Piece</h4>
                                <p class="text-gray-400 text-sm">Episode 1081 - 18:30 WIB</p>
                            </div>
                            <span class="px-2 py-1 bg-purple-900/30 text-purple-400 text-xs rounded-full">TV</span>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-3 flex items-center">
                            <div class="h-10 w-10 bg-purple-900/30 rounded-md flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">Jujutsu Kaisen</h4>
                                <p class="text-gray-400 text-sm">Episode 15 - 20:00 WIB</p>
                            </div>
                            <span class="px-2 py-1 bg-purple-900/30 text-purple-400 text-xs rounded-full">TV</span>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-3 flex items-center">
                            <div class="h-10 w-10 bg-purple-900/30 rounded-md flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">Demon Slayer</h4>
                                <p class="text-gray-400 text-sm">Episode 8 - 22:30 WIB</p>
                            </div>
                            <span class="px-2 py-1 bg-purple-900/30 text-purple-400 text-xs rounded-full">TV</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="#" class="block w-full bg-purple-700 hover:bg-purple-600 text-white text-center py-2 px-4 rounded-md btn-glow transition-all">
                            <div class="flex items-center justify-center">
                                <span>Cek Jadwal Anime</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
                
                <!-- Pengguna Aktif Card -->
                <div class="dashboard-card p-6">
                    <h2 class="text-xl font-semibold text-purple-400 mb-2">Pengguna Aktif</h2>
                    <p class="text-gray-400 mb-4">5 pengguna aktif saat ini</p>
                    
                    <div class="space-y-3">
                        <div class="bg-gray-800 rounded-lg p-3 flex items-center">
                            <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                <span class="font-bold text-white">N</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">naruto_uzumaki</h4>
                                <p class="text-gray-400 text-sm">Aktif 5 menit yang lalu</p>
                            </div>
                            <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Online</span>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-3 flex items-center">
                            <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                <span class="font-bold text-white">S</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">sasuke_uchiha</h4>
                                <p class="text-gray-400 text-sm">Aktif 12 menit yang lalu</p>
                            </div>
                            <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Online</span>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-3 flex items-center">
                            <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                <span class="font-bold text-white">S</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">sakura_haruno</h4>
                                <p class="text-gray-400 text-sm">Aktif 18 menit yang lalu</p>
                            </div>
                            <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Online</span>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-3 flex items-center">
                            <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                <span class="font-bold text-white">H</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">hinata_hyuga</h4>
                                <p class="text-gray-400 text-sm">Aktif 25 menit yang lalu</p>
                            </div>
                            <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Online</span>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-3 flex items-center">
                            <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                <span class="font-bold text-white">S</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">shikamaru_nara</h4>
                                <p class="text-gray-400 text-sm">Aktif 30 menit yang lalu</p>
                            </div>
                            <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Online</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="#" class="block w-full bg-gray-700 hover:bg-gray-600 text-white text-center py-2 px-4 rounded-md transition-all">
                            <div class="flex items-center justify-center">
                                <span>Lihat Semua Pengguna</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Users Section -->
            <div class="dashboard-card p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-purple-400">Pengguna Terbaru</h2>
                    <a href="#" class="text-sm text-purple-400 hover:text-purple-300 flex items-center">
                        <span>Lihat Semua</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="admin-table w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Peran</th>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-3 text-right text-xs text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <!-- User Row 1 -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                            <span class="font-bold text-white">N</span>
                                        </div>
                                        <div class="text-sm font-medium text-white">naruto_uzumaki</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">naruto@konoha.com</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge badge-user">User</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2023-02-20</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="openEditModal('1')" class="text-purple-400 hover:text-purple-300 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <button class="text-red-400 hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- User Row 2 -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                            <span class="font-bold text-white">S</span>
                                        </div>
                                        <div class="text-sm font-medium text-white">sasuke_uchiha</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">sasuke@konoha.com</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge badge-user">User</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2023-02-21</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="openEditModal('2')" class="text-purple-400 hover:text-purple-300 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <button class="text-red-400 hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- User Row 3 -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                            <span class="font-bold text-white">S</span>
                                        </div>
                                        <div class="text-sm font-medium text-white">sakura_haruno</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">sakura@konoha.com</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge badge-user">User</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Tidak Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2023-03-05</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="openEditModal('3')" class="text-purple-400 hover:text-purple-300 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <button class="text-red-400 hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- User Row 4 -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                            <span class="font-bold text-white">H</span>
                                        </div>
                                        <div class="text-sm font-medium text-white">hinata_hyuga</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">hinata@konoha.com</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge badge-user">User</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2023-03-15</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="openEditModal('4')" class="text-purple-400 hover:text-purple-300 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <button class="text-red-400 hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- User Row 5 -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                            <span class="font-bold text-white">S</span>
                                        </div>
                                        <div class="text-sm font-medium text-white">shikamaru_nara</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">shikamaru@konoha.com</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge badge-user">User</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">2023-03-20</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="openEditModal('5')" class="text-purple-400 hover:text-purple-300 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <button class="text-red-400 hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Recent Anime Section -->
            <div class="dashboard-card p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-purple-400">Anime Terbaru</h2>
                    <a href="#" class="text-sm text-purple-400 hover:text-purple-300 flex items-center">
                        <span>Lihat Semua</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Anime Card 1 -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all anime-card">
                        <div class="h-40 bg-gray-700 relative overflow-hidden">
                            <div class="anime-card-image absolute inset-0 bg-purple-900/20"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
                            <div class="absolute bottom-2 left-2">
                                <span class="px-2 py-1 bg-purple-700 text-xs text-white rounded">TV</span>
                                <span class="px-2 py-1 bg-gray-800 text-xs text-white rounded ml-1">2023</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-white font-medium mb-1 truncate">One Piece</h3>
                            <p class="text-gray-400 text-sm mb-2">Episode 1080</p>
                            <div class="flex items-center text-yellow-400 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span>9.2</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Anime Card 2 -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all anime-card">
                        <div class="h-40 bg-gray-700 relative overflow-hidden">
                            <div class="anime-card-image absolute inset-0 bg-purple-900/20"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
                            <div class="absolute bottom-2 left-2">
                                <span class="px-2 py-1 bg-purple-700 text-xs text-white rounded">TV</span>
                                <span class="px-2 py-1 bg-gray-800 text-xs text-white rounded ml-1">2023</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-white font-medium mb-1 truncate">Jujutsu Kaisen</h3>
                            <p class="text-gray-400 text-sm mb-2">Season 2</p>
                            <div class="flex items-center text-yellow-400 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span>9.0</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Anime Card 3 -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all anime-card">
                        <div class="h-40 bg-gray-700 relative overflow-hidden">
                            <div class="anime-card-image absolute inset-0 bg-purple-900/20"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
                            <div class="absolute bottom-2 left-2">
                                <span class="px-2 py-1 bg-purple-700 text-xs text-white rounded">TV</span>
                                <span class="px-2 py-1 bg-gray-800 text-xs text-white rounded ml-1">2023</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-white font-medium mb-1 truncate">Demon Slayer</h3>
                            <p class="text-gray-400 text-sm mb-2">Season 3</p>
                            <div class="flex items-center text-yellow-400 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span>8.8</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Anime Card 4 -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all anime-card">
                        <div class="h-40 bg-gray-700 relative overflow-hidden">
                            <div class="anime-card-image absolute inset-0 bg-purple-900/20"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
                            <div class="absolute bottom-2 left-2">
                                <span class="px-2 py-1 bg-purple-700 text-xs text-white rounded">Movie</span>
                                <span class="px-2 py-1 bg-gray-800 text-xs text-white rounded ml-1">2023</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-white font-medium mb-1 truncate">Suzume no Tojimari</h3>
                            <p class="text-gray-400 text-sm mb-2">Movie</p>
                            <div class="flex items-center text-yellow-400 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span>8.5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @endsection
        
       
    </div>

    <!-- Edit User Modal -->
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
                                Edit Pengguna
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="edit-username" class="block text-sm font-medium text-gray-300">Username</label>
                                    <input type="text" id="edit-username" class="mt-1 input-dark w-full rounded-md">
                                </div>
                                <div>
                                    <label for="edit-email" class="block text-sm font-medium text-gray-300">Email</label>
                                    <input type="email" id="edit-email" class="mt-1 input-dark w-full rounded-md">
                                </div>
                                <div>
                                    <label for="edit-role" class="block text-sm font-medium text-gray-300">Peran</label>
                                    <select id="edit-role" class="mt-1 input-dark w-full rounded-md">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="edit-status" class="block text-sm font-medium text-gray-300">Status</label>
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
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm btn-glow">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
        });
        
        // Initialize anime card images with random gradients
        document.addEventListener('DOMContentLoaded', function() {
            const animeCardImages = document.querySelectorAll('.anime-card-image');
            const colors = ['purple', 'blue', 'indigo', 'pink'];
            
            animeCardImages.forEach((image, index) => {
                const color = colors[index % colors.length];
                image.style.backgroundImage = `linear-gradient(45deg, var(--tw-gradient-stops))`;
                image.classList.add(`from-${color}-900/30`, `to-${color}-600/10`);
            });
        });
    </script>
    @endpush
