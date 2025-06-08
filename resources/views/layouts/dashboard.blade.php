<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
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

    <!-- Scripts Dinamis -->
    @stack('scripts')

</body>

</html>
