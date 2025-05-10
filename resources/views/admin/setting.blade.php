<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyAnimeList - Settings</title>
    <!-- Font yang cocok untuk tema anime -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
        /* Hide delete confirmation by default */
        #deleteConfirmSection {
            display: none;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100">
    <!-- Sidebar Overlay (for mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    @include('components/sidebarAdmin')

    <!-- Main Content Wrapper -->
    <div class="main-wrapper" id="mainWrapper" style="margin-left: 260px;">
        <!-- Top Navbar -->
        @include('components/navbarAdmin')

        <!-- Main Content -->
        <main class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-white mb-2">Pengaturan Akun</h1>
                <p class="text-gray-400">Kelola pengaturan akun dan keamanan Anda</p>
            </div>

            <!-- Password Reset Section -->
            <div class="dashboard-card p-6 mb-8">
                <div class="flex items-center mb-6">
                    <div class="rounded-full bg-purple-900/30 p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-purple-400">Ubah Password</h2>
                        <p class="text-gray-400 text-sm">Perbarui password akun Anda untuk keamanan</p>
                    </div>
                </div>

                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <!-- Current Password -->
                    <div>
                        <label for="current-password" class="block text-sm font-medium text-gray-300 mb-2">
                            Password Saat Ini
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="current-password"
                                name="current_password"
                                class="input-dark w-full rounded-md bg-gray-800/80 border-gray-700 text-gray-100 p-3 focus:border-purple-500 focus:ring focus:ring-purple-500/20"
                                placeholder="Masukkan password saat ini"
                                required
                            />
                            <button
                                type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-300 toggle-password"
                                data-target="current-password"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-off-icon hidden" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new-password" class="block text-sm font-medium text-gray-300 mb-2">
                            Password Baru
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="new-password"
                                name="password"
                                class="input-dark w-full rounded-md bg-gray-800/80 border-gray-700 text-gray-100 p-3 focus:border-purple-500 focus:ring focus:ring-purple-500/20"
                                placeholder="Masukkan password baru"
                                required
                            />
                            <button
                                type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-300 toggle-password"
                                data-target="new-password"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-off-icon hidden" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-400">
                            Password harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, dan angka
                        </p>
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="confirm-password" class="block text-sm font-medium text-gray-300 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="confirm-password"
                                name="password_confirmation"
                                class="input-dark w-full rounded-md bg-gray-800/80 border-gray-700 text-gray-100 p-3 focus:border-purple-500 focus:ring focus:ring-purple-500/20"
                                placeholder="Konfirmasi password baru"
                                required
                            />
                            <button
                                type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-300 toggle-password"
                                data-target="confirm-password"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-off-icon hidden" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-purple-700 hover:bg-purple-600 text-white py-3 px-4 rounded-md btn-glow transition-all flex items-center justify-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Perbarui Password</span>
                    </button>
                </form>
            </div>

            <!-- Delete Account Section -->
            <div class="dashboard-card p-6">
                <div class="flex items-center mb-6">
                    <div class="rounded-full bg-red-900/30 p-3 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-red-400">Hapus Akun</h2>
                        <p class="text-gray-400 text-sm">Hapus akun dan semua data Anda secara permanen</p>
                    </div>
                </div>

                <div class="bg-red-900/10 border border-red-800/30 rounded-md p-4 mb-6">
                    <p class="text-gray-300 text-sm">
                        <strong class="text-red-400">Peringatan:</strong> Menghapus akun Anda akan menghapus semua data,
                        termasuk profil, riwayat, dan koleksi anime/manga Anda. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>

                <!-- Initial Delete Button -->
                <div id="initialDeleteSection">
                    <button
                        type="button"
                        id="showDeleteConfirmBtn"
                        class="w-full bg-gray-800 hover:bg-red-900/50 text-red-400 border border-red-800/50 py-3 px-4 rounded-md transition-all flex items-center justify-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Hapus Akun Saya</span>
                    </button>
                </div>

                <!-- Delete Confirmation Section (Hidden by default) -->
                <div id="deleteConfirmSection" class="space-y-4">
                    <div class="bg-gray-800/80 border border-gray-700 rounded-md p-4">
                        <p class="text-gray-300 text-sm mb-4">
                            Untuk mengkonfirmasi, ketik <strong class="text-white">"HAPUS AKUN"</strong> di bawah
                            ini:
                        </p>
                        <input
                            type="text"
                            id="delete-confirmation-text"
                            class="input-dark w-full rounded-md bg-gray-800/80 border-gray-700 text-gray-100 p-3 focus:border-red-500 focus:ring focus:ring-red-500/20"
                            placeholder="Ketik 'HAPUS AKUN'"
                        />
                    </div>

                    <div class="flex space-x-4">
                        <form action="#" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                id="confirmDeleteBtn"
                                class="w-full bg-red-700 hover:bg-red-600 text-white py-3 px-4 rounded-md transition-all flex items-center justify-center"
                                disabled
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Konfirmasi Penghapusan</span>
                            </button>
                        </form>

                        <button
                            type="button"
                            id="cancelDeleteBtn"
                            class="flex-1 bg-gray-700 hover:bg-gray-600 text-white py-3 px-4 rounded-md transition-all flex items-center justify-center"
                        >
                            <span>Batal</span>
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 border-t border-gray-800 py-4 px-6 mt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; 2023, Dibuat dengan
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-red-500 mx-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
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

    <!-- JavaScript for functionality -->
    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const eyeIcon = this.querySelector('.eye-icon');
                const eyeOffIcon = this.querySelector('.eye-off-icon');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeOffIcon.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeOffIcon.classList.add('hidden');
                }
            });
        });

        // Delete account confirmation
        const showDeleteConfirmBtn = document.getElementById('showDeleteConfirmBtn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const initialDeleteSection = document.getElementById('initialDeleteSection');
        const deleteConfirmSection = document.getElementById('deleteConfirmSection');
        const deleteConfirmationText = document.getElementById('delete-confirmation-text');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // Show delete confirmation
        showDeleteConfirmBtn.addEventListener('click', function() {
            initialDeleteSection.style.display = 'none';
            deleteConfirmSection.style.display = 'block';
        });

        // Cancel delete
        cancelDeleteBtn.addEventListener('click', function() {
            initialDeleteSection.style.display = 'block';
            deleteConfirmSection.style.display = 'none';
            deleteConfirmationText.value = '';
            confirmDeleteBtn.disabled = true;
        });

        // Enable/disable confirm button based on text input
        deleteConfirmationText.addEventListener('input', function() {
            if (this.value === 'HAPUS AKUN') {
                confirmDeleteBtn.disabled = false;
            } else {
                confirmDeleteBtn.disabled = true;
            }
        });
    </script>
</body>
</html>