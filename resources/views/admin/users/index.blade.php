@extends('layouts.dashboard')
@section('title', 'Users - MyAnimeList Admin')

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

        /* * Collapsed sidebar styles */


        /* Main content area */
        .main-wrapper {
            transition: margin-left 0.3s ease;
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
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0 !important;
            }
        }

        /* Responsive Table */
        .admin-table {
            min-width: 700px;
        }

        @media (max-width: 640px) {
            .admin-table {
                min-width: 600px;
                font-size: 0.85rem;
            }

            .admin-table th,
            .admin-table td {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
        }

        /* Responsive Modal */
        .modal {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .modal.hidden {
            opacity: 0;
            transform: scale(0.95);
            pointer-events: none;
        }

        @media (max-width: 640px) {
            .modal .sm\:max-w-lg {
                max-width: 98vw !important;
                width: 98vw !important;
                margin: 0 !important;
                border-radius: 0.75rem !important;
            }

            .modal .sm\:p-6 {
                padding: 1rem !important;
            }
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
@endpush


@section('content')
    <main class="p-4 sm:p-6 animate-fade-in">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-purple-400">Manajemen Pengguna</h2>
                <p class="text-gray-400 mt-1">Kelola semua pengguna yang terdaftar di MyAnimeList</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button onclick="openAddUserModal()" class="bg-purple-700 hover:bg-purple-600 text-white px-4 py-2 rounded-md flex items-center btn-glow transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Pengguna
                </button>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="bg-gray-800 rounded-lg p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="relative flex-grow">
                    <input type="text" placeholder="Cari berdasarkan username, email, atau ID..." class="input-dark w-full pl-10 pr-4 py-2 rounded-lg text-sm focus:outline-none">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <select class="input-dark rounded-lg px-4 py-2 text-sm focus:outline-none">
                        <option value="">Semua Peran</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    {{-- <select class="input-dark rounded-lg px-4 py-2 text-sm focus:outline-none">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                            <option value="banned">Diblokir</option>
                        </select> --}}
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
                                    <input type="checkbox" class="form-checkbox h-4 w-4 text-purple-600 transition duration-150 ease-in-out">
                                    <span class="ml-2">ID</span>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Username
                            </th>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Peran
                            </th>

                            <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Tanggal
                                Daftar</th>
                            {{-- <th class="px-6 py-3 text-left text-xs text-gray-300 uppercase tracking-wider">Login
                                    Terakhir</th> --}}
                            <th class="px-6 py-3 text-right text-xs text-gray-300 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <?php
                          
                            foreach ($users as $user):
                            ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <input type="checkbox" class="form-checkbox h-4 w-4 text-purple-600 transition duration-150 ease-in-out">
                                    <span class="ml-2 text-sm text-gray-300"><?= $user['id'] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                        <span class="font-bold text-white"><?= strtoupper(substr($user['username'], 0, 1)) ?></span>
                                    </div>
                                    <div class="text-sm font-medium text-white"><?= $user['username'] ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?= $user['email'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="badge <?= $user['role'] === 'admin' ? 'badge-admin' : ($user['role'] === 'moderator' ? 'badge-moderator' : 'badge-user') ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?= $user['created_at'] ?>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <button onclick="openViewModal(<?= $user['id'] ?>)" class="action-button text-blue-400 hover:text-blue-300 transition-colors tooltip">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="tooltip-text">Lihat Detail</span>
                                    </button>
                                    <button onclick="openEditModal({{ $user['id'] }})" class="action-button text-indigo-400 hover:text-indigo-300 transition-colors tooltip">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        <span class="tooltip-text">Edit</span>
                                    </button>
                                    <button onclick="confirmDelete(<?= $user['id'] ?>, '<?= $user['username'] ?>')" class="action-button text-red-400 hover:text-red-300 transition-colors tooltip">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
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
                        <button class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm transition-all">
                            Terapkan
                        </button>
                    </div>
                    {{ $users->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>



        </div>

        <!-- View User Modal -->
        <div id="viewModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
                </div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white" id="view-modal-title">
                                    Detail Pengguna
                                </h3>
                                <div class="mt-4">
                                    <div class="bg-gray-700 rounded-lg p-4 mb-4">
                                        <div class="flex flex-col items-center sm:flex-row sm:items-start">
                                            <div class="h-20 w-20 rounded-full bg-purple-600 flex items-center justify-center mb-4 sm:mb-0 sm:mr-4">
                                                <span class="font-bold text-white text-2xl" id="view-user-initial">N</span>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-medium text-white" id="view-username">
                                                    <?= $user['username'] ?></h4>
                                                </h4>
                                                <p class="text-gray-300" id="view-email">naruto@konoha.com</p>
                                                <div class="mt-2 flex items-center">
                                                    <span class="badge badge-user mr-2" id="view-role">User</span>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" id="view-status">
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
                        <button type="button" onclick="openEditModal({{ $user['id'] }})"
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
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
                </div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('user.add') }}" method="POST" class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        @csrf

                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                    Tambah Pengguna Baru
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                                        <input type="text" name="username" id="username" required 
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2">
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                                        <input type="email" name="email" id="email" required 
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2">
                                    </div>
                                    
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                                        <input type="password" name="password" id="password" required 
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2">
                                    </div>
                                    
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" required 
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2">
                                    </div>
                                    
                                    <div>
                                        <label for="role" class="block text-sm font-medium text-gray-300">Peran</label>
                                        <select name="role" id="role" required 
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2">
                                            <option value="user">User</option>
                                            <option value="moderator">Moderator</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
                                        <select name="status" id="status" required 
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2">
                                            <option value="active">Aktif</option>
                                            <option value="inactive">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-800 px-4 py-3 sm:px-6 flex justify-end space-x-3">
                            <button type="submit"
                                class="inline-flex justify-center rounded-md shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:w-auto sm:text-sm btn-glow transition duration-150 ease-in-out">
                                Tambah Pengguna
                            </button>
                            <button type="button"
                                onclick="closeAddUserModal()"
                                class="inline-flex justify-center rounded-md shadow-sm px-4 py-2 bg-gray-900 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <!-- Edit User Modal -->
        <div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <form id="editUserForm" action="" method="POST" class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                @csrf
                @method('PUT')

                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
                </div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white" id="edit-modal-title">
                                    Edit Pengguna
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="edit-username" class="block text-sm font-medium text-gray-300">Username</label>
                                        <input type="text" name="username" id="edit-username"
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2">
                                    </div>
                                    <div>
                                        <label for="edit-email" class="block text-sm font-medium text-gray-300">Email</label>
                                        <input type="email" name="email" id="edit-email"
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2">
                                    </div>
                                    <div>
                                        <label for="edit-password" class="block text-sm font-medium text-gray-300">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                                        <input type="password" name="password" id="edit-password"
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2">
                                    </div>
                                    <div>
                                        <label for="edit-role" class="block text-sm font-medium text-gray-300">Peran</label>
                                        <select name="role" id="edit-role"
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2 appearance-none bg-gray-700 text-white">
                                            <option value="user">User</option>
                                            <option value="moderator">Moderator</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="edit-status" class="block text-sm font-medium text-gray-300">Status</label>
                                        <select name="status" id="edit-status"
                                            class="mt-1 input-dark w-full rounded-md px-4 py-2 appearance-none bg-gray-700 text-white">
                                            <option value="active">Aktif</option>
                                            <option value="inactive">Tidak Aktif</option>
                                            <option value="banned">Diblokir</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeEditModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
            <form id="deleteUserForm" action="" method="POST" class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                @csrf
                @method('DELETE')

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
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Hapus
                        </button>
                        <button type="button" onclick="closeDeleteModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <!-- JavaScript for Modal and Sidebar Functionality -->
    <script>
    //    te based on window size
    // Wrap semua JavaScript dalam DOMContentLoaded
// Pindahkan semua fungsi modal keluar dari DOMContentLoaded agar bisa diakses secara global

// Data pengguna dari PHP (pastikan ini ter-generate dengan benar)
const users = [
    <?php foreach ($users as $user): ?>
    {
        id: <?= $user['id'] ?>,
        username: '<?= addslashes($user['username']) ?>',
        email: '<?= addslashes($user['email']) ?>',
        role: '<?= $user['role'] ?>',
        status: '<?= $user['status'] ?>',
        created_at: '<?= $user['created_at'] ?? '-' ?>',
        last_login: '<?= $user['last_login'] ?? '-' ?>',
        favorite_anime: <?= $user['favorite_anime'] ?? 0 ?>,
        favorite_manga: <?= $user['favorite_manga'] ?? 0 ?>,
        comments: <?= $user['comments'] ?? 0 ?>
    },
    <?php endforeach; ?>
];

// Helper function
function ucfirst(str) {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// MODAL FUNCTIONS - GLOBAL SCOPE
// View Modal Functions
function openViewModal(userId) {
    const user = users.find(u => u.id === userId);
    const viewModal = document.getElementById('viewModal');

    if (!user) {
        console.error("Pengguna tidak ditemukan!");
        return;
    }

    // Isi data pengguna ke dalam modal
    document.getElementById('view-username').textContent = user.username;
    document.getElementById('view-email').textContent = user.email;
    document.getElementById('view-id').textContent = user.id;
    document.getElementById('view-created-at').textContent = user.created_at || '-';
    document.getElementById('view-last-login').textContent = user.last_login || '-';
    document.getElementById('view-favorite-anime').textContent = user.favorite_anime;
    document.getElementById('view-favorite-manga').textContent = user.favorite_manga;
    document.getElementById('view-comments').textContent = user.comments;
    document.getElementById('view-user-initial').textContent = user.username.charAt(0).toUpperCase();

    // Role badge
    const roleBadge = document.getElementById('view-role');
    roleBadge.textContent = ucfirst(user.role);
    roleBadge.className = 'badge';
    if (user.role === 'admin') {
        roleBadge.classList.add('badge-admin');
    } else if (user.role === 'moderator') {
        roleBadge.classList.add('badge-moderator');
    } else {
        roleBadge.classList.add('badge-user');
    }

    // Status badge
    const statusBadge = document.getElementById('view-status');
    if (user.status === 'active') {
        statusBadge.textContent = 'Aktif';
        statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
    } else if (user.status === 'inactive') {
        statusBadge.textContent = 'Tidak Aktif';
        statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800';
    } else if (user.status === 'banned') {
        statusBadge.textContent = 'Diblokir';
        statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
    }

    viewModal.classList.remove('hidden');
}

function closeViewModal() {
    const viewModal = document.getElementById('viewModal');
    viewModal.classList.add('hidden');
}

// Add User Modal Functions
function openAddUserModal() {
    const addUserModal = document.getElementById('addUserModal');
    addUserModal.classList.remove('hidden');
}

function closeAddUserModal() {
    const addUserModal = document.getElementById('addUserModal');
    addUserModal.classList.add('hidden');
}

// Edit Modal Functions - VERSI DIPERBAIKI
function openEditModal(userId) {
    console.log('🔍 Debug: Opening modal for user ID:', userId, 'Type:', typeof userId);
    
    // 1. CEK APAKAH ARRAY USERS ADA
    if (typeof users === 'undefined' || !users) {
        console.error('❌ Array users tidak ditemukan!');
        alert('Data pengguna tidak tersedia!');
        return;
    }
    
    console.log('✅ Users array found, length:', users.length);
    
    // 2. CARI USER
    const user = users.find(u => u.id == userId);
    console.log('🔍 User search result:', user);
    
    if (!user) {
        console.error('❌ Pengguna tidak ditemukan!');
        return;
    }

    // 3. SET FORM ACTION URL - PERBAIKAN UTAMA
    const form = document.getElementById('editUserForm');
    if (!form) {
        console.error('❌ Form element tidak ditemukan!');
        return;
    }
    
    // Gunakan URL sederhana tanpa Blade template
    const actionUrl = `/user/${userId}`;
    form.setAttribute('action', actionUrl);
    console.log('✅ Form action set to:', actionUrl);
    
    // 4. CEK MODAL ELEMENT
    const editModal = document.getElementById('editModal');
    if (!editModal) {
        console.error('❌ Modal element tidak ditemukan!');
        return;
    }
    
    console.log('✅ Modal element found');
    
    // 5. ISI FORM FIELDS
    try {
        const usernameField = document.getElementById('edit-username');
        const emailField = document.getElementById('edit-email');
        const roleField = document.getElementById('edit-role');
        const statusField = document.getElementById('edit-status');
        const passwordField = document.getElementById('edit-password');
        
        // Cek apakah semua field ada
        if (!usernameField || !emailField || !roleField || !statusField) {
            console.error('❌ Beberapa form field tidak ditemukan!');
            return;
        }
        
        // Isi data
        usernameField.value = user.username || '';
        emailField.value = user.email || '';
        roleField.value = user.role || 'user';
        statusField.value = user.status || 'active';
        
        if (passwordField) {
            passwordField.value = '';
        }
        
        console.log('✅ Form fields populated successfully');
        console.log('📋 Data yang diisi:', {
            username: user.username,
            email: user.email,
            role: user.role,
            status: user.status
        });
        
    } catch (error) {
        console.error('❌ Error saat mengisi form:', error);
        return;
    }
    
    // 6. TAMPILKAN MODAL - DENGAN DELAY UNTUK MENCEGAH AUTO CLOSE
    console.log('🔄 Attempting to show modal...');
    
    setTimeout(() => {
        editModal.classList.remove('hidden');
        console.log('✅ Modal displayed with delay');
    }, 50);
}

function closeEditModal() {
    console.log('🔄 Closing edit modal...');
    
    const editModal = document.getElementById('editModal');
    if (!editModal) {
        console.error('❌ Modal element tidak ditemukan saat menutup!');
        return;
    }
    
    editModal.classList.add('hidden');
    
    // Reset form
    const form = document.getElementById('editUserForm');
    if (form) {
        form.reset();
    }
    
    console.log('✅ Modal closed successfully');
}

// HAPUS ATAU MODIFIKASI EVENT LISTENER YANG BERMASALAH
document.addEventListener('DOMContentLoaded', function() {
    // HAPUS semua event listener click yang ada sebelumnya
    const editModal = document.getElementById('editModal');
    if (editModal) {
        // Clone node untuk menghapus semua event listener
        const newModal = editModal.cloneNode(true);
        editModal.parentNode.replaceChild(newModal, editModal);
        
        // console.log('🔄 Modal event listeners reset');
    }
});

// EVENT LISTENER YANG AMAN - hanya tutup jika klik di background
document.addEventListener('click', function(event) {
    const editModal = document.getElementById('editModal');
    
    // Pastikan modal ada dan sedang terbuka
    if (!editModal || editModal.classList.contains('hidden')) {
        return;
    }
    
    // Hanya tutup jika klik tepat di background modal (bukan di content)
    if (event.target === editModal) {
        // console.log('🔄 Closing modal via background click');
        closeEditModal();
    }
});

// EVENT LISTENER ESCAPE KEY
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const editModal = document.getElementById('editModal');
        if (editModal && !editModal.classList.contains('hidden')) {
            // console.log('🔄 Closing modal via Escape key');
            closeEditModal();
        }
    }
});

// FUNGSI ALTERNATIF - JIKA MASALAH MASIH ADA
function forceOpenEditModal(userId) {
    // console.log('🚀 FORCE Opening modal for user ID:', userId);
    
    const user = users.find(u => u.id == userId);
    if (!user) {
        alert('User tidak ditemukan!');
        return;
    }
    
    const editModal = document.getElementById('editModal');
    if (!editModal) {
        alert('Modal tidak ditemukan!');
        return;
    }
    
    // Isi form
    document.getElementById('edit-username').value = user.username || '';
    document.getElementById('edit-email').value = user.email || '';
    document.getElementById('edit-role').value = user.role || 'user';
    document.getElementById('edit-status').value = user.status || 'active';
    
    const passwordField = document.getElementById('edit-password');
    if (passwordField) {
        passwordField.value = '';
    }
    
    // Paksa tampilkan modal dengan berbagai cara
    editModal.classList.remove('hidden');
    editModal.style.display = 'block';
    editModal.style.visibility = 'visible';
    editModal.style.opacity = '1';
    
    // console.log('🚀 Modal forced open');
    
    // Cek setelah 1 detik
    setTimeout(() => {
        const isStillHidden = editModal.classList.contains('hidden');
        // console.log('🔍 Modal masih hidden setelah force:', isStillHidden);
        
        if (isStillHidden) {
            // console.log('🔧 Trying alternative approach...');
            editModal.classList.remove('hidden');
            editModal.removeAttribute('style');
        }
    }, 1000);
}

        // Delete Modal Functions
        let userIdToDelete = null;

        function confirmDelete(userId, username) {
            userIdToDelete = userId;
            const deleteModal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteUserForm');
            const url = "{{ route('user.delete', ':id') }}".replace(':id', userId);

            // Isi teks konfirmasi
            document.getElementById('delete-confirmation-text').textContent =
                `Apakah Anda yakin ingin menghapus pengguna "${username}"? Tindakan ini tidak dapat dibatalkan.`;

            // Set action form
            form.setAttribute('action', url);

            // Tampilkan modal
            deleteModal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.classList.add('hidden');
            userIdToDelete = null;
        }



    </script>

@endpush
