<?php 
include 'app/views/templates/header.php'; 

?>

<?php if (!empty($_SESSION['error_message'])): ?>
<div style="color: red;"><?= htmlspecialchars($_SESSION['error_message']) ?></div>
<?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['success_message'])): ?>
<div style="color: green;"><?= htmlspecialchars($_SESSION['success_message']) ?></div>
<?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<h1>Login</h1>
<form action="./login/submit" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<p>Belum punya akun? <a href="./register">Daftar di sini</a></p>

<?php include 'app/views/templates/footer.php'; ?>