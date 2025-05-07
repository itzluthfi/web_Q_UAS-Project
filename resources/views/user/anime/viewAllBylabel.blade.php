@include('components.header')

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



<!-- <h1 class="text-3xl font-bold text-center text-indigo-600 mb-8">Top Anime</h1> -->

<!-- Alert Message -->

<body class="min-h-screen bg-gradient-to-br from-gray-900 to-black text-gray-100">
    @include('components.navbar')

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-center text-white mb-8">
            <?php
            if (isset($query) && $query) {
                echo $jmlResult . ' hasil ditemukan untuk pencarian: "' . htmlspecialchars($query) . '"';
            } else {
                echo 'Daftar Anime ' . ucfirst($label);
            }
            ?>
        </h1>



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


        <!-- Anime Grid -->
        <?php if (!empty($animeList)): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($animeList as $anime): ?>
            <div class="bg-gray-800 border border-gray-700 rounded-lg overflow-hidden shadow-lg card-hover">
                <div class="relative overflow-hidden">
                    <img src="<?= htmlspecialchars($anime['images']['jpg']['image_url']) ?>"
                        alt="<?= htmlspecialchars($anime['title']) ?>"
                        class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
                    <div
                        class="absolute top-0 right-0 bg-purple-700 text-white px-2 py-1 m-2 rounded text-xs font-bold">
                        <?= $anime['score'] ?> ★
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2 text-white"><?= htmlspecialchars($anime['title']) ?>
                    </h3>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="bg-gray-700 text-xs text-gray-300 px-2 py-1 rounded">
                            <?= $anime['status'] ?>
                        </span>
                        <span class="bg-gray-700 text-xs text-gray-300 px-2 py-1 rounded">
                            <?= $anime['episodes'] ?> Episode
                        </span>
                    </div>
                    <p class="text-sm text-gray-400 mb-3"><strong>Tayang:</strong>
                        <?= $anime['aired']['string'] ?></p>
                    <p class="text-sm text-gray-400 mt-2 h-16 overflow-hidden">
                        <?= htmlspecialchars(substr($anime['synopsis'] ?? 'No synopsis available', 0, 100)) ?>...</p>
                    <a href="<?= route('anime.show', ['id' => $anime['mal_id']]) ?>"
                        class="inline-block mt-4 bg-purple-700 text-white px-4 py-2 rounded hover:bg-purple-600 transition-colors btn-glow">
                        Lihat Detail
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-8 text-center max-w-2xl mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-600 mb-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-gray-400">Gagal mengambil data anime dari API.</p>
            <p class="text-gray-500 text-sm mt-2">Silakan coba lagi nanti atau periksa koneksi internet Anda.
            </p>
        </div>
        <?php endif; ?>
    </div>
</body>
@include('components.footer')
