<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login_form.php');
include '../connect.php';
$id = $_GET['id'] ?? '';
$product = null;
if ($id) {
    $res = $conn->query("SELECT * FROM products WHERE id = '" . $conn->real_escape_string($id) . "' LIMIT 1");
    $product = $res->fetch_assoc();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $product ? 'Edit' : 'Tambah'; ?> Produk</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<nav>
    <a href="dashboard.php">← Kembali ke Dashboard</a>
</nav>
<h2><?php echo $product ? 'Edit' : 'Tambah'; ?> Produk</h2>
<form action="../aksi/product_save.php" method="post">
    <input type="hidden" name="id" value="<?php echo $product['id'] ?? ''; ?>">
    
    <label>Nama</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
    
    <label>Deskripsi</label>
    <textarea name="description"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
    
    <label>Harga</label>
    <input type="number" step="0.01" name="price" value="<?php echo $product['price'] ?? '0.00'; ?>">
    
    <label>Stock</label>
    <input type="number" name="stock" value="<?php echo $product['stock'] ?? '0'; ?>">
    
    <button type="submit"><?php echo $product ? 'Update' : 'Simpan'; ?></button>
</form>
</div>
</body>
</html>
