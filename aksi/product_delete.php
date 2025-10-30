<?php
session_start();

// Cek login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../ui-form/login_form.php');
    exit;
}

// Include koneksi & fungsi CRUD product
include __DIR__ . '/../connect.php';
include __DIR__ . '/../crud-table/crud_product.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? '';

if (empty($id)) {
    header('Location: ../ui-form/product_list.php?msg=' . urlencode('ID produk tidak ditemukan'));
    exit;
}

// 
$id_safe = $conn->real_escape_string($id);

// Eksekusi delete
$res = delete_product($id_safe);

if ($res) {
    header('Location: ../ui-form/dashboard.php?msg=' . urlencode('Produk berhasil dihapus'));
    exit;
} else {
    // Jika error
    header('Location: ../ui-form/dashboard.php?msg=' . urlencode('Gagal menghapus produk: ' . $conn->error));
    exit;
}
?>
