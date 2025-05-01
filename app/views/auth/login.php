<?php include 'app/views/templates/header.php'; ?>

<h1>Login</h1>
<form action="./login/submit" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<p>Belum punya akun? <a href="./register">Daftar di sini</a></p>

<?php include 'app/views/templates/footer.php'; ?>