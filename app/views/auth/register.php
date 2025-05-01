<?php include 'app/views/templates/header.php'; ?>

<h1>Registrasi</h1>
<form action="./register/submit" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit">Daftar</button>
</form>

<p>Sudah punya akun? <a href="./login">Login di sini</a></p>

<?php include 'app/views/templates/footer.php'; ?>