<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Login</title>
</head>
<body>
    <p>Haii, {{ $user->username }}</p>
    <img src="https://i.pinimg.com/736x/09/1e/44/091e44bec7161084995b8a5dd2846be7.jpg" alt="Logo" style="width:100px; height:auto;">
    <p>Anda telah berhasil login sebagai {{ $user->username }}</p>
    <p><a href="{{ url('/') }}">Kunjungi Aplikasi</a></p>
    <p>Terima kasih telah menggunakan layanan kami!</p>
</body>
</html>
