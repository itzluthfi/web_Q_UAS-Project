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
            margin-left: 
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card Pengguna -->
        <div class="bg-gray-800 rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="rounded-full bg-purple-900/30 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Pengguna</p>
                    <h2 class="text-2xl font-bold text-white">1,257</h2>
                    <p class="text-green-500 text-xs mt-1">
                        <span>↑ 5.3%</span> dari bulan lalu
                    </p>
                </div>
            </div>
        </div>

        <!-- Card Anime -->
        <div class="bg-gray-800 rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="rounded-full bg-pink-900/30 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6H6a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V8a2 2 0 00-2-2h-6z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Total Anime</p>
                    <h2 class="text-2xl font-bold text-white">892</h2>
                    <p class="text-green-500 text-xs mt-1">
                        <span>↑ 8.8%</span> dari bulan lalu
                    </p>
                </div>
            </div>
        </div>

        <!-- Card Manga -->
        <div class="bg-gray-800 rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="rounded-full bg-blue-900/30 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2-8H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Total Manga</p>
                    <h2 class="text-2xl font-bold text-white">532</h2>
                    <p class="text-red-500 text-xs mt-1">
                        <span>↓ 3.1%</span> dari bulan lalu
                    </p>
                </div>
            </div>
        </div>

        <!-- Card Aktif -->
        <div class="bg-gray-800 rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="rounded-full bg-green-900/30 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v1a2 2 0 01-2 2H4a2 2 0 01-2-2v-1h5m10 0V6a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Pengguna Aktif</p>
                    <h2 class="text-2xl font-bold text-white">5</h2>
                    <p class="text-green-500 text-xs mt-1">
                        <span>↑ 12.5%</span> dari bulan lalu
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Chart -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-white mb-4">Statistik Pengguna</h2>
        <div class="bg-gray-800 rounded-lg p-4 shadow-md">
            <!-- Dummy Chart Area -->
            <div class="h-40 bg-gray-700 rounded flex items-center justify-center text-gray-500">
                Grafik Pengguna Aktif (Contoh)
            </div>
        </div>
    </div>

    <!-- Tabel Pengguna -->
    <div class="bg-gray-800 rounded-lg p-6 shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-white">Daftar Pengguna</h2>
            <a href="#" class="text-sm text-purple-400 hover:text-purple-300 flex items-center">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <table class="w-full table-auto text-left">
            <thead>
                <tr class="text-gray-400 border-b border-gray-700">
                    <th class="py-3 px-4">Nama</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Terakhir Login</th>
                    <th class="py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-700 hover:bg-gray-700/30">
                    <td class="py-3 px-4">naruto_uzumaki</td>
                    <td class="py-3 px-4">naruto@example.com</td>
                    <td class="py-3 px-4">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    </td>
                    <td class="py-3 px-4 text-gray-300">2023-03-20</td>
                    <td class="py-3 px-4">
                        <button class="text-purple-400 hover:text-purple-300 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-4 4a2 2 0 01-2.828 0l-4-4a2 2 0 112.828-2.828L10 5.586l3.586-3.586z" />
                                <path d="M18 12h-2.586l-4 4a2 2 0 01-2.828 0l-4-4H2a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2v4a2 2 0 01-2 2z" />
                            </svg>
                        </button>
                        <button class="text-red-400 hover:text-red-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2h12a1 1 0 000-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM4 13a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6z"
                                    clip-rule="evenodd" />
                                <path d="M9.707 9.293a1 1 0 00-1.414 0L7 10.586 6.707 10.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 000-1.414z" />
                            </svg>
                        </button>
                    </td>
                </tr>
                <tr class="border-b border-gray-700 hover:bg-gray-700/30">
                    <td class="py-3 px-4">sakura_haruno</td>
                    <td class="py-3 px-4">sakura@example.com</td>
                    <td class="py-3 px-4">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Offline</span>
                    </td>
                    <td class="py-3 px-4 text-gray-300">2023-03-18</td>
                    <td class="py-3 px-4">
                        <button class="text-purple-400 hover:text-purple-300 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-4 4a2 2 0 01-2.828 0l-4-4a2 2 0 012.828-2.828L10 5.586l3.586-3.586z" />
                                <path d="M18 9a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V11a2 2 0 012-2h12z" />
                            </svg>
                        </button>
                        <button class="text-red-400 hover:text-red-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2h12a1 1 0 000-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM4 13a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6z"
                                    clip-rule="evenodd" />
                                <path d="M9.707 9.293a1 1 0 00-1.414 0L7 10.586 6.707 10.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 000-1.414z" />
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal Edit Pengguna -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeEditModal()"></div>
            <div class="bg-gray-800 rounded-lg max-w-lg w-full shadow-xl z-10">
                <div class="p-5 border-b border-gray-700">
                    <h3 class="text-lg font-medium text-white">Edit Pengguna</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Username</label>
                        <input type="text" id="edit-username"
                            class="mt-1 w-full bg-gray-700 text-white rounded-md p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" id="edit-email"
                            class="mt-1 w-full bg-gray-700 text-white rounded-md p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300">Role</label>
                        <select id="edit-role"
                            class="mt-1 w-full bg-gray-700 text-white rounded-md p-2">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button onclick="closeEditModal()"
                            class="px-4 py-2 bg-gray-700 text-gray-300 rounded hover:bg-gray-600">
                            Batal
                        </button>
                        <button onclick="saveChanges()"
                            class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-600 btn-glow">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openEditModal(id) {
                document.getElementById('editModal').classList.remove('hidden');
            }

            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
            }

            // Toggle sidebar
            const sidebar = document.getElementById('sidebar');
            const mainWrapper = document.getElementById('mainWrapper');
            const toggleButton = document.getElementById('toggleSidebar');

            if (toggleButton) {
                toggleButton.addEventListener('click', () => {
                    sidebar.classList.toggle('collapsed');
                    mainWrapper.classList.toggle('sidebar-collapsed');
                });
            }
        </script>
    @endpush

@endsection