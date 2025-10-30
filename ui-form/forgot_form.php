<?php
session_start();
if (isset($_SESSION['user_id'])) header('Location: dashboard.php');
$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Forgot Password</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Reset Password</h2>
<?php if ($msg): ?>
<div class="message <?php echo (stripos($msg, 'berhasil') !== false || stripos($msg, 'terkirim') !== false) ? 'success' : 'error'; ?>">
    <?php echo htmlspecialchars($msg); ?>
</div>
<?php endif; ?>
<form action="../aksi/forgot_password.php" method="post">
    <label>Email</label>
    <input type="email" name="email" required>
    
    <button type="submit">Kirim tautan reset</button>
</form>
<p class="mt-20"><a href="login_form.php">Kembali ke Login</a></p>
</div>
</body>
</html>
