<?php include 'app/views/templates/header.php'; ?>

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-center text-indigo-600 mb-8">Top Anime</h1>

    <!-- Alert Message -->
    <?php if (!empty($_SESSION['error_message'])): ?>
    <div class="text-red-600 text-center mb-4"><?= htmlspecialchars($_SESSION['error_message']) ?></div>
    <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])): ?>
    <div class="text-green-600 text-center mb-4"><?= htmlspecialchars($_SESSION['success_message']) ?></div>
    <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <!-- Login Button -->
    <div class="flex justify-end mb-4">
        <a href="./login" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Login</a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="" class="mb-6 flex justify-center">
        <input type="text" name="q" placeholder="Cari anime..."
            class="border border-gray-300 rounded-l px-4 py-2 w-1/2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r hover:bg-indigo-700">Cari</button>
    </form>

    <!-- Anime Grid -->
    <?php if (!empty($animeList)): ?>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($animeList as $anime): ?>
        <div class="bg-white shadow-md rounded overflow-hidden">
            <img src="<?= htmlspecialchars($anime['images']['jpg']['image_url']) ?>"
                alt="<?= htmlspecialchars($anime['title']) ?>" class="w-full h-56 object-cover">
            <div class="p-4">
                <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($anime['title']) ?></h3>
                <p class="text-sm text-gray-700 mb-1"><strong>Score:</strong> <?= $anime['score'] ?></p>
                <p class="text-sm text-gray-700 mb-1"><strong>Status:</strong> <?= $anime['status'] ?></p>
                <p class="text-sm text-gray-700 mb-1"><strong>Episode:</strong> <?= $anime['episodes'] ?></p>
                <p class="text-sm text-gray-700 mb-1"><strong>Tayang:</strong> <?= $anime['aired']['string'] ?></p>
                <p class="text-sm text-gray-600 mt-2"><?= substr($anime['synopsis'], 0, 120) ?>...</p>
                <a href="/anime-list-uas/anime/show/<?= $anime['mal_id'] ?>"
                    class="inline-block mt-4 bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                    Lihat Detail
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p class="text-center text-gray-600">Gagal mengambil data anime dari API.</p>
    <?php endif; ?>
</div>

<?php include 'app/views/templates/footer.php'; ?>