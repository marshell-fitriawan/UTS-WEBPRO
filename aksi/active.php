<?php
require_once __DIR__ . '/../connect.php';

$token = $_GET['token'] ?? '';
if (!$token) {
    echo 'Token tidak ditemukan.';
    exit;
}

$token_safe = $conn->real_escape_string($token);
$r = $conn->query("SELECT id, status FROM users WHERE activation_token = '$token_safe' LIMIT 1");
if (!$r || $r->num_rows === 0) {
    echo 'Token tidak valid atau sudah digunakan.';
    exit;
}
$row = $r->fetch_assoc();
if ($row['status'] === 'active') {
    echo 'Akun sudah aktif. Silakan <a href=\"../ui-form/login_form.php\">login</a>.';
    exit;
}
if ($conn->query("UPDATE users SET status = 'active', activation_token = NULL, modified = CURRENT_TIMESTAMP WHERE id = " . intval($row['id']))) {
    echo 'Akun aktif. Silakan <a href="../ui-form/login_form.php">login</a>.';
    exit;
} else {
    echo 'Gagal aktivasi: ' . $conn->error;
    exit;
}
?>
