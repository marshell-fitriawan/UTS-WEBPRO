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
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Login Admin Gudang</h2>
<?php if ($msg): ?>
<div class="message error"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>
<form action="../aksi/login.php" method="post">
    <label>Email</label>
    <input type="email" name="email" required>
    
    <label>Password</label>
    <input type="password" name="password" required>
    
    <button type="submit">Login</button>
</form>
<p class="mt-20">
    <a href="forgot_form.php">Lupa password?</a> | 
    <a href="register_form.php">Daftar</a>
</p>

<hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">
<div style="background-color: #f9f9f9; padding: 15px; border-radius: 4px; border-left: 4px solid #666;">
    <strong>Testing:</strong><br>
    <strong>Email:</strong> admin1@example.com<br>
    <strong>Password:</strong> admin123
</div>
</div>
</body>
</html>
