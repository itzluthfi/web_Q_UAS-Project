@extends('layouts.dashboard')
@section('title', 'Profile Admin - AnimeVerse ')
@section('page-header', 'Profile - AnimeVerse') {{-- Ini akan masuk ke navbar --}}
@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f1116;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-pulse-slow {
            animation: pulse 3s infinite;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Glowing effects */
        .glow-effect {
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.5);
            transition: all 0.3s ease;
        }

        .glow-effect:hover {
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.8);
        }

        .btn-glow {
            position: relative;
            z-index: 1;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.5);
        }

        .btn-glow::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(139, 92, 246, 0.3), rgba(124, 58, 237, 0.3));
            z-index: -1;
            transform: scaleX(0);
            transform-origin: 0 50%;
            transition: transform 0.5s ease-out;
        }

        .btn-glow:hover::after {
            transform: scaleX(1);
        }

        /* Custom form elements */
        .input-dark {
            background-color: rgba(30, 32, 44, 0.8);
            border: 1px solid #2e3346;
            color: #e2e8f0;
            transition: all 0.3s ease;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
        }

        .input-dark:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
            outline: none;
        }

        /* Sidebar styling */
        .sidebar {
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 40;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar-link {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            background-color: rgba(139, 92, 246, 0.1);
            border-left-color: #8b5cf6;
        }

        .sidebar-link.active {
            background-color: rgba(139, 92, 246, 0.2);
            border-left-color: #8b5cf6;
        }

        /* Profile card styling */
        .profile-card {
            background-color: #1f2937;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }

        /* Profile image */
        .profile-image-container {
            position: relative;
            margin: 0 auto;
            width: 150px;
            height: 150px;
        }

        .profile-image {
            border: 4px solid #8b5cf6;
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.5);
            transition: all 0.3s ease;
        }

        .profile-image:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.8);
        }

        .profile-image-edit {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #8b5cf6;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0;
        }

        .profile-image-container:hover .profile-image-edit {
            opacity: 1;
        }

        /* Stats cards */
        .stat-card {
            background-color: #2d3748;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        }

        /* Modal styling */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Custom scrollbar */
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
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100" x-data="{
    sidebarOpen: window.innerWidth >= 768,
    profileModalOpen: false,
    photoModalOpen: false,
    activeTab: 'overview'
}">


    <!-- Main Content Wrapper -->

    @section('content')
        <!-- Main Content -->
        <main class="p-4 sm:p-6 animate-fade-in">
            <!-- Profile Header with Background -->
            <div class="profile-card mb-8 overflow-hidden">
                <!-- Profile Banner -->
                <div class="h-48 bg-gradient-to-r from-purple-900 to-indigo-900 relative">
                    <div class="absolute inset-0 bg-black opacity-30"></div>
                    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-gray-900 to-transparent"></div>
                </div>

                <!-- Profile Content -->
                <div class="px-4 sm:px-6 pb-6 -mt-20 relative z-10">
                    <!-- Profile Image (Centered) -->
                    <div class="flex flex-col items-center">
                        <div class="profile-image-container mb-4">
                            <div class="h-40 w-40 rounded-full overflow-hidden profile-image glow-effect">
                                <img src="{{ asset('storage/' . ($user->profile_image_url ?? 'https://cdn.vectorstock.com/i/500p/45/59/profile-photo-placeholder-icon-design-in-gray-vector-37114559.jpg')) }}"
                                    alt="Profile Picture" class="h-full w-full object-cover">
                            </div>
                            <button @click="photoModalOpen = true" class="profile-image-edit glow-effect">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>

                        <div class="text-center mb-6">
                            <h1 class="text-3xl font-bold text-white mb-1 mt-2">{{ $user->username ?? 'Unknown' }}</h1>
                            <p class="text-gray-400">{{ $user->email }}</p>
                            {{-- <div class="flex items-center justify-center mt-3 space-x-2">
                                <span
                                    class="px-3 py-1 bg-purple-900/50 text-purple-300 text-xs rounded-full border border-purple-700">
                                    <i class="fas fa-star mr-1"></i> Premium Member
                                </span>
                                <span
                                    class="px-3 py-1 bg-blue-900/50 text-blue-300 text-xs rounded-full border border-blue-700">
                                    <i class="fas fa-check-circle mr-1"></i> Verified
                                </span>
                            </div> --}}
                        </div>

                        <button @click="profileModalOpen = true"
                            class="bg-purple-700 hover:bg-purple-600 text-white py-2 px-6 rounded-md btn-glow transition-all mb-6">
                            <i class="fas fa-edit mr-2"></i> Edit Profile
                        </button>
                    </div>

                    <!-- Profile Stats Cards -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                        <div class="stat-card p-4 text-center">
                            <div class="text-2xl font-bold text-purple-400">127</div>
                            <div class="text-sm text-gray-400">Anime Watched</div>
                        </div>
                        <div class="stat-card p-4 text-center">
                            <div class="text-2xl font-bold text-purple-400">109</div>
                            <div class="text-sm text-gray-400">My Anime List</div>
                        </div>
                        <div class="stat-card p-4 text-center">
                            <div class="text-2xl font-bold text-purple-400">{{ $jml_komentar ?? 0 }}</div>
                            <div class="text-sm text-gray-400">My Comment </div>
                        </div>
                        <div class="stat-card p-4 text-center">
                            <div class="text-2xl font-bold text-purple-400">15</div>
                            <div class="text-sm text-gray-400">Reviews</div>
                        </div>
                    </div>

                    <!-- Bio Section -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-purple-400 mb-3">Bio</h2>
                        <p class="text-gray-300">
                            Hi! I'm Naruto Uzumaki, a ninja from the Hidden Leaf Village. My dream is to become the Hokage!
                            I love ramen, especially from Ichiraku. My favorite anime are action and adventure series. I'm
                            always looking for recommendations, so feel free to message me!
                        </p>
                    </div>

                    {{-- <!-- Profile Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-lg font-semibold text-purple-400 mb-3">Profile Information</h2>
                            <div class="space-y-3">
                                <div class="flex">
                                    <span class="text-gray-400 w-24"><i class="fas fa-user mr-2"></i>Name:</span>
                                    <span class="text-white">{{ $user->username ?? 'Unknown' }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-400 w-24"><i class="fas fa-envelope mr-2"></i>Email:</span>
                                    <span class="text-white">{{ $user->email ?? 'Unknown' }}</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-400 w-24"><i
                                            class="fas fa-map-marker-alt mr-2"></i>Location:</span>
                                    <span class="text-white">Konoha, Land of Fire</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-400 w-24"><i class="fas fa-calendar-alt mr-2"></i>Joined:</span>
                                    <span class="text-white">{{ $user->created_at ?? '' }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-purple-400 mb-3">Social Links</h2>
                            <div class="space-y-3">
                                <a href="#"
                                    class="flex items-center text-gray-300 hover:text-white transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                                        <i class="fab fa-twitter text-white"></i>
                                    </div>
                                    <span>@naruto_uzumaki</span>
                                </a>
                                <a href="#"
                                    class="flex items-center text-gray-300 hover:text-white transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-pink-600 flex items-center justify-center mr-3">
                                        <i class="fab fa-instagram text-white"></i>
                                    </div>
                                    <span>@naruto.uzumaki</span>
                                </a>
                                <a href="#"
                                    class="flex items-center text-gray-300 hover:text-white transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center mr-3">
                                        <i class="fab fa-youtube text-white"></i>
                                    </div>
                                    <span>Naruto's Ninja Way</span>
                                </a>
                                <a href="#"
                                    class="flex items-center text-gray-300 hover:text-white transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                        <i class="fab fa-discord text-white"></i>
                                    </div>
                                    <span>naruto#1234</span>
                                </a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <!-- Profile Tabs -->
            <div class="mb-6 border-b border-gray-800">
                <div class="flex overflow-x-auto">
                    <button @click="activeTab = 'overview'" :class="{ 'tab-active': activeTab === 'overview' }"
                        class="px-4 py-2 text-sm font-medium whitespace-nowrap transition-colors">
                        Overview
                    </button>
                    <button @click="activeTab = 'anime'" :class="{ 'tab-active': activeTab === 'anime' }"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white whitespace-nowrap transition-colors">
                        Anime List
                    </button>
                    <button @click="activeTab = 'comment'" :class="{ 'tab-active': activeTab === 'comment' }"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white whitespace-nowrap transition-colors">
                        My Comment List
                    </button>
                    <button @click="activeTab = 'reviews'" :class="{ 'tab-active': activeTab === 'reviews' }"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white whitespace-nowrap transition-colors">
                        Reviews
                    </button>
                    <button @click="activeTab = 'friends'" :class="{ 'tab-active': activeTab === 'friends' }"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white whitespace-nowrap transition-colors">
                        Friends
                    </button>
                    <button @click="activeTab = 'activity'" :class="{ 'tab-active': activeTab === 'activity' }"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white whitespace-nowrap transition-colors">
                        Activity
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div x-show="activeTab === 'overview'" class="animate-fade-in">
                <!-- Recently Watched -->
                <div class="profile-card p-6 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-purple-400">Recently Watched</h2>
                        <a href="#" class="text-sm text-purple-400 hover:text-purple-300 flex items-center">
                            <span>View All</span>
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <!-- Anime Card 1 -->
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all">
                            <div class="h-40 bg-gray-700 relative overflow-hidden">
                                <div class="absolute inset-0 bg-purple-900/20"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60">
                                </div>
                                <div class="absolute bottom-2 left-2">
                                    <span class="px-2 py-1 bg-purple-700 text-xs text-white rounded">TV</span>
                                    <span class="px-2 py-1 bg-gray-800 text-xs text-white rounded ml-1">2023</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-white font-medium mb-1 truncate">One Piece</h3>
                                <p class="text-gray-400 text-sm mb-2">Episode 1081</p>
                                <div class="flex items-center text-yellow-400 text-sm">
                                    <i class="fas fa-star mr-1"></i>
                                    <span>9.2</span>
                                </div>
                            </div>
                        </div>

                        <!-- Anime Card 2 -->
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all">
                            <div class="h-40 bg-gray-700 relative overflow-hidden">
                                <div class="absolute inset-0 bg-blue-900/20"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60">
                                </div>
                                <div class="absolute bottom-2 left-2">
                                    <span class="px-2 py-1 bg-purple-700 text-xs text-white rounded">TV</span>
                                    <span class="px-2 py-1 bg-gray-800 text-xs text-white rounded ml-1">2023</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-white font-medium mb-1 truncate">Jujutsu Kaisen</h3>
                                <p class="text-gray-400 text-sm mb-2">Episode 15</p>
                                <div class="flex items-center text-yellow-400 text-sm">
                                    <i class="fas fa-star mr-1"></i>
                                    <span>9.0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Anime Card 3 -->
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all">
                            <div class="h-40 bg-gray-700 relative overflow-hidden">
                                <div class="absolute inset-0 bg-indigo-900/20"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60">
                                </div>
                                <div class="absolute bottom-2 left-2">
                                    <span class="px-2 py-1 bg-purple-700 text-xs text-white rounded">TV</span>
                                    <span class="px-2 py-1 bg-gray-800 text-xs text-white rounded ml-1">2023</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-white font-medium mb-1 truncate">Demon Slayer</h3>
                                <p class="text-gray-400 text-sm mb-2">Episode 8</p>
                                <div class="flex items-center text-yellow-400 text-sm">
                                    <i class="fas fa-star mr-1"></i>
                                    <span>8.8</span>
                                </div>
                            </div>
                        </div>

                        <!-- Anime Card 4 -->
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all">
                            <div class="h-40 bg-gray-700 relative overflow-hidden">
                                <div class="absolute inset-0 bg-pink-900/20"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60">
                                </div>
                                <div class="absolute bottom-2 left-2">
                                    <span class="px-2 py-1 bg-purple-700 text-xs text-white rounded">Movie</span>
                                    <span class="px-2 py-1 bg-gray-800 text-xs text-white rounded ml-1">2023</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-white font-medium mb-1 truncate">Suzume no Tojimari</h3>
                                <p class="text-gray-400 text-sm mb-2">Movie</p>
                                <div class="flex items-center text-yellow-400 text-sm">
                                    <i class="fas fa-star mr-1"></i>
                                    <span>8.5</span>
                                </div>
                            </div>
                        </div>

                        <!-- Anime Card 5 -->
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all">
                            <div class="h-40 bg-gray-700 relative overflow-hidden">
                                <div class="absolute inset-0 bg-green-900/20"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60">
                                </div>
                                <div class="absolute bottom-2 left-2">
                                    <span class="px-2 py-1 bg-purple-700 text-xs text-white rounded">TV</span>
                                    <span class="px-2 py-1 bg-gray-800 text-xs text-white rounded ml-1">2023</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-white font-medium mb-1 truncate">My Hero Academia</h3>
                                <p class="text-gray-400 text-sm mb-2">Episode 24</p>
                                <div class="flex items-center text-yellow-400 text-sm">
                                    <i class="fas fa-star mr-1"></i>
                                    <span>8.7</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Friends List -->
                <div class="profile-card p-6 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-purple-400">Friends</h2>
                        <a href="#" class="text-sm text-purple-400 hover:text-purple-300 flex items-center">
                            <span>View All</span>
                            <i class="fas fa-chevron-right ml-1 text-xs"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <!-- Friend Card 1 -->
                        <div class="bg-gray-800 rounded-lg p-4 flex items-center">
                            <div class="h-12 w-12 rounded-full bg-purple-600 flex items-center justify-center mr-4">
                                <span class="font-bold text-white">S</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">Sasuke Uchiha</h4>
                                <p class="text-gray-400 text-sm">Online now</p>
                            </div>
                            <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Online</span>
                        </div>

                        <!-- Friend Card 2 -->
                        <div class="bg-gray-800 rounded-lg p-4 flex items-center">
                            <div class="h-12 w-12 rounded-full bg-purple-600 flex items-center justify-center mr-4">
                                <span class="font-bold text-white">S</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">Sakura Haruno</h4>
                                <p class="text-gray-400 text-sm">18 minutes ago</p>
                            </div>
                            <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Online</span>
                        </div>

                        <!-- Friend Card 3 -->
                        <div class="bg-gray-800 rounded-lg p-4 flex items-center">
                            <div class="h-12 w-12 rounded-full bg-purple-600 flex items-center justify-center mr-4">
                                <span class="font-bold text-white">H</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-white font-medium">Hinata Hyuga</h4>
                                <p class="text-gray-400 text-sm">25 minutes ago</p>
                            </div>
                            <span class="px-2 py-1 bg-green-900/30 text-green-400 text-xs rounded-full">Online</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Tab Contents (Hidden by default) -->
            <div x-show="activeTab === 'anime'" class="animate-fade-in" style="display: none;">
                <div class="profile-card p-6">
                    <h2 class="text-xl font-semibold text-purple-400 mb-6">My Anime List</h2>
                    <!-- Anime list content would go here -->
                    <p class="text-gray-400">Your anime list content will appear here.</p>
                </div>
            </div>

            <div x-show="activeTab === 'comment'" class="animate-fade-in" style="display: none;">
                <div class="profile-card p-6">
                    <h2 class="text-xl font-semibold text-purple-400 mb-6">My comment List</h2>
                    <!-- comment list content would go here -->
                    <p class="text-gray-400">Your comment list content will appear here.</p>
                </div>
            </div>

            <div x-show="activeTab === 'reviews'" class="animate-fade-in" style="display: none;">
                <div class="profile-card p-6">
                    <h2 class="text-xl font-semibold text-purple-400 mb-6">My Reviews</h2>
                    <!-- Reviews content would go here -->
                    <p class="text-gray-400">Your reviews will appear here.</p>
                </div>
            </div>

            <div x-show="activeTab === 'friends'" class="animate-fade-in" style="display: none;">
                <div class="profile-card p-6">
                    <h2 class="text-xl font-semibold text-purple-400 mb-6">My Friends</h2>
                    <!-- Friends content would go here -->
                    <p class="text-gray-400">Your friends list will appear here.</p>
                </div>
            </div>

            <div x-show="activeTab === 'activity'" class="animate-fade-in" style="display: none;">
                <div class="profile-card p-6">
                    <h2 class="text-xl font-semibold text-purple-400 mb-6">Recent Activity</h2>
                    <!-- Activity content would go here -->
                    <p class="text-gray-400">Your recent activity will appear here.</p>
                </div>
            </div>
        </main>
    @endsection



    <!-- Edit Profile Modal -->
    <div x-show="profileModalOpen" class="fixed inset-0 z-50 overflow-y-auto"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity modal-backdrop" aria-hidden="true"
                @click="profileModalOpen = false">
            </div>

            <div class="inline-block align-bottom bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-content"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-white mb-4">
                                Edit Profile
                            </h3>
                            <div class="mt-2">
                                <form>
                                    <div class="mb-4">
                                        <label for="fullname"
                                            class="block text-sm font-medium text-gray-300 mb-1">Full Name</label>
                                        <input type="text" id="fullname" name="fullname" value="Naruto Uzumaki"
                                            class="input-dark w-full">
                                    </div>

                                    <div class="mb-4">
                                        <label for="username"
                                            class="block text-sm font-medium text-gray-300 mb-1">Username</label>
                                        <input type="text" id="username" name="username" value="naruto_uzumaki"
                                            class="input-dark w-full">
                                    </div>

                                    <div class="mb-4">
                                        <label for="email"
                                            class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                                        <input type="email" id="email" name="email"
                                            value="naruto@konoha.com" class="input-dark w-full">
                                    </div>

                                    <div class="mb-4">
                                        <label for="location"
                                            class="block text-sm font-medium text-gray-300 mb-1">Location</label>
                                        <input type="text" id="location" name="location"
                                            value="Konoha, Land of Fire" class="input-dark w-full">
                                    </div>

                                    <div class="mb-4">
                                        <label for="bio"
                                            class="block text-sm font-medium text-gray-300 mb-1">Bio</label>
                                        <textarea id="bio" name="bio" rows="4" class="input-dark w-full">Hi! I'm Naruto Uzumaki, a ninja from the Hidden Leaf Village. My dream is to become the Hokage! I love ramen, especially from Ichiraku. My favorite anime are action and adventure series. I'm always looking for recommendations, so feel free to message me!</textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-700 text-base font-medium text-white hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm btn-glow">
                        Save Changes
                    </button>
                    <button @click="profileModalOpen = false" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Photo Modal -->
    <!-- Modal Wrapper -->
    <div x-show="photoModalOpen" class="fixed inset-0 z-50 overflow-y-auto"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity modal-backdrop" aria-hidden="true"
                @click="photoModalOpen = false">
            </div>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-content"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <!-- ✅ Mulai Form di sini -->
                <form action="{{ route('auth.profile.uploadImage') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white mb-4">
                                    Change Profile Photo
                                </h3>

                                <div class="flex justify-center mb-6">
                                    <div class="h-32 w-32 rounded-full overflow-hidden profile-image">
                                        <img src="{{ asset('storage/' . ($user->profile_image_url ?? 'https://cdn.vectorstock.com/i/500p/45/59/profile-photo-placeholder-icon-design-in-gray-vector-37114559.jpg')) }}"
                                            alt="Profile Picture" class="h-full w-full object-cover">
                                    </div>
                                </div>

                                <div class="flex items-center justify-center">
                                    <label
                                        class="w-full flex flex-col items-center px-4 py-6 bg-gray-800 text-gray-300 rounded-lg shadow-lg tracking-wide border border-gray-700 cursor-pointer hover:bg-gray-700 transition-colors">
                                        <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                        <span class="mt-2 text-sm">Select a file</span>
                                        <input type='file' name="profile_image" class="hidden" required />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-700 text-base font-medium text-white hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm btn-glow">
                            Upload Photo
                        </button>
                        <button @click="photoModalOpen = false" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
                <!-- ✅ Akhir Form -->
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
