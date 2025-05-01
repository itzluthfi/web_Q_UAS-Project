<?php include 'app/views/templates/header.php'; ?>

<body class="bg-gray-100 font-sans">
    <div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden p-6">
        <!-- Title and Image -->
        <div class="md:flex">
            <img class="w-64 h-auto rounded mb-4 md:mb-0 md:mr-6"
                src="<?= htmlspecialchars($anime['images']['jpg']['image_url']) ?>"
                alt="<?= htmlspecialchars($anime['title']) ?>">

            <div class="flex-1">
                <h1 class="text-3xl font-bold text-indigo-600 mb-2"><?= htmlspecialchars($anime['title']) ?></h1>
                <p class="text-gray-700 mb-1"><strong>Skor:</strong> <?= htmlspecialchars($anime['score']) ?></p>
                <p class="text-gray-700 mb-1"><strong>Status:</strong> <?= htmlspecialchars($anime['status']) ?></p>
                <p class="text-gray-700 mb-1"><strong>Jumlah Episode:</strong>
                    <?= htmlspecialchars($anime['episodes']) ?></p>
                <p class="text-gray-700 mb-1"><strong>Tayang:</strong>
                    <?= htmlspecialchars($anime['aired']['string']) ?></p>
                <p class="text-gray-700 mt-4"><?= htmlspecialchars($anime['synopsis']) ?></p>

                <!-- Tombol Favorite -->
                <button class="mt-4 px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                    ⭐ Tambahkan ke Favorite
                </button>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-6">
            <a href="/anime-list-uas/"
                class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                ← Kembali ke List
            </a>
        </div>

        <!-- Komentar Section -->
        <div class="mt-10">
            <h2 class="text-2xl font-semibold mb-4">Komentar</h2>

            <!-- Form Komentar -->
            <form method="post" action="#" class="mb-6">
                <textarea name="comment" rows="3" placeholder="Tulis komentar kamu..."
                    class="w-full border border-gray-300 p-3 rounded mb-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Kirim
                    Komentar</button>
            </form>

            <!-- List Komentar Dummy -->
            <div class="space-y-4">
                <div class="p-4 bg-gray-100 rounded shadow">
                    <p class="font-semibold">User123</p>
                    <p>Keren banget animenya!</p>
                </div>
                <div class="p-4 bg-gray-100 rounded shadow">
                    <p class="font-semibold">OtakuBoys</p>
                    <p>Soundtrack dan animasinya mantap 🔥</p>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include 'app/views/templates/footer.php'; ?>