<?php
require_once __DIR__ . '/../connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid');
}
$token = trim($_POST['token'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if (!$token || strlen($password) < 6) {
    header('Location: ../ui-form/reset_form.php?token=' . urlencode($token) . '&msg=' . urlencode('Password minimal 6 karakter'));
    exit;
}

// Validasi konfirmasi password
if ($password !== $password_confirm) {
    header('Location: ../ui-form/reset_form.php?token=' . urlencode($token) . '&msg=' . urlencode('Password dan konfirmasi password tidak cocok'));
    exit;
}

$r = $conn->query("SELECT id FROM users WHERE reset_token = '" . $conn->real_escape_string($token) . "' LIMIT 1");
if (!$r || $r->num_rows === 0) {
    header('Location: ../ui-form/reset_form.php?msg=' . urlencode('Token tidak valid'));
    exit;
}
$user = $r->fetch_assoc();
$hash = password_hash($password, PASSWORD_DEFAULT);

if ($conn->query("UPDATE users SET password = '" . $conn->real_escape_string($hash) . "', reset_token = NULL, modified = CURRENT_TIMESTAMP WHERE id = " . intval($user['id']))) {
    header('Location: ../ui-form/login_form.php?msg=' . urlencode('Password berhasil diubah. Silakan login.'));
    exit;
} else {
    header('Location: ../ui-form/reset_form.php?msg=' . urlencode('Gagal menyimpan password'));
    exit;
}
?>
