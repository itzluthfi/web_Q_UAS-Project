<?php include 'app/views/templates/header.php'; ?>

<h1>Top Anime</h1>

<!-- Tombol Login -->
<div style="text-align: right; margin-bottom: 20px;">
    <a href="./login" class="login-button">Login</a>
</div>

<?php if (!empty($animeList)): ?>
<ul>
    <?php foreach ($animeList as $anime): ?>
    <li>
        <h3><?= htmlspecialchars($anime['title']) ?></h3>
        <img src="<?= htmlspecialchars($anime['images']['jpg']['image_url']) ?>"
            alt="<?= htmlspecialchars($anime['title']) ?>" width="100">
        <p>Score: <?= $anime['score'] ?></p>
    </li>
    <?php endforeach; ?>
</ul>
<?php else: ?>
<p>Gagal mengambil data anime dari API.</p>
<?php endif; ?>

<?php include 'app/views/templates/footer.php'; ?>