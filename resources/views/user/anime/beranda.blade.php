@extends('layouts.app')

@section('title', 'Home - AnimeVerse')


@push('styles')
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
@endpush
@section('content')
<body class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100">
    <div class="container mx-auto px-4 py-6">
      
        <!-- Alert Message -->
        <?php if (!empty($_SESSION['error_message'])): ?>
        <div
            class="p-3 bg-red-900/50 border-l-4 border-red-500 text-red-200 flex items-center rounded-r mb-4 max-w-2xl mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <span><?= htmlspecialchars($_SESSION['error_message']) ?></span>
        </div>
        <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success_message'])): ?>
        <div
            class="p-3 bg-green-900/50 border-l-4 border-green-500 text-green-200 flex items-center rounded-r mb-4 max-w-2xl mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            <span><?= htmlspecialchars($_SESSION['success_message']) ?></span>
        </div>
        <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!-- Carousel Banner Section -->
        <div class="relative overflow-hidden mb-12 rounded-xl glow-effect">
            <!-- Carousel Container -->
            <div class="carousel-container flex transition-transform duration-500 ease-in-out">
                <?php foreach (array_slice($animeUpcomings, 0, 5) as $index => $anime): ?>
                <!-- Carousel Item -->
                <div class="carousel-item w-full flex-shrink-0 relative">
                    <img src="<?= $anime['images']['jpg']['large_image_url'] ?? 'https://via.placeholder.com/800x400?text=No+Image' ?>"
                        alt="<?= htmlspecialchars($anime['title']) ?>"
                        class="w-full h-[400px] object-cover brightness-50">
                    <div
                        class="absolute inset-0 flex flex-col justify-end p-8 bg-gradient-to-t from-black/80 to-transparent">
                        <span
                            class="bg-red-700 text-white px-3 py-1 rounded-full text-sm font-medium inline-block mb-3 w-max">
                            <?=  'Upcoming' ?>
                        </span>
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-2">
                            <?= htmlspecialchars($anime['title']) ?></h2>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <?php foreach (array_slice($anime['genres'] ?? [], 0, 2) as $genre): ?>
                            <span
                                class="bg-gray-700 text-xs text-gray-300 px-2 py-1 rounded"><?= htmlspecialchars($genre['name']) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <p class="text-gray-200 mb-4 max-w-2xl">
                            <?= htmlspecialchars(substr($anime['synopsis'] ?? 'No synopsis available', 0, 150)) ?>...
                        </p>
                        <div class="flex space-x-4">
                            <a href="<?= route('anime.show', ['id' => $anime['mal_id']]) ?>"
                                class="bg-purple-700 hover:bg-purple-600 text-white px-6 py-2 rounded-lg transition-all btn-glow flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                        clip-rule="evenodd" />
                                </svg>
                                Details
                            </a>
                            <a href="#"
                                class="border border-gray-400 hover:border-purple-500 text-white px-6 py-2 rounded-lg transition-all flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                                Add to List
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Carousel Controls -->
            <button
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-purple-700 text-white p-2 rounded-full transition-colors z-10"
                id="prevBtn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-purple-700 text-white p-2 rounded-full transition-colors z-10"
                id="nextBtn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Carousel Indicators -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
                <?php foreach (array_slice($animeUpcomings, 0, 5) as $index => $anime): ?>
                <button
                    class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors carousel-indicator <?= $index === 0 ? 'active' : '' ?>"
                    data-index="<?= $index ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Anime Studios Section (Replacing Categories) -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-400">Top Anime Studios</h2>
                <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors flex items-center">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <?php 
                $studios = [
                    ['name' => 'Studio Ghibli', 'icon' => 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z', 'count' => 24],
                    ['name' => 'MAPPA', 'icon' => 'M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z', 'count' => 42],
                    ['name' => 'Kyoto Animation', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'count' => 38],
                    ['name' => 'Ufotable', 'icon' => 'M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z', 'count' => 29],
                    ['name' => 'Wit Studio', 'icon' => 'M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z', 'count' => 31],
                    ['name' => 'Bones', 'icon' => 'M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'count' => 45]
                ];
                
                foreach ($studios as $studio): ?>
                <a href="{{ route('anime.showByStudio') }}"
                    class="bg-gray-800/80 hover:bg-gray-700/80 border border-gray-700 rounded-lg p-4 text-center transition-all card-hover">
                    <div
                        class="bg-purple-700/20 rounded-full p-3 mx-auto w-16 h-16 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="<?= $studio['icon'] ?>" />
                        </svg>
                    </div>
                    <h3 class="font-medium text-white"><?= $studio['name'] ?></h3>
                    <p class="text-xs text-gray-400 mt-1"><?= $studio['count'] ?> titles</p>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Top Rated Anime Section (New Section) -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-400">Top Rated Anime</h2>
                <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors flex items-center">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            
                @foreach (array_slice($animeTopRated, 0, 6) as $anime)
                    <div class="bg-gray-800/80 border border-gray-700 rounded-lg p-4 flex items-center gap-4 card-hover">
                        <div class="flex-shrink-0 relative">
                            <img src="{{ $anime['images']['jpg']['image_url'] }}" alt="{{ $anime['title'] }}" class="w-20 h-28 object-cover rounded">
                            <div class="absolute -top-2 -left-2 bg-purple-700 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">
                                {{ $anime['rank'] ?? '-' }}
                            </div>
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-semibold text-white text-lg">{{ $anime['title'] }}</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-yellow-400 font-bold ml-1">{{ $anime['score'] ?? '-' }}</span>
                                </div>
                                <span class="text-gray-400 text-sm">{{ $anime['year'] ?? 'N/A' }}</span>
                            </div>
                            <a href="{{ $anime['url'] }}" target="_blank" class="text-purple-400 hover:text-purple-300 text-sm mt-2 inline-block">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Anime This Season Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-400">Anime This Season</h2>
                <a href="{{ route('anime.viewAllByLabel', ['label' => 'CurrentSeason']) }} " class= "text-purple-400 hover:text-purple-300 transition-colors flex items-center">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach (array_slice($animeCurrentSeasonal, 0, 4) as $anime): ?>
                <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="<?= $anime['images']['jpg']['large_image_url'] ?? 'https://via.placeholder.com/400x600?text=No+Image' ?>"
                            alt="<?= htmlspecialchars($anime['title']) ?>"
                            class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div
                            class="absolute top-0 right-0 bg-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            <?= number_format($anime['score'] ?? 0, 1) ?> ★
                        </div>
                        <div
                            class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                    clip-rule="evenodd" />
                            </svg>
                            NEW
                        </div>
                        <?php if (($anime['airing'] ?? false) || ($anime['status'] === 'Currently Airing')): ?>
                        <div
                            class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                    clip-rule="evenodd" />
                            </svg>
                            NEW
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white"><?= htmlspecialchars($anime['title']) ?></h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <?php foreach (array_slice($anime['genres'] ?? [], 0, 2) as $genre): ?>
                            <span
                                class="bg-gray-700 text-xs text-gray-300 px-2 py-1 rounded"><?= htmlspecialchars($genre['name']) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Airing:</strong>
                            <?= $anime['season'] ?? 'Unknown' ?> <?= $anime['year'] ?? '' ?></p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            <?= htmlspecialchars(substr($anime['synopsis'] ?? 'No synopsis available', 0, 100)) ?>...
                        </p>
                        <a href="<?= route('anime.show', ['id' => $anime['mal_id']]) ?>"
                            class="inline-block mt-4 bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>


        <!-- POPULAR This Season Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-400">Popular This Season</h2>
                <a href="{{   route('anime.viewAllByLabel', ['label' => 'Popular']) }}"
                    class="text-purple-400 hover:text-purple-300 transition-colors flex items-center">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach (array_slice($animePopular, 0, 4) as $anime): ?>
                <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden">
                        <img src="<?= $anime['images']['jpg']['large_image_url'] ?? 'https://via.placeholder.com/400x600?text=No+Image' ?>"
                            alt="<?= htmlspecialchars($anime['title']) ?>"
                            class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                        <div
                            class="absolute top-0 right-0 bg-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                            <?= number_format($anime['score'] ?? 0, 1) ?> ★
                        </div>
                        <div
                            class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                    clip-rule="evenodd" />
                            </svg>
                            POPULAR
                        </div>
                        <?php if (($anime['airing'] ?? false) || ($anime['status'] === 'Currently Airing')): ?>
                        <div
                            class="absolute top-0 left-0 bg-red-600 text-white px-2 py-1 m-2 rounded-r-lg text-xs font-bold flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                    clip-rule="evenodd" />
                            </svg>
                            NEW
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2 text-white"><?= htmlspecialchars($anime['title']) ?></h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <?php foreach (array_slice($anime['genres'] ?? [], 0, 2) as $genre): ?>
                            <span
                                class="bg-gray-700 text-xs text-gray-300 px-2 py-1 rounded"><?= htmlspecialchars($genre['name']) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <p class="text-sm text-gray-400 mb-3"><strong>Airing:</strong>
                            <?= $anime['season'] ?? 'Unknown' ?> <?= $anime['year'] ?? '' ?></p>
                        <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                            <?= htmlspecialchars(substr($anime['synopsis'] ?? 'No synopsis available', 0, 100)) ?>...
                        </p>
                        <a href="<?= route('anime.show', ['id' => $anime['mal_id']]) ?>"
                            class="inline-block mt-4 bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-600 transition-colors btn-glow">
                            Details
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        

        <!-- Upcoming Releases Calendar (New Section) -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-400">Upcoming Releases</h2>
                <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors flex items-center">
                    Full Calendar
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="bg-gray-800/80 border border-gray-700 rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php 
                    $upcomingDates = [
                        ['date' => 'July 15, 2023', 'day' => 'Saturday', 'releases' => [
                            ['title' => 'My Hero Academia Season 7', 'time' => '11:00 AM', 'type' => 'TV'],
                            ['title' => 'Demon Slayer: Hashira Training Arc', 'time' => '1:30 PM', 'type' => 'TV'],
                        ]],
                        ['date' => 'July 20, 2023', 'day' => 'Thursday', 'releases' => [
                            ['title' => 'Jujutsu Kaisen Season 2', 'time' => '10:00 AM', 'type' => 'TV'],
                            ['title' => 'One Piece Episode 1071', 'time' => '9:00 PM', 'type' => 'TV'],
                            ['title' => 'Dragon Ball: Daima', 'time' => '7:30 PM', 'type' => 'TV'],
                        ]],
                        ['date' => 'July 25, 2023', 'day' => 'Tuesday', 'releases' => [
                            ['title' => 'Spy x Family Season 2', 'time' => '5:00 PM', 'type' => 'TV'],
                            ['title' => 'Chainsaw Man Movie', 'time' => '8:00 PM', 'type' => 'Movie'],
                        ]],
                    ];
                    
                    foreach ($upcomingDates as $dateInfo): ?>
                    <div class="border border-gray-700 rounded-lg p-4">
                        <div class="mb-4 border-b border-gray-700 pb-2">
                            <h3 class="text-lg font-semibold text-white"><?= $dateInfo['date'] ?></h3>
                            <p class="text-gray-400 text-sm"><?= $dateInfo['day'] ?></p>
                        </div>
                        <div class="space-y-3">
                            <?php foreach ($dateInfo['releases'] as $release): ?>
                            <div class="flex items-start gap-3">
                                <div class="bg-purple-900/30 text-purple-400 px-2 py-1 rounded text-xs font-medium w-14 text-center">
                                    <?= $release['type'] ?>
                                </div>
                                <div>
                                    <h4 class="text-white font-medium"><?= $release['title'] ?></h4>
                                    <p class="text-gray-400 text-xs"><?= $release['time'] ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Anime News Section (New Section) -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-400">Latest Anime News</h2>
                <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors flex items-center">
                    All News
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php 
                $newsItems = [
                    [
                        'title' => 'Attack on Titan Final Season Part 3 Announces Release Date',
                        'date' => 'June 28, 2023',
                        'image' => 'https://via.placeholder.com/400x225?text=AOT+News',
                        'excerpt' => 'The highly anticipated conclusion to the epic saga has finally received an official release date...'
                    ],
                    [
                        'title' => 'Studio Ghibli Announces New Film Project',
                        'date' => 'June 25, 2023',
                        'image' => 'https://via.placeholder.com/400x225?text=Ghibli+News',
                        'excerpt' => 'Legendary animation studio announces their next feature film project with returning director...'
                    ],
                    [
                        'title' => 'One Piece Manga Enters Final Saga',
                        'date' => 'June 20, 2023',
                        'image' => 'https://via.placeholder.com/400x225?text=One+Piece+News',
                        'excerpt' => 'After 25 years of serialization, Eiichiro Oda confirms One Piece is entering its final saga...'
                    ],
                ];
                
                foreach ($newsItems as $news): ?>
                <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden shadow-lg card-hover">
                    <div class="relative overflow-hidden h-48">
                        <img src="<?= $news['image'] ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                    </div>
                    <div class="p-4">
                        <p class="text-gray-400 text-sm mb-2"><?= $news['date'] ?></p>
                        <h3 class="text-xl font-semibold mb-2 text-white"><?= htmlspecialchars($news['title']) ?></h3>
                        <p class="text-gray-300 text-sm mb-4"><?= $news['excerpt'] ?></p>
                        <a href="#" class="text-purple-400 hover:text-purple-300 font-medium flex items-center">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div
            class="mb-12 bg-gradient-to-r from-purple-900/30 to-gray-800/30 rounded-xl p-8 border border-purple-900/50 glow-effect">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-2xl font-bold text-white mb-4">Stay Updated with Anime Releases</h2>
                <p class="text-gray-300 mb-6">Subscribe to our newsletter and never miss updates on your favorite anime
                    series, new releases, and exclusive content.</p>
                <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                    <input type="email" placeholder="Your email address"
                        class="input-dark flex-1 px-4 py-3 rounded-lg focus:outline-none">
                    <button type="submit"
                        class="bg-purple-700 hover:bg-purple-600 text-white px-6 py-3 rounded-lg transition-colors btn-glow font-medium">
                        Subscribe
                    </button>
                </form>
                <p class="text-gray-400 text-sm mt-4">By subscribing, you agree to our Privacy Policy and consent to
                    receive updates from our company.</p>
            </div>
        </div>
        @endsection
        @push('scripts')

        <!-- JavaScript for Carousel -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carouselContainer = document.querySelector('.carousel-container');
            const carouselItems = document.querySelectorAll('.carousel-item');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const indicators = document.querySelectorAll('.carousel-indicator');

            let currentIndex = 0;
            const itemCount = carouselItems.length;

            // Set initial width
            carouselItems.forEach(item => {
                item.style.width = '100%';
            });

            function updateCarousel() {
                carouselContainer.style.transform = `translateX(-${currentIndex * 100}%)`;

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
@endpush
</body>