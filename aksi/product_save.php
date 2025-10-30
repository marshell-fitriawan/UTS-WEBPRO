<?php
include __DIR__ . '/../connect.php';
include __DIR__ . '/../crud-table/crud_product.php'; 

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../ui-form/login_form.php');
    exit;
}

// Ambil data dari form
$id          = $_POST['id'] ?? '';
$name        = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price       = $_POST['price'] ?? 0;
$stock       = $_POST['stock'] ?? 0;
$created_by  = $_SESSION['user_id'] ?? null;

// Sanitasi dasar 
$name_safe  = $conn->real_escape_string($name);
$desc_safe  = $conn->real_escape_string($description);
$price_safe = $conn->real_escape_string($price);
$stock_safe = $conn->real_escape_string($stock);
$id_safe    = $conn->real_escape_string($id);

// Jika ada id => update, jika tidak => create
if (!empty($id_safe)) {
    // update_product($id, $name, $description, $price, $stock)
    $res = update_product($id_safe, $name_safe, $desc_safe, $price_safe, $stock_safe);
    if ($res) {
        header('Location: ../ui-form/dashboard.php?msg=' . urlencode('Produk berhasil diupdate'));
        exit;
    } else {
        // tampilkan error sederhana
        die('Gagal mengupdate produk: ' . $conn->error);
    }
} else {
    // create_product($name, $description, $price = 0.00, $stock = 0, $created_by = null)
    $res = create_product($name_safe, $desc_safe, $price_safe, $stock_safe, $created_by);
    if ($res) {
        header('Location: ../ui-form/dashboard.php?msg=' . urlencode('Produk berhasil disimpan'));
        exit;
    } else {
        die('Gagal menyimpan produk: ' . $conn->error);
    }
}
?>
