<?php
session_start();
if (isset($_SESSION['user_id'])) header('Location: dashboard.php');
$token = $_GET['token'] ?? '';
if (!$token) { echo "Token tidak ditemukan"; exit; }
$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reset Password</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Ubah Password</h2>
<?php if ($msg): ?>
<div class="message error"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>
<form action="../aksi/reset_password.php" method="post" id="resetForm">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    
    <label>Password baru (min 6 karakter)</label>
    <input type="password" name="password" id="password" minlength="6" required>
    
    <label>Konfirmasi Password</label>
    <input type="password" name="password_confirm" id="password_confirm" minlength="6" required>
    
    <button type="submit">Simpan</button>
</form>
<p class="mt-20"><a href="login_form.php">Kembali ke Login</a></p>
</div>

<script>
document.getElementById('resetForm').addEventListener('submit', function(e) {
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
