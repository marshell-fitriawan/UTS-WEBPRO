<?php
// ui-form/dashboard.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login_form.php');
    exit;
}
$user_name = $_SESSION['user_name'] ?? 'Admin';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard - Admin Gudang</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <nav>
    <strong>Selamat datang, <?= htmlspecialchars($user_name) ?></strong>
    <a href="product_form.php">+ Tambah Produk</a>
    <a href="profile.php">Profil</a>
    <a href="../aksi/logout.php" style="float:right;color:#c00;">Logout</a>
  </nav>

  <h3>Daftar Produk</h3>
  <?php
    include __DIR__ . '/product_list.php';
  ?>
</div>
</body>
</html>
