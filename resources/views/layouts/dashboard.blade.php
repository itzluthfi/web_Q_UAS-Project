<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyAnimeList - Admin')</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com "></script>
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins :wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles Dinamis -->
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


        Table styling .admin-table {
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
    </style>
    @stack('styles')
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100 font-poppins">
    <!-- Sidebar -->
    @include('components.sidebarAdmin')
    <!-- Main Content Wrapper -->
    <div class="main-wrapper" id="mainWrapper" style="margin-left: 260px;">
        <!-- Top Navbar -->
        @include('components.navbarDashboard')

        <!-- Main Content -->
        <main class="p-6 min-h-screen">
            @yield('content')
        </main>
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Footer -->
        @include('components.footerAdmin')
    </div>
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
    <!-- Scripts Dinamis -->
    @stack('scripts')

</body>

</html>
