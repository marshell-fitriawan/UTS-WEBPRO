<?php
require_once __DIR__ . '/../connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid');
}
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !$password) {
    header('Location: ../ui-form/login_form.php?msg=' . urlencode('Input tidak valid'));
    exit;
}

$r = $conn->query("SELECT id, password, full_name, status FROM users WHERE username = '" . $conn->real_escape_string($email) . "' LIMIT 1");
if (!$r || $r->num_rows === 0) {
    header('Location: ../ui-form/login_form.php?msg=' . urlencode('Email tidak terdaftar'));
    exit;
}
$user = $r->fetch_assoc();
if ($user['status'] !== 'active') {
    header('Location: ../ui-form/login_form.php?msg=' . urlencode('Akun belum aktif. Cek email Anda.'));
    exit;
}
if (!password_verify($password, $user['password'])) {
    header('Location: ../ui-form/login_form.php?msg=' . urlencode('Password salah'));
    exit;
}

// sukses
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['full_name'];
header('Location: ../ui-form/dashboard.php');
exit;
?>
