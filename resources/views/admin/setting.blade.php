
@extends('layouts.dashboard')

@section('title', 'Setting - MyAnimeList Admin')
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

         .settings-card {
            background-color: #1f2937;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        .settings-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .danger-zone {
            border: 1px dashed #ef4444;
            background-color: rgba(239, 68, 68, 0.05);
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
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white mb-2">Account Settings</h1>
            <p class="text-gray-400">Manage your account settings and preferences</p>
        </div>

        <!-- Settings Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="settings-card p-4">
                    <h2 class="text-lg font-semibold text-purple-400 mb-4">Settings</h2>
                    <nav class="space-y-1">
                        <a href="#password" class="flex items-center px-3 py-2 text-white bg-gray-700 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Change Password
                        </a>
                        <a href="#profile" class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile Information
                        </a>
                        <a href="#notifications" class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            Notifications
                        </a>
                        <a href="#appearance" class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                            Appearance
                        </a>
                        <a href="#account" class="flex items-center px-3 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Account
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Change Password Section -->
                <div id="password" class="settings-card p-6">
                    <h2 class="text-xl font-semibold text-purple-400 mb-4">Change Password</h2>
                    <p class="text-gray-400 mb-6">Update your password to keep your account secure</p>
                    
                    <form action="#" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-300 mb-1">Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="input-dark w-full rounded-md px-4 py-2" required>
                            </div>
                            
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-300 mb-1">New Password</label>
                                <input type="password" id="new_password" name="new_password" class="input-dark w-full rounded-md px-4 py-2" required>
                                <p class="text-xs text-gray-400 mt-1">Password must be at least 8 characters and include a mix of letters, numbers, and symbols</p>
                            </div>
                            
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="input-dark w-full rounded-md px-4 py-2" required>
                            </div>
                            
                            <div class="pt-2">
                                <button type="submit" class="bg-purple-700 hover:bg-purple-600 text-white py-2 px-4 rounded-md btn-glow transition-all">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Delete Account Section -->
                <div id="account" class="settings-card p-6 danger-zone">
                    <h2 class="text-xl font-semibold text-red-400 mb-4">Delete Account</h2>
                    <p class="text-gray-400 mb-6">Permanently delete your account and all of your data. This action cannot be undone.</p>
                    
                    <div class="bg-gray-800 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-400">Warning</h3>
                                <div class="mt-2 text-sm text-gray-300">
                                    <p>Deleting your account will:</p>
                                    <ul class="list-disc pl-5 mt-1 space-y-1">
                                        <li>Remove all your personal information</li>
                                        <li>Delete all your anime and manga lists</li>
                                        <li>Remove all your reviews and comments</li>
                                        <li>Cancel any active subscriptions</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button onclick="openDeleteModal()" class="bg-red-600 hover:bg-red-500 text-white py-2 px-4 rounded-md transition-all flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Delete Account
                    </button>
                </div>
                
                <!-- Two-Factor Authentication Section -->
                <div class="settings-card p-6">
                    <h2 class="text-xl font-semibold text-purple-400 mb-4">Two-Factor Authentication</h2>
                    <p class="text-gray-400 mb-6">Add an extra layer of security to your account</p>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-white font-medium">Two-Factor Authentication</h3>
                            <p class="text-sm text-gray-400">Protect your account with an additional verification step</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endsection

    <!-- Delete Account Confirmation Modal -->
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
                                Delete Account
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-300">
                                    Are you sure you want to delete your account? All of your data will be permanently removed. This action cannot be undone.
                                </p>
                            </div>
                            <div class="mt-4">
                                <label for="delete-confirm" class="block text-sm font-medium text-gray-300">Type "DELETE" to confirm</label>
                                <input type="text" id="delete-confirm" class="mt-1 input-dark w-full rounded-md" placeholder="DELETE">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirmDeleteBtn" disabled class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white opacity-50 cursor-not-allowed sm:ml-3 sm:w-auto sm:text-sm">
                            Delete Account
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
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
        
      
        
       
    </script>
    @endpush
	