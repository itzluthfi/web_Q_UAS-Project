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
            width: 500px; /* Diperbesar dari 100px */
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
    <p>Haii, {{ $user->username }}</p>

    <img src="https://i.imgur.com/8Pv8X78.png" alt="Logo" />

    <p>Anda telah berhasil login sebagai <strong>{{ $user->username }}</strong></p>

    <p><a href="{{ url('/') }}">Kunjungi Aplikasi</a></p>

    <p>Terima kasih telah menggunakan layanan kami!</p>
</body>
</html>