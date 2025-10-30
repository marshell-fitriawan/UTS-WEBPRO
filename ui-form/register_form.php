<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Register Admin Gudang</h2>
<?php if ($msg): ?>
<div class="message <?php echo (stripos($msg, 'berhasil') !== false || stripos($msg, 'success') !== false) ? 'success' : 'error'; ?>">
    <?php echo htmlspecialchars($msg); ?>
</div>
<?php endif; ?>
<form action="../aksi/register.php" method="post" id="registerForm">
    <label>Nama lengkap</label>
    <input type="text" name="name" required>
    
    <label>Email</label>
    <input type="email" name="email" required>
    
    <label>Password (min 6)</label>
    <input type="password" name="password" id="password" minlength="6" required>
    
    <label>Konfirmasi Password</label>
    <input type="password" name="password_confirm" id="password_confirm" minlength="6" required>
    
    <button type="submit">Daftar</button>
</form>
<p class="mt-20"><a href="login_form.php">Sudah punya akun? Login di sini</a></p>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    var confirm = document.getElementById('password_confirm').value;
    
    if (password !== confirm) {
        e.preventDefault();
        alert('Password dan konfirmasi password tidak cocok!');
        return false;
    }
});
</script>
</body>
</html>
