<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnimeVerse - Discover Your Next Favorite Anime</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'anime-purple': {
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                        'anime-dark': {
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827',
                            950: '#0a0c10',
                        },
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    },
                }
            }
        }
    </script>
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

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 25px rgba(101, 31, 255, 0.5);
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

        /* Carousel animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .carousel-item {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }

        .carousel-item.active {
            display: block;
        }

        /* Floating animation for featured badges */
        .float-badge {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(to right, #a78bfa, #6d28d9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Shimmer effect for loading */
        .shimmer {
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0) 100%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-anime-dark-900 to-black text-gray-100">
    <!-- Navbar -->
    <nav class="bg-anime-dark-950/80 backdrop-blur-md sticky top-0 z-50 border-b border-anime-purple-900/20">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="#" class="flex items-center">
                        <span class="text-2xl font-bold gradient-text">Anime<span class="text-white">Verse</span></span>
                    </a>
                    <div class="hidden md:flex space-x-6 ml-10">
                        <a href="#" class="text-white hover:text-anime-purple-400 transition-colors">Home</a>
                        <a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Discover</a>
                        <a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Genres</a>
                        <a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Movies</a>
                        <a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">News</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative hidden md:block">
                        <input type="text" placeholder="Search anime..." class="bg-anime-dark-800/80 border border-anime-dark-700 text-gray-300 px-4 py-2 rounded-full w-64 focus:outline-none focus:border-anime-purple-600 focus:ring-1 focus:ring-anime-purple-600">
                        <button class="absolute right-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <a href="#" class="bg-anime-purple-700 hover:bg-anime-purple-600 text-white px-4 py-2 rounded-full transition-colors btn-glow">
                        Sign In
                    </a>
                    <button class="md:hidden text-gray-300 hover:text-white">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dismissible Ad Banner -->
    <div id="ad-banner" class="relative bg-gradient-to-r from-anime-purple-900/30 to-anime-dark-800/30 py-3 border-b border-anime-purple-900/30">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="bg-yellow-500 text-black text-xs font-bold px-2 py-0.5 rounded mr-3">AD</span>
                    <p class="text-sm text-gray-300">
                        <span class="font-semibold text-white">Premium Membership Sale!</span> 
                        Get 30% off annual subscriptions - Watch ad-free anime today!
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-xs md:text-sm bg-white text-anime-dark-900 px-3 py-1 rounded hover:bg-gray-200 transition-colors">
                        Learn More
                    </a>
                    <button onclick="document.getElementById('ad-banner').style.display='none'" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-6">
        <!-- Carousel Banner Section -->
        <div class="relative overflow-hidden mb-12 rounded-xl glow-effect">
            <!-- Carousel Container -->
            <div class="carousel-container">
                <!-- Carousel Item 1 -->
                <div class="carousel-item active">
                    <div class="relative">
                        <img src="https://via.placeholder.com/1200x400/0f1116/0f1116" alt="Demon Slayer" class="w-full h-[400px] object-cover brightness-50">
                        <div class="absolute inset-0 flex flex-col justify-end p-8 bg-gradient-to-t from-black/80 to-transparent">
                            <span class="bg-red-700 text-white px-3 py-1 rounded-full text-sm font-medium inline-block mb-3 w-max">
                                Upcoming
                            </span>
                            <h2 class="text-3xl md:text-4xl font-bold text-white mb-2">Demon Slayer: Kimetsu no Yaiba Season 4</h2>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Action</span>
                                <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Fantasy</span>
                            </div>
                            <p class="text-gray-200 mb-4 max-w-2xl">
                                Tanjiro and his friends continue their mission to defeat the demons threatening humanity. The Hashira Training Arc begins as they prepare for the final battle against Muzan Kibutsuji...
                            </p>
                            <div class="flex space-x-4">
                                <a href="#" class="bg-anime-purple-700 hover:bg-anime-purple-600 text-white px-6 py-2 rounded-lg transition-all btn-glow flex items-center">
                                    <i class="fas fa-play mr-2"></i>
                                    Details
                                </a>
                                <a href="#" class="border border-gray-400 hover:border-anime-purple-500 text-white px-6 py-2 rounded-lg transition-all flex items-center">
                                    <i class="fas fa-bookmark mr-2"></i>
                                    Add to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Carousel Item 2 -->
                <div class="carousel-item">
                    <div class="relative">
                        <img src="https://via.placeholder.com/1200x400/0f1116/0f1116" alt="My Hero Academia" class="w-full h-[400px] object-cover brightness-50">
                        <div class="absolute inset-0 flex flex-col justify-end p-8 bg-gradient-to-t from-black/80 to-transparent">
                            <span class="bg-red-700 text-white px-3 py-1 rounded-full text-sm font-medium inline-block mb-3 w-max">
                                Upcoming
                            </span>
                            <h2 class="text-3xl md:text-4xl font-bold text-white mb-2">My Hero Academia Season 7</h2>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Action</span>
                                <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Superhero</span>
                            </div>
                            <p class="text-gray-200 mb-4 max-w-2xl">
                                As the battle between heroes and villains intensifies, Deku and his classmates must push beyond their limits to protect society from the growing threat of villains led by Shigaraki...
                            </p>
                            <div class="flex space-x-4">
                                <a href="#" class="bg-anime-purple-700 hover:bg-anime-purple-600 text-white px-6 py-2 rounded-lg transition-all btn-glow flex items-center">
                                    <i class="fas fa-play mr-2"></i>
                                    Details
                                </a>
                                <a href="#" class="border border-gray-400 hover:border-anime-purple-500 text-white px-6 py-2 rounded-lg transition-all flex items-center">
                                    <i class="fas fa-bookmark mr-2"></i>
                                    Add to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Carousel Item 3 -->
                <div class="carousel-item">
                    <div class="relative">
                        <img src="https://via.placeholder.com/1200x400/0f1116/0f1116" alt="Jujutsu Kaisen" class="w-full h-[400px] object-cover brightness-50">
                        <div class="absolute inset-0 flex flex-col justify-end p-8 bg-gradient-to-t from-black/80 to-transparent">
                            <span class="bg-red-700 text-white px-3 py-1 rounded-full text-sm font-medium inline-block mb-3 w-max">
                                Upcoming
                            </span>
                            <h2 class="text-3xl md:text-4xl font-bold text-white mb-2">Jujutsu Kaisen Season 3</h2>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Supernatural</span>
                                <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Action</span>
                            </div>
                            <p class="text-gray-200 mb-4 max-w-2xl">
                                Following the Shibuya Incident, Yuji Itadori and the other jujutsu sorcerers face new threats and challenges as they continue their battle against curses and their mysterious origins...
                            </p>
                            <div class="flex space-x-4">
                                <a href="#" class="bg-anime-purple-700 hover:bg-anime-purple-600 text-white px-6 py-2 rounded-lg transition-all btn-glow flex items-center">
                                    <i class="fas fa-play mr-2"></i>
                                    Details
                                </a>
                                <a href="#" class="border border-gray-400 hover:border-anime-purple-500 text-white px-6 py-2 rounded-lg transition-all flex items-center">
                                    <i class="fas fa-bookmark mr-2"></i>
                                    Add to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carousel Controls -->
            <button class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-anime-purple-700 text-white p-2 rounded-full transition-colors z-10" id="prevBtn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-anime-purple-700 text-white p-2 rounded-full transition-colors z-10" id="nextBtn">
                <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Carousel Indicators -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
                <button class="w-3 h-3 rounded-full bg-white carousel-indicator active" data-index="0"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors carousel-indicator" data-index="1"></button>
                <button class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors carousel-indicator" data-index="2"></button>
            </div>
        </div>

        <!-- Featured Anime Section (Replacing Categories) -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-anime-purple-400">Featured Anime</h2>
                <a href="#" class="text-anime-purple-400 hover:text-anime-purple-300 transition-colors flex items-center">
                    View All
                    <i class="fas fa-chevron-right ml-1 text-sm"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <!-- Featured Item 1 -->
                <a href="#" class="bg-anime-dark-800/80 hover:bg-anime-dark-700/80 border border-anime-dark-700 rounded-lg overflow-hidden transition-all card-hover group">
                    <div class="relative">
                        <img src="https://via.placeholder.com/300x400/0f1116/0f1116" alt="One Piece" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            9.2 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-gradient-to-r from-pink-600 to-purple-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center float-badge">
                            <i class="fas fa-fire mr-1 text-xs"></i>
                            TRENDING
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-white text-sm line-clamp-2">One Piece</h3>
                        <div class="flex items-center mt-2 text-xs text-gray-400">
                            <i class="fas fa-eye mr-1 text-anime-purple-400"></i>
                            <span>1.2M views</span>
                        </div>
                    </div>
                </a>

                <!-- Featured Item 2 -->
                <a href="#" class="bg-anime-dark-800/80 hover:bg-anime-dark-700/80 border border-anime-dark-700 rounded-lg overflow-hidden transition-all card-hover group">
                    <div class="relative">
                        <img src="https://via.placeholder.com/300x400/0f1116/0f1116" alt="Attack on Titan" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            9.0 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-gradient-to-r from-pink-600 to-purple-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center float-badge">
                            <i class="fas fa-fire mr-1 text-xs"></i>
                            TRENDING
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-white text-sm line-clamp-2">Attack on Titan</h3>
                        <div class="flex items-center mt-2 text-xs text-gray-400">
                            <i class="fas fa-eye mr-1 text-anime-purple-400"></i>
                            <span>980K views</span>
                        </div>
                    </div>
                </a>

                <!-- Featured Item 3 -->
                <a href="#" class="bg-anime-dark-800/80 hover:bg-anime-dark-700/80 border border-anime-dark-700 rounded-lg overflow-hidden transition-all card-hover group">
                    <div class="relative">
                        <img src="https://via.placeholder.com/300x400/0f1116/0f1116" alt="Demon Slayer" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.9 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-gradient-to-r from-pink-600 to-purple-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center float-badge">
                            <i class="fas fa-fire mr-1 text-xs"></i>
                            TRENDING
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-white text-sm line-clamp-2">Demon Slayer</h3>
                        <div class="flex items-center mt-2 text-xs text-gray-400">
                            <i class="fas fa-eye mr-1 text-anime-purple-400"></i>
                            <span>850K views</span>
                        </div>
                    </div>
                </a>

                <!-- Featured Item 4 -->
                <a href="#" class="bg-anime-dark-800/80 hover:bg-anime-dark-700/80 border border-anime-dark-700 rounded-lg overflow-hidden transition-all card-hover group">
                    <div class="relative">
                        <img src="https://via.placeholder.com/300x400/0f1116/0f1116" alt="Jujutsu Kaisen" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.8 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-gradient-to-r from-pink-600 to-purple-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center float-badge">
                            <i class="fas fa-fire mr-1 text-xs"></i>
                            TRENDING
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-white text-sm line-clamp-2">Jujutsu Kaisen</h3>
                        <div class="flex items-center mt-2 text-xs text-gray-400">
                            <i class="fas fa-eye mr-1 text-anime-purple-400"></i>
                            <span>790K views</span>
                        </div>
                    </div>
                </a>

                <!-- Featured Item 5 -->
                <a href="#" class="bg-anime-dark-800/80 hover:bg-anime-dark-700/80 border border-anime-dark-700 rounded-lg overflow-hidden transition-all card-hover group">
                    <div class="relative">
                        <img src="https://via.placeholder.com/300x400/0f1116/0f1116" alt="My Hero Academia" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.7 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-gradient-to-r from-pink-600 to-purple-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center float-badge">
                            <i class="fas fa-fire mr-1 text-xs"></i>
                            TRENDING
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-white text-sm line-clamp-2">My Hero Academia</h3>
                        <div class="flex items-center mt-2 text-xs text-gray-400">
                            <i class="fas fa-eye mr-1 text-anime-purple-400"></i>
                            <span>720K views</span>
                        </div>
                    </div>
                </a>

                <!-- Featured Item 6 -->
                <a href="#" class="bg-anime-dark-800/80 hover:bg-anime-dark-700/80 border border-anime-dark-700 rounded-lg overflow-hidden transition-all card-hover group">
                    <div class="relative">
                        <img src="https://via.placeholder.com/300x400/0f1116/0f1116" alt="Chainsaw Man" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.6 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-gradient-to-r from-pink-600 to-purple-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center float-badge">
                            <i class="fas fa-fire mr-1 text-xs"></i>
                            TRENDING
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-white text-sm line-clamp-2">Chainsaw Man</h3>
                        <div class="flex items-center mt-2 text-xs text-gray-400">
                            <i class="fas fa-eye mr-1 text-anime-purple-400"></i>
                            <span>680K views</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Anime This Season Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-anime-purple-400">Anime This Season</h2>
                <a href="#" class="text-anime-purple-400 hover:text-anime-purple-300 transition-colors flex items-center">
                    View All
                    <i class="fas fa-chevron-right ml-1 text-sm"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Seasonal Anime 1 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Frieren: Beyond Journey's End" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            9.0 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-play mr-1 text-xs"></i>
                            NEW
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Frieren: Beyond Journey's End</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Adventure</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Fantasy</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Airing:</strong> Spring 2023</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            The story follows the elven mage Frieren, a former member of the party of heroes who defeated the Demon King and brought peace to the land after a ten-year quest...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>

                <!-- Seasonal Anime 2 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Oshi no Ko" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.8 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-play mr-1 text-xs"></i>
                            NEW
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Oshi no Ko</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Drama</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Supernatural</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Airing:</strong> Spring 2023</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            A doctor and his recently deceased patient are reborn as twins to a famous Japanese idol. They navigate the entertainment world while uncovering the dark secrets behind their mother's death...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>

                <!-- Seasonal Anime 3 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Bleach: Thousand-Year Blood War" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.9 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-play mr-1 text-xs"></i>
                            NEW
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Bleach: Thousand-Year Blood War</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Action</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Supernatural</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Airing:</strong> Spring 2023</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            The Quincy King Yhwach and his army invade Soul Society to exact revenge against the Soul Reapers. Ichigo Kurosaki and his friends must prepare for the ultimate battle...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>

                <!-- Seasonal Anime 4 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Vinland Saga Season 2" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.7 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-play mr-1 text-xs"></i>
                            NEW
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Vinland Saga Season 2</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Action</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Historical</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Airing:</strong> Spring 2023</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            After the death of his father, Thorfinn becomes a slave and works on a farm. He meets Einar, another slave, and together they dream of buying their freedom and building a new life...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dismissible In-Content Ad -->
        <div id="content-ad" class="mb-12 relative overflow-hidden rounded-xl bg-gradient-to-r from-blue-900/30 to-purple-900/30 border border-blue-800/30">
            <button onclick="document.getElementById('content-ad').style.display='none'" class="absolute top-2 right-2 bg-black/50 text-white p-1 rounded-full z-10 hover:bg-black/70 transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/3 p-6">
                    <img src="https://via.placeholder.com/400x300/0f1116/0f1116" alt="Crunchyroll Premium" class="rounded-lg shadow-lg">
                </div>
                <div class="md:w-2/3 p-6">
                    <span class="bg-yellow-500 text-black text-xs font-bold px-2 py-0.5 rounded mb-3 inline-block">SPONSORED</span>
                    <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Crunchyroll Premium - Watch Ad-Free Anime</h3>
                    <p class="text-gray-300 mb-4">Enjoy unlimited access to the largest anime library. Watch new episodes as soon as one hour after Japan. Stream on up to 6 screens at once.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#" class="bg-yellow-500 hover:bg-yellow-400 text-black px-6 py-2 rounded-lg transition-colors font-medium">
                            Try Free for 14 Days
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular This Season Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-anime-purple-400">Popular This Season</h2>
                <a href="#" class="text-anime-purple-400 hover:text-anime-purple-300 transition-colors flex items-center">
                    View All
                    <i class="fas fa-chevron-right ml-1 text-sm"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Popular Anime 1 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Fullmetal Alchemist: Brotherhood" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            9.2 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-star mr-1 text-xs"></i>
                            POPULAR
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Fullmetal Alchemist: Brotherhood</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Action</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Adventure</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Airing:</strong> Winter 2009</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            Two brothers search for a Philosopher's Stone after an attempt to revive their deceased mother goes wrong and leaves them in damaged physical forms...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>

                <!-- Popular Anime 2 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Steins;Gate" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            9.1 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-star mr-1 text-xs"></i>
                            POPULAR
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Steins;Gate</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Sci-Fi</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Thriller</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Airing:</strong> Spring 2011</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            A group of friends create a device that can send text messages to the past, but their discovery triggers a series of events that leads them to a dystopian future...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>

                <!-- Popular Anime 3 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Hunter x Hunter" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            9.0 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-star mr-1 text-xs"></i>
                            POPULAR
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Hunter x Hunter</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Action</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Adventure</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Airing:</strong> Fall 2011</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            Gon Freecss aspires to become a Hunter, an exceptional being capable of greatness. He sets out on a journey to become a Hunter and eventually find his father...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>

                <!-- Popular Anime 4 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Death Note" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.7 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-star mr-1 text-xs"></i>
                            POPULAR
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Death Note</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Mystery</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Psychological</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Airing:</strong> Fall 2006</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            A high school student discovers a supernatural notebook that grants its user the ability to kill anyone whose name is written in its pages...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW SECTION: Top Rated Anime Movies -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-anime-purple-400">Top Rated Anime Movies</h2>
                <a href="#" class="text-anime-purple-400 hover:text-anime-purple-300 transition-colors flex items-center">
                    View All
                    <i class="fas fa-chevron-right ml-1 text-sm"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Movie 1 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Your Name" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            9.0 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-blue-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-film mr-1 text-xs"></i>
                            MOVIE
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Your Name</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Romance</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Supernatural</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Released:</strong> 2016</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            Two strangers find themselves linked in a bizarre way. When a connection forms, will distance be the only thing to keep them apart?...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>

                <!-- Movie 2 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="A Silent Voice" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.9 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-blue-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-film mr-1 text-xs"></i>
                            MOVIE
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">A Silent Voice</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Drama</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Romance</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Released:</strong> 2016</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            A young man is ostracized by his classmates after he bullies a deaf girl to the point where she moves away. Years later, he sets off on a path for redemption...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>

                <!-- Movie 3 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Spirited Away" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.8 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-blue-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-film mr-1 text-xs"></i>
                            MOVIE
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Spirited Away</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Adventure</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Fantasy</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Released:</strong> 2001</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            During her family's move to the suburbs, a sullen 10-year-old girl wanders into a world ruled by gods, witches, and spirits, where humans are changed into beasts...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>

                <!-- Movie 4 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/400x600/0f1116/0f1116" alt="Princess Mononoke" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 right-0 bg-anime-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            8.7 ★
                        </div>
                        <div class="absolute top-0 left-0 bg-blue-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <i class="fas fa-film mr-1 text-xs"></i>
                            MOVIE
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white">Princess Mononoke</h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Adventure</span>
                            <span class="bg-anime-dark-700 text-xs text-gray-300 px-2 py-1 rounded">Fantasy</span>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Released:</strong> 1997</p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            On a journey to find the cure for a Tatarigami's curse, Ashitaka finds himself in the middle of a war between the forest gods and Tatara, a mining colony...
                        </p>
                        <a href="#" class="inline-block mt-4 bg-anime-purple-700 text-white px-4 py-2 rounded hover:bg-anime-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW SECTION: Upcoming Releases Calendar -->
        <div class="mb-12 bg-anime-dark-800/50 rounded-xl p-6 border border-anime-dark-700">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-anime-purple-400">Upcoming Releases</h2>
                <a href="#" class="text-anime-purple-400 hover:text-anime-purple-300 transition-colors flex items-center">
                    Full Calendar
                    <i class="fas fa-chevron-right ml-1 text-sm"></i>
                </a>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- Calendar Item 1 -->
                <div class="flex items-center gap-4 p-3 bg-anime-dark-800/80 rounded-lg border border-anime-dark-700 hover:border-anime-purple-500 transition-all">
                    <div class="flex flex-col items-center justify-center bg-anime-purple-900/50 rounded-lg p-2 min-w-[60px]">
                        <span class="text-lg font-bold text-white">15</span>
                        <span class="text-xs text-gray-300">May</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-white">Demon Slayer: Kimetsu no Yaiba - Ep 8</h3>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1 text-xs"></i>
                            <span>8:30 PM</span>
                        </div>
                    </div>
                </div>

                <!-- Calendar Item 2 -->
                <div class="flex items-center gap-4 p-3 bg-anime-dark-800/80 rounded-lg border border-anime-dark-700 hover:border-anime-purple-500 transition-all">
                    <div class="flex flex-col items-center justify-center bg-anime-purple-900/50 rounded-lg p-2 min-w-[60px]">
                        <span class="text-lg font-bold text-white">16</span>
                        <span class="text-xs text-gray-300">May</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-white">My Hero Academia Season 7 - Ep 5</h3>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1 text-xs"></i>
                            <span>9:00 PM</span>
                        </div>
                    </div>
                </div>

                <!-- Calendar Item 3 -->
                <div class="flex items-center gap-4 p-3 bg-anime-dark-800/80 rounded-lg border border-anime-dark-700 hover:border-anime-purple-500 transition-all">
                    <div class="flex flex-col items-center justify-center bg-anime-purple-900/50 rounded-lg p-2 min-w-[60px]">
                        <span class="text-lg font-bold text-white">17</span>
                        <span class="text-xs text-gray-300">May</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-white">Jujutsu Kaisen Season 3 - Ep 3</h3>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1 text-xs"></i>
                            <span>10:30 PM</span>
                        </div>
                    </div>
                </div>

                <!-- Calendar Item 4 -->
                <div class="flex items-center gap-4 p-3 bg-anime-dark-800/80 rounded-lg border border-anime-dark-700 hover:border-anime-purple-500 transition-all">
                    <div class="flex flex-col items-center justify-center bg-anime-purple-900/50 rounded-lg p-2 min-w-[60px]">
                        <span class="text-lg font-bold text-white">18</span>
                        <span class="text-xs text-gray-300">May</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-white">Chainsaw Man Season 2 - Ep 1</h3>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1 text-xs"></i>
                            <span>7:45 PM</span>
                        </div>
                    </div>
                </div>

                <!-- Calendar Item 5 -->
                <div class="flex items-center gap-4 p-3 bg-anime-dark-800/80 rounded-lg border border-anime-dark-700 hover:border-anime-purple-500 transition-all">
                    <div class="flex flex-col items-center justify-center bg-anime-purple-900/50 rounded-lg p-2 min-w-[60px]">
                        <span class="text-lg font-bold text-white">19</span>
                        <span class="text-xs text-gray-300">May</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-white">Spy x Family Season 3 - Ep 2</h3>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1 text-xs"></i>
                            <span>8:15 PM</span>
                        </div>
                    </div>
                </div>

                <!-- Calendar Item 6 -->
                <div class="flex items-center gap-4 p-3 bg-anime-dark-800/80 rounded-lg border border-anime-dark-700 hover:border-anime-purple-500 transition-all">
                    <div class="flex flex-col items-center justify-center bg-anime-purple-900/50 rounded-lg p-2 min-w-[60px]">
                        <span class="text-lg font-bold text-white">20</span>
                        <span class="text-xs text-gray-300">May</span>
                    </div>
                    <div>
                        <h3 class="font-medium text-white">One Piece - Ep 1062</h3>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1 text-xs"></i>
                            <span>9:30 PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW SECTION: Anime News & Articles -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-anime-purple-400">Anime News & Articles</h2>
                <a href="#" class="text-anime-purple-400 hover:text-anime-purple-300 transition-colors flex items-center">
                    All News
                    <i class="fas fa-chevron-right ml-1 text-sm"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- News Item 1 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/600x300/0f1116/0f1116" alt="Chainsaw Man Season 2 Announcement" class="w-full h-48 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 left-0 bg-green-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold">
                            NEWS
                        </div>
                    </div>
                    <div class="p-4">
                        <span class="text-xs text-gray-400">May 10, 2023</span>
                        <h3 class="text-lg font-semibold my-2 text-white">Chainsaw Man Season 2 Officially Announced with New Trailer</h3>
                        <p class="text-sm text-gray-400 mb-4">
                            MAPPA has officially announced the second season of Chainsaw Man with a stunning new trailer that hints at the upcoming arcs...
                        </p>
                        <a href="#" class="text-anime-purple-400 hover:text-anime-purple-300 text-sm font-medium flex items-center">
                            Read More
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- News Item 2 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/600x300/0f1116/0f1116" alt="Studio Ghibli New Film" class="w-full h-48 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 left-0 bg-green-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold">
                            NEWS
                        </div>
                    </div>
                    <div class="p-4">
                        <span class="text-xs text-gray-400">May 8, 2023</span>
                        <h3 class="text-lg font-semibold my-2 text-white">Studio Ghibli Announces New Film Project for 2024</h3>
                        <p class="text-sm text-gray-400 mb-4">
                            Legendary animation studio Ghibli has announced a new film project set to release in 2024, with Hayao Miyazaki returning as director...
                        </p>
                        <a href="#" class="text-anime-purple-400 hover:text-anime-purple-300 text-sm font-medium flex items-center">
                            Read More
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- News Item 3 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="https://via.placeholder.com/600x300/0f1116/0f1116" alt="Anime Industry Growth" class="w-full h-48 object-cover transition-transform duration-500 hover:scale-110">
                        <div class="absolute top-0 left-0 bg-blue-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold">
                            ARTICLE
                        </div>
                    </div>
                    <div class="p-4">
                        <span class="text-xs text-gray-400">May 5, 2023</span>
                        <h3 class="text-lg font-semibold my-2 text-white">The Growth of Anime Industry: A Global Phenomenon</h3>
                        <p class="text-sm text-gray-400 mb-4">
                            The anime industry has seen unprecedented growth in recent years, with global streaming platforms investing billions in exclusive content...
                        </p>
                        <a href="#" class="text-anime-purple-400 hover:text-anime-purple-300 text-sm font-medium flex items-center">
                            Read More
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- NEW SECTION: Community Reviews -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-anime-purple-400">Community Reviews</h2>
                <a href="#" class="text-anime-purple-400 hover:text-anime-purple-300 transition-colors flex items-center">
                    All Reviews
                    <i class="fas fa-chevron-right ml-1 text-sm"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Review 1 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg p-5 card-hover">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <img src="https://via.placeholder.com/50/0f1116/0f1116" alt="User Avatar" class="w-12 h-12 rounded-full border-2 border-anime-purple-600">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-white">Attack on Titan: Final Season</h3>
                                <div class="flex items-center">
                                    <span class="text-yellow-400 mr-1">★★★★★</span>
                                    <span class="text-sm text-gray-400">5.0</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-300 mb-3">
                                "The final season of Attack on Titan delivers on every level. The animation is stunning, the story reaches its climax in a way that feels both surprising and inevitable. A masterpiece of storytelling."
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-400">By <span class="text-anime-purple-400">AnimeExpert</span> • 3 days ago</span>
                                <div class="flex items-center gap-3">
                                    <button class="text-gray-400 hover:text-anime-purple-400 transition-colors">
                                        <i class="fas fa-thumbs-up mr-1"></i> 128
                                    </button>
                                    <button class="text-gray-400 hover:text-anime-purple-400 transition-colors">
                                        <i class="fas fa-comment mr-1"></i> 24
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review 2 -->
                <div class="bg-anime-dark-800 border border-anime-dark-700 rounded-lg p-5 card-hover">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <img src="https://via.placeholder.com/50/0f1116/0f1116" alt="User Avatar" class="w-12 h-12 rounded-full border-2 border-anime-purple-600">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-white">Demon Slayer: Entertainment District Arc</h3>
                                <div class="flex items-center">
                                    <span class="text-yellow-400 mr-1">★★★★★</span>
                                    <span class="text-sm text-gray-400">4.8</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-300 mb-3">
                                "Ufotable has outdone themselves with the animation in this arc. The fight scenes are breathtaking, and the emotional moments hit hard. The sound design and music elevate every scene."
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-400">By <span class="text-anime-purple-400">SakuraSword</span> • 5 days ago</span>
                                <div class="flex items-center gap-3">
                                    <button class="text-gray-400 hover:text-anime-purple-400 transition-colors">
                                        <i class="fas fa-thumbs-up mr-1"></i> 96
                                    </button>
                                    <button class="text-gray-400 hover:text-anime-purple-400 transition-colors">
                                        <i class="fas fa-comment mr-1"></i> 18
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="mb-12 bg-gradient-to-r from-anime-purple-900/30 to-anime-dark-800/30 rounded-xl p-8 border border-anime-purple-900/50 glow-effect">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-2xl font-bold text-white mb-4">Stay Updated with Anime Releases</h2>
                <p class="text-gray-300 mb-6">
                    Subscribe to our newsletter and never miss updates on your favorite anime series, new releases, and exclusive content.
                </p>
                <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                    <input type="email" placeholder="Your email address" class="flex-1 px-4 py-3 rounded-lg focus:outline-none bg-anime-dark-800/80 border border-anime-dark-700 text-white focus:border-anime-purple-600">
                    <button type="submit" class="bg-anime-purple-700 hover:bg-anime-purple-600 text-white px-6 py-3 rounded-lg transition-colors btn-glow font-medium">
                        Subscribe
                    </button>
                </form>
                <p class="text-gray-400 text-sm mt-4">
                    By subscribing, you agree to our Privacy Policy and consent to receive updates from our company.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-anime-dark-950 border-t border-anime-dark-800 pt-12 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold gradient-text mb-4">Anime<span class="text-white">Verse</span></h3>
                    <p class="text-gray-400 mb-4">Your ultimate destination for anime content, reviews, and community discussions.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">
                            <i class="fab fa-facebook text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">
                            <i class="fab fa-discord text-lg"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Discover</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Genres</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Movies</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">News</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Genres</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Action</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Adventure</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Comedy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Drama</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Fantasy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-anime-purple-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-anime-dark-800 pt-6 text-center">
                <p class="text-gray-500 text-sm">
                    &copy; 2023 AnimeVerse. All rights reserved. Not affiliated with any anime production companies.
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Carousel -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carouselItems = document.querySelectorAll('.carousel-item');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const indicators = document.querySelectorAll('.carousel-indicator');

            let currentIndex = 0;
            const itemCount = carouselItems.length;

            function updateCarousel() {
                carouselItems.forEach((item, index) => {
                    if (index === currentIndex) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });

                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.add('active');
                        indicator.style.backgroundColor = 'white';
                    } else {
                        indicator.classList.remove('active');
                        indicator.style.backgroundColor = 'rgba(255, 255, 255, 0.5)';
                    }
                });
            }

            function goToSlide(index) {
                currentIndex = index;
                updateCarousel();
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % itemCount;
                updateCarousel();
            }

            function prevSlide() {
                currentIndex = (currentIndex - 1 + itemCount) % itemCount;
                updateCarousel();
            }

            // Event listeners
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);

            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    goToSlide(index);
                });
            });

            // Auto slide every 5 seconds
            setInterval(nextSlide, 5000);

            // Initialize
            updateCarousel();
        });
    </script>
</body>
</html>