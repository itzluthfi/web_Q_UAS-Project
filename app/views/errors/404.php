<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
    body {
        background-color: #1a202c;
        color: #f7fafc;
        font-family: Arial, sans-serif;
        text-align: center;
        padding: 100px;
    }

    h1 {
        font-size: 72px;
        margin-bottom: 20px;
    }

    p {
        font-size: 24px;
        margin-bottom: 40px;
    }

    a {
        color: #63b3ed;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <h1>404</h1>
    <p>Halaman yang kamu cari tidak ditemukan.</p>
    <a href="<?= route('/') ?>">Kembali ke Beranda</a>
</body>

</html>