<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyAnimeList - Profile</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f1116;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
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
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100" x-data="{ 
    sidebarOpen: window.innerWidth >= 768,
    profileModalOpen: false,
    photoModalOpen: false,
    activeTab: 'overview'
}">
    <!-- Sidebar Overlay -->
    <div 
        class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden transition-opacity duration-300" 
        x-show="sidebarOpen" 
        x-transition:enter="transition ease-out duration-300" 
        x-transition:enter-start="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="transition ease-in duration-300" 
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false">
    </div>
    
    <!-- Sidebar -->
    <aside 
        class="sidebar bg-gray-900 border-r border-gray-800 transform transition-transform duration-300 ease-in-out" 
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
        <div class="p-4 flex items-center justify-between border-b border-gray-800">
            <a href="/" class="flex items-center">
                <div class="h-10 w-10 bg-purple-700 rounded-md flex items-center justify-center text-white font-bold">
                    A
                </div>
                <span class="ml-2 text-xl font-semibold text-white">AnimeProfile</span>
            </a>
            <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white lg:hidden">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="py-4">
            <div class="px-4 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</p>
            </div>

            <nav class="space-y-1">
                <a href="/" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                    <i class="fas fa-home w-5 h-5 text-center"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <a href="/profile" class="sidebar-link active flex items-center px-4 py-3 text-gray-300 hover:text-white">
                    <i class="fas fa-user w-5 h-5 text-center"></i>
                    <span class="ml-3">Profile</span>
                </a>

                <a href="/anime" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                    <i class="fas fa-film w-5 h-5 text-center"></i>
                    <span class="ml-3">Anime List</span>
                </a>

                <a href="/manga" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                    <i class="fas fa-book w-5 h-5 text-center"></i>
                    <span class="ml-3">Manga List</span>
                </a>

                <a href="/favorites" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                    <i class="fas fa-heart w-5 h-5 text-center"></i>
                    <span class="ml-3">Favorites</span>
                </a>

                <a href="/schedule" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                    <i class="fas fa-calendar w-5 h-5 text-center"></i>
                    <span class="ml-3">Schedule</span>
                </a>

                <a href="/messages" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                    <i class="fas fa-comment w-5 h-5 text-center"></i>
                    <span class="ml-3">Messages</span>
                </a>
            </nav>

            <div class="px-4 mt-6 mb-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Settings</p>
            </div>

            <nav class="space-y-1">
                <a href="/settings" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                    <i class="fas fa-cog w-5 h-5 text-center"></i>
                    <span class="ml-3">Settings</span>
                </a>

                <a href="/logout" class="sidebar-link flex items-center px-4 py-3 text-gray-300 hover:text-white">
                    <i class="fas fa-sign-out-alt w-5 h-5 text-center"></i>
                    <span class="ml-3">Logout</span>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper transition-all duration-300" :class="{'ml-0': !sidebarOpen, 'ml-0 lg:ml-64': sidebarOpen}">
        <!-- Top Navbar -->
        <header class="bg-gray-900 border-b border-gray-800 py-4 px-4 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white mr-4">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="relative hidden md:block">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="search" class="pl-10 pr-3 py-2 w-64 bg-gray-800 border border-gray-700 rounded-md text-gray-300 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500" placeholder="Search...">
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ notificationOpen: false }">
                        <button @click="notificationOpen = !notificationOpen" class="text-gray-400 hover:text-white relative">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                        
                        <div 
                            x-show="notificationOpen" 
                            @click.away="notificationOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-80 bg-gray-800 rounded-md shadow-lg py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-700">
                                <h3 class="text-sm font-medium text-white">Notifications</h3>
                            </div>
                            <div class="max-h-60 overflow-y-auto">
                                <a href="#" class="block px-4 py-2 hover:bg-gray-700">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center">
                                                <i class="fas fa-comment text-white"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-white">New message from Sasuke</p>
                                            <p class="text-xs text-gray-400">5 minutes ago</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-700">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center">
                                                <i class="fas fa-heart text-white"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-white">Hinata liked your review</p>
                                            <p class="text-xs text-gray-400">1 hour ago</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-700">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center">
                                                <i class="fas fa-bell text-white"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-white">New episode of One Piece is out!</p>
                                            <p class="text-xs text-gray-400">3 hours ago</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="px-4 py-2 border-t border-gray-700">
                                <a href="#" class="text-xs text-purple-400 hover:text-purple-300">View all notifications</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center text-gray-400 hover:text-white">
                            <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center">
                                <span class="font-bold text-white">N</span>
                            </div>
                        </button>

                        <div 
                            x-show="userMenuOpen" 
                            @click.away="userMenuOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 z-50">
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Your Profile</a>
                            <a href="/settings" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Settings</a>
                            <div class="border-t border-gray-700 my-1"></div>
                            <a href="/logout" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Sign out</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

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
                                <img src="https://via.placeholder.com/400x400" alt="Profile Picture" class="h-full w-full object-cover">
                            </div>
                            <button @click="photoModalOpen = true" class="profile-image-edit glow-effect">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        
                        <div class="text-center mb-6">
                            <h1 class="text-3xl font-bold text-white mb-1">Naruto Uzumaki</h1>
                            <p class="text-gray-400">@naruto_uzumaki</p>
                            <div class="flex items-center justify-center mt-3 space-x-2">
                                <span class="px-3 py-1 bg-purple-900/50 text-purple-300 text-xs rounded-full border border-purple-700">
                                    <i class="fas fa-star mr-1"></i> Premium Member
                                </span>
                                <span class="px-3 py-1 bg-blue-900/50 text-blue-300 text-xs rounded-full border border-blue-700">
                                    <i class="fas fa-check-circle mr-1"></i> Verified
                                </span>
                            </div>
                        </div>
                        
                        <button @click="profileModalOpen = true" class="bg-purple-700 hover:bg-purple-600 text-white py-2 px-6 rounded-md btn-glow transition-all mb-6">
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
                            <div class="text-2xl font-bold text-purple-400">1,842</div>
                            <div class="text-sm text-gray-400">Episodes</div>
                        </div>
                        <div class="stat-card p-4 text-center">
                            <div class="text-2xl font-bold text-purple-400">42</div>
                            <div class="text-sm text-gray-400">Manga Read</div>
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
                            Hi! I'm Naruto Uzumaki, a ninja from the Hidden Leaf Village. My dream is to become the Hokage! I love ramen, especially from Ichiraku. My favorite anime are action and adventure series. I'm always looking for recommendations, so feel free to message me!
                        </p>
                    </div>
                    
                    <!-- Profile Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-lg font-semibold text-purple-400 mb-3">Profile Information</h2>
                            <div class="space-y-3">
                                <div class="flex">
                                    <span class="text-gray-400 w-24"><i class="fas fa-user mr-2"></i>Name:</span>
                                    <span class="text-white">Naruto Uzumaki</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-400 w-24"><i class="fas fa-at mr-2"></i>Username:</span>
                                    <span class="text-white">naruto_uzumaki</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-400 w-24"><i class="fas fa-envelope mr-2"></i>Email:</span>
                                    <span class="text-white">naruto@konoha.com</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-400 w-24"><i class="fas fa-map-marker-alt mr-2"></i>Location:</span>
                                    <span class="text-white">Konoha, Land of Fire</span>
                                </div>
                                <div class="flex">
                                    <span class="text-gray-400 w-24"><i class="fas fa-calendar-alt mr-2"></i>Joined:</span>
                                    <span class="text-white">October 10, 2002</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h2 class="text-lg font-semibold text-purple-400 mb-3">Social Links</h2>
                            <div class="space-y-3">
                                <a href="#" class="flex items-center text-gray-300 hover:text-white transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                                        <i class="fab fa-twitter text-white"></i>
                                    </div>
                                    <span>@naruto_uzumaki</span>
                                </a>
                                <a href="#" class="flex items-center text-gray-300 hover:text-white transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-pink-600 flex items-center justify-center mr-3">
                                        <i class="fab fa-instagram text-white"></i>
                                    </div>
                                    <span>@naruto.uzumaki</span>
                                </a>
                                <a href="#" class="flex items-center text-gray-300 hover:text-white transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center mr-3">
                                        <i class="fab fa-youtube text-white"></i>
                                    </div>
                                    <span>Naruto's Ninja Way</span>
                                </a>
                                <a href="#" class="flex items-center text-gray-300 hover:text-white transition-colors">
                                    <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center mr-3">
                                        <i class="fab fa-discord text-white"></i>
                                    </div>
                                    <span>naruto#1234</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Tabs -->
            <div class="mb-6 border-b border-gray-800">
                <div class="flex overflow-x-auto">
                    <button 
                        @click="activeTab = 'overview'" 
                        :class="{'tab-active': activeTab === 'overview'}"
                        class="px-4 py-2 text-sm font-medium whitespace-nowrap transition-colors">
                        Overview
                    </button>
                    <button 
                        @click="activeTab = 'anime'" 
                        :class="{'tab-active': activeTab === 'anime'}"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white whitespace-nowrap transition-colors">
                        Anime List
                    </button>
                    <button 
                        @click="activeTab = 'manga'" 
                        :class="{'tab-active': activeTab === 'manga'}"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white whitespace-nowrap transition-colors">
                        Manga List
                    </button>
                    <button 
                        @click="activeTab = 'reviews'" 
                        :class="{'tab-active': activeTab === 'reviews'}"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white whitespace-nowrap transition-colors">
                        Reviews
                    </button>
                    <button 
                        @click="activeTab = 'friends'" 
                        :class="{'tab-active': activeTab === 'friends'}"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-white whitespace-nowrap transition-colors">
                        Friends
                    </button>
                    <button 
                        @click="activeTab = 'activity'" 
                        :class="{'tab-active': activeTab === 'activity'}"
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
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
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
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
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
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
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
                                    <i class="fas fa-star mr-1"></i>
                                    <span>8.5</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Anime Card 5 -->
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all">
                            <div class="h-40 bg-gray-700 relative overflow-hidden">
                                <div class="absolute inset-0 bg-green-900/20"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
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
            
            <div x-show="activeTab === 'manga'" class="animate-fade-in" style="display: none;">
                <div class="profile-card p-6">
                    <h2 class="text-xl font-semibold text-purple-400 mb-6">My Manga List</h2>
                    <!-- Manga list content would go here -->
                    <p class="text-gray-400">Your manga list content will appear here.</p>
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
        
        <!-- Footer -->
        <footer class="bg-gray-900 border-t border-gray-800 py-4 px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; 2023, Made with 
                    <i class="fas fa-heart text-red-500 mx-1"></i>
                    by AnimeProfile Team
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Help</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">FAQ</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Edit Profile Modal -->
    <div 
        x-show="profileModalOpen" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div 
                class="fixed inset-0 transition-opacity modal-backdrop" 
                aria-hidden="true"
                @click="profileModalOpen = false">
            </div>

            <div 
                class="inline-block align-bottom bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-content"
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
                                        <label for="fullname" class="block text-sm font-medium text-gray-300 mb-1">Full Name</label>
                                        <input type="text" id="fullname" name="fullname" value="Naruto Uzumaki" class="input-dark w-full">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Username</label>
                                        <input type="text" id="username" name="username" value="naruto_uzumaki" class="input-dark w-full">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                                        <input type="email" id="email" name="email" value="naruto@konoha.com" class="input-dark w-full">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="location" class="block text-sm font-medium text-gray-300 mb-1">Location</label>
                                        <input type="text" id="location" name="location" value="Konoha, Land of Fire" class="input-dark w-full">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="bio" class="block text-sm font-medium text-gray-300 mb-1">Bio</label>
                                        <textarea id="bio" name="bio" rows="4" class="input-dark w-full">Hi! I'm Naruto Uzumaki, a ninja from the Hidden Leaf Village. My dream is to become the Hokage! I love ramen, especially from Ichiraku. My favorite anime are action and adventure series. I'm always looking for recommendations, so feel free to message me!</textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-700 text-base font-medium text-white hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm btn-glow">
                        Save Changes
                    </button>
                    <button @click="profileModalOpen = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Change Photo Modal -->
    <div 
        x-show="photoModalOpen" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div 
                class="fixed inset-0 transition-opacity modal-backdrop" 
                aria-hidden="true"
                @click="photoModalOpen = false">
            </div>

            <div 
                class="inline-block align-bottom bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-content"
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
                                Change Profile Photo
                            </h3>
                            <div class="mt-2">
                                <div class="flex justify-center mb-6">
                                    <div class="h-32 w-32 rounded-full overflow-hidden profile-image">
                                        <img src="https://via.placeholder.com/400x400" alt="Profile Picture" class="h-full w-full object-cover">
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-center">
                                    <label class="w-full flex flex-col items-center px-4 py-6 bg-gray-800 text-gray-300 rounded-lg shadow-lg tracking-wide border border-gray-700 cursor-pointer hover:bg-gray-700 transition-colors">
                                        <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                        <span class="mt-2 text-sm">Select a file</span>
                                        <input type='file' class="hidden" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-700 text-base font-medium text-white hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm btn-glow">
                        Upload Photo
                    </button>
                    <button @click="photoModalOpen = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>