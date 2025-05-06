@include('templates.header')

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
</style>

<body class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100">
    @include('templates.navbar')
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
                <?php foreach (array_slice($animeRandoms, 0, 3) as $index => $anime): ?>
                <!-- Carousel Item -->
                <div class="carousel-item w-full flex-shrink-0 relative">
                    <img src="<?= $anime['images']['jpg']['large_image_url'] ?? 'https://via.placeholder.com/800x400?text=No+Image' ?>"
                        alt="<?= htmlspecialchars($anime['title']) ?>"
                        class="w-full h-[400px] object-cover brightness-50">
                    <div
                        class="absolute inset-0 flex flex-col justify-end p-8 bg-gradient-to-t from-black/80 to-transparent">
                        <span
                            class="bg-red-700 text-white px-3 py-1 rounded-full text-sm font-medium inline-block mb-3 w-max">
                            <?= $index === 0 ? 'Trending' : ($index === 1 ? 'New Season' : 'Popular') ?>
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
                <?php foreach (array_slice($animeTop, 0, 3) as $index => $anime): ?>
                <button
                    class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors carousel-indicator <?= $index === 0 ? 'active' : '' ?>"
                    data-index="<?= $index ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-400">Browse Categories</h2>
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
                $categories = [
                    ['name' => 'Action', 'icon' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['name' => 'Comedy', 'icon' => 'M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5'],
                    ['name' => 'Romance', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                    ['name' => 'Sci-Fi', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['name' => 'Fantasy', 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                    ['name' => 'Slice of Life', 'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z']
                ];
                
                foreach ($categories as $category): ?>
                <a href="#"
                    class="bg-gray-800/80 hover:bg-gray-700/80 border border-gray-700 rounded-lg p-4 text-center transition-all card-hover">
                    <div
                        class="bg-purple-700/20 rounded-full p-3 mx-auto w-16 h-16 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="<?= $category['icon'] ?>" />
                        </svg>
                    </div>
                    <h3 class="font-medium text-white"><?= $category['name'] ?></h3>
                    <p class="text-xs text-gray-400 mt-1"><?= rand(400, 1200) ?> titles</p>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Anime This Season Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-400">Anime This Season</h2>
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
                <a href="<?= route('anime.viewAllByLabel', ['label' => 'Popular']) ?>"
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

</body>
@include('templates.footer')