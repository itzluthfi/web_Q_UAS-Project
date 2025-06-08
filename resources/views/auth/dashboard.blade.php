@extends('layouts.dashboard')

@section('title', 'Dashboard - AnimeVerse')
@section('page-header', 'Dashboard - AnimeVerse') {{-- Ini akan masuk ke navbar --}}
@push('styles')
    <style>
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
    @include('components.dashboardContent')
@endsection
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
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                            Edit Pengguna
                        </h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="edit-username"
                                    class="block text-sm font-medium text-gray-300">Username</label>
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
                <button type="button"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm btn-glow">
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
