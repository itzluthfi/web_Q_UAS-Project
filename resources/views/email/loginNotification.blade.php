<!DOCTYPE html>
<html>

<head>
    <title>Notifikasi Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        img {
            display: block;
            width: 500px;
            /* Diperbesar dari 100px */
            height: auto;
            margin: 20px 0;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        p {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h2>Halo, {{ $user->username }} 👋</h2>

    <img src="https://i.imgur.com/8Pv8X78.png" alt="Logo" />

    <p>Kami ingin memberitahu bahwa Anda telah berhasil login ke akun Anda sebagai <strong>{{ $user->username }}</strong>.</p>

    <p>Untuk mulai menjelajahi aplikasi, silakan klik tombol di bawah ini:</p>

    <a href="{{ url('/') }}" class="button">Kunjungi Aplikasi</a>

    <p class="footer">Terima kasih telah menggunakan layanan kami.<br />Jika ini bukan Anda, harap segera hubungi tim support.</p>
</body>

</html>
