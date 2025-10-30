<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login_form.php');
include '../connect.php';
$uid = $_SESSION['user_id'];
$res = $conn->query("SELECT id, username, full_name FROM users WHERE id = " . intval($uid) . " LIMIT 1");
$user = $res->fetch_assoc();
$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Profil</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<nav>
    <a href="dashboard.php">← Kembali ke Dashboard</a>
</nav>
<h2>Profil Pengguna</h2>
<?php if ($msg): ?>
<div class="message <?php echo (stripos($msg, 'berhasil') !== false || stripos($msg, 'success') !== false) ? 'success' : 'error'; ?>">
    <?php echo htmlspecialchars($msg); ?>
</div>
<?php endif; ?>

<h3>Informasi Akun</h3>
<form action="../crud-table/user_update.php" method="post">
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
    
    <label>Nama lengkap</label>
    <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
    
    <label>Email (username)</label>
    <input type="email" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    
    <button type="submit">Simpan Perubahan</button>
</form>

<hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">

<h3>Ubah Password</h3>
<form action="../aksi/user_change_password.php" method="post">
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
    
    <label>Password saat ini</label>
    <input type="password" name="current_password" required>
    
    <label>Password baru (min 6 karakter)</label>
    <input type="password" name="new_password" minlength="6" required>
    
    <button type="submit">Ubah Password</button>
</form>
</div>
</body>
</html>
