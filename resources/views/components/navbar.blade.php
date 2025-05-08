<!-- Font yang cocok untuk tema anime -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

    .nav-link {
        position: relative;
        transition: all 0.3s ease;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: #a855f7;
        transition: width 0.3s ease;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
        width: 100%;
    }

    .nav-link:hover {
        color: #a855f7;
    }

    .nav-link.active {
        color: #a855f7;
        font-weight: 500;
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

    /* Mobile menu animation */
    .mobile-menu {
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .mobile-menu.hidden {
        transform: translateY(-10px);
        opacity: 0;
    }

    /* Genre dropdown styling */
    .genre-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        width: 260px;
        background-color: #1f2937;
        border: 1px solid #374151;
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        z-index: 50;
        padding: 0.75rem;
    }

    .genre-dropdown-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #374151;
    }

    .genre-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
    }

    .genre-item {
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .genre-item:hover {
        background-color: #374151;
        color: #a855f7;
    }
</style>

<nav class="bg-gray-900 border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Desktop Navigation -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <div class="h-10 w-10 bg-purple-700 rounded-full flex items-center justify-center mr-2 glow-effect">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <span class="text-white font-bold text-xl">MyAnimeList</span>
                </div>
                <!-- Desktop Navigation Links -->
                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                    <a href="{{ route('home') }}" class="nav-link active px-3 py-2 text-sm font-medium text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        Beranda
                    </a>
                   <!-- Genre Dropdown -->
                   <div class="relative" id="genre-container">
                    <button id="genre-button" class="nav-link px-3 py-2 text-sm font-medium text-gray-300 hover:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Genre
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Genre Dropdown Menu -->
                    <div id="genre-dropdown" class="genre-dropdown hidden">
                        <div class="genre-dropdown-header">
                            <h3 class="text-white font-medium">Pilih Genre</h3>
                            <button id="close-genre-dropdown" class="text-gray-400 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div class="genre-grid">
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Action</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Adventure</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Comedy</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Drama</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Fantasy</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Horror</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Mecha</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Music</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Mystery</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Psychological</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Romance</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Sci-Fi</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Slice of Life</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Sports</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Supernatural</a>
                            <a href="#" class="genre-item text-gray-300 hover:text-white">Thriller</a>
                        </div>
                    </div>
                </div>
                    
                    @auth
                    <!-- Menu tambahan untuk user yang sudah login -->
                    <a href="#" class="nav-link px-3 py-2 text-sm font-medium text-gray-300 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                        Anime List
                    </a>
                    <a href="#" class="nav-link px-3 py-2 text-sm font-medium text-gray-300 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        Community
                    </a>
                    @endauth
                </div>
            </div>

            <!-- Search Bar, Profile/Auth Buttons -->
            <div class="flex items-center">
                <!-- Search Bar -->
                <form action="{{ url('/anime/search') }}" method="GET">
                    <div class="hidden md:block mr-4">
                        <div class="relative">
                            <input type="text" placeholder="Cari anime..." name="q" required
                                class="input-dark w-64 pl-10 pr-4 py-2 rounded-lg text-sm focus:outline-none">
                            <button type="submit" class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>

                @auth
                <!-- Profile and Settings for logged in users -->
                <div class="hidden md:flex md:items-center">
                    <a href="#" class="setting p-2 rounded-full text-gray-400 hover:text-white focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                    <!-- User Avatar -->
                    <div class="ml-3 relative">
                        <div>
                            <button type="button"
                                class="flex items-center text-sm bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-purple-500 hover:bg-gray-700 transition"
                                id="user-menu-button">
                                <span class="sr-only">Open user menu</span>
                                <div class="h-8 w-8 rounded-full bg-purple-600 flex items-center justify-center">
                                    <span class="font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <!-- Panah dropdown -->
                                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        <!-- Dropdown menu -->
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                            id="user-dropdown">
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white"
                                role="menuitem">Dashboard</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white"
                                role="menuitem">Profil Saya</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white"
                                role="menuitem">Pengaturan</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white"
                                role="menuitem">Anime Favorit</a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <!-- Auth Buttons (Sign In / Sign Up) for guests -->
                <div class="hidden md:flex md:items-center">
                    <a href="{{ route('login') }}"
                        class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                        class="ml-2 bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-600 transition-colors btn-glow">
                        Sign Up
                    </a>
                </div>
                @endauth

                <!-- Mobile menu button -->
                <div class="flex md:hidden items-center ml-4 mobile-menu-button">
                    <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        id="mobile-menu-button">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="hidden md:hidden mobile-menu" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#" class="bg-gray-800 text-white block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
             <!-- Mobile Genre Dropdown -->
         <div class="relative" id="mobile-genre-container">
            <button id="mobile-genre-button" class="text-gray-300 hover:bg-gray-700 hover:text-white w-full text-left flex items-center justify-between px-3 py-2 rounded-md text-base font-medium">
                <span>Genre</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="mobile-genre-dropdown" class="hidden px-3 py-2">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-white font-medium">Pilih Genre</h3>
                    <button id="close-mobile-genre" class="text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-1 rounded-md text-sm">Action</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-1 rounded-md text-sm">Adventure</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-1 rounded-md text-sm">Comedy</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-1 rounded-md text-sm">Drama</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-1 rounded-md text-sm">Fantasy</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-1 rounded-md text-sm">Horror</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-1 rounded-md text-sm">Romance</a>
                    <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-1 rounded-md text-sm">Sci-Fi</a>
                </div>
                <a href="#" class="block text-purple-400 hover:text-purple-300 mt-2 text-sm">Lihat Semua Genre →</a>
            </div>
        </div>

            
            @auth
            <!-- Menu tambahan untuk user yang sudah login (mobile) -->
            <a href="#"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Anime
                List</a>
            <a href="#"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Community</a>
            @endauth
        </div>
        
        <!-- Mobile Search -->
        <form action="{{ url('/anime/search') }}" method="GET" class="px-2 pt-2 pb-3 md:hidden">
            <div class="relative">
                <input type="text" name="q" placeholder="Cari anime..." required
                    class="input-dark w-full pl-10 pr-4 py-2 rounded-lg text-sm focus:outline-none">
                <button type="submit" class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>

        @auth
        <!-- Mobile Profile Links for logged in users -->
        <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="flex items-center px-5">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center">
                        <span class="font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-white">{{ auth()->user()->name }}</div>
                    <div class="text-sm font-medium text-gray-400">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 px-2 space-y-1">
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Profil
                    Saya</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Pengaturan</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Anime
                    Favorit</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button onclick="confirm('Apakah Anda yakin ingin keluar?')" type="submit"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Keluar</button>
                </form>
            </div>
        </div>
        @else
        <!-- Mobile Auth Buttons for guests -->
        <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="flex items-center justify-center space-x-4 px-5">
                <a href="{{ route('login') }}"
                    class="w-1/2 text-center bg-gray-700 text-white px-4 py-2 rounded-md text-base font-medium hover:bg-gray-600 transition-colors">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                    class="w-1/2 text-center bg-purple-700 text-white px-4 py-2 rounded-md text-base font-medium hover:bg-purple-600 transition-colors btn-glow">
                    Sign Up
                </a>
            </div>
        </div>
        @endauth
    </div>
</nav>

<script>
// Toggle mobile menu
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
if (mobileMenuButton && mobileMenu) {
    const menuIcon = mobileMenuButton.querySelector('.block');
    const closeIcon = mobileMenuButton.querySelector('.hidden');
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });
}

// Toggle genre dropdown
const genreButton = document.getElementById('genre-button');
const genreDropdown = document.getElementById('genre-dropdown');
const closeGenreDropdown = document.getElementById('close-genre-dropdown');

if (genreButton && genreDropdown) {
    genreButton.addEventListener('click', (e) => {
        e.preventDefault();
        genreDropdown.classList.toggle('hidden');
    });
    
    // Close dropdown with X button
    if (closeGenreDropdown) {
        closeGenreDropdown.addEventListener('click', () => {
            genreDropdown.classList.add('hidden');
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!genreButton.contains(event.target) && !genreDropdown.contains(event.target)) {
            genreDropdown.classList.add('hidden');
        }
    });
}

// Toggle mobile genre dropdown
const mobileGenreButton = document.getElementById('mobile-genre-button');
const mobileGenreDropdown = document.getElementById('mobile-genre-dropdown');
const closeMobileGenre = document.getElementById('close-mobile-genre');

if (mobileGenreButton && mobileGenreDropdown) {
    mobileGenreButton.addEventListener('click', () => {
        mobileGenreDropdown.classList.toggle('hidden');
    });
    
    // Close dropdown with X button
    if (closeMobileGenre) {
        closeMobileGenre.addEventListener('click', () => {
            mobileGenreDropdown.classList.add('hidden');
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!mobileGenreButton.contains(event.target) && !mobileGenreDropdown.contains(event.target) && !mobileGenreDropdown.contains(event.target.parentNode)) {
            mobileGenreDropdown.classList.add('hidden');
        }
    });
}

// Toggle user dropdown
const userMenuButton = document.getElementById('user-menu-button');
const userDropdown = document.getElementById('user-dropdown');
if (userMenuButton && userDropdown) {
    userMenuButton.addEventListener('click', () => {
        userDropdown.classList.toggle('hidden');
    });
    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.add('hidden');
        }
    });
}
</script>