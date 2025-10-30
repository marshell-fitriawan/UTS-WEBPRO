<?php
session_start();
require_once __DIR__ . '/../connect.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../ui-form/login_form.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

// Gunakan langsung user_id dari session (lebih aman)
$user_id = intval($_SESSION['user_id']);
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';

// Validasi input
if (!$current_password || strlen($new_password) < 6) {
    header('Location: ../ui-form/profile.php?msg=' . urlencode('Password baru minimal 6 karakter'));
    exit;
}

// Ambil password lama dari database
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header('Location: ../ui-form/profile.php?msg=' . urlencode('User tidak ditemukan'));
    exit;
}

// Verifikasi password lama
if (!password_verify($current_password, $user['password'])) {
    header('Location: ../ui-form/profile.php?msg=' . urlencode('Password saat ini salah'));
    exit;
}

// Hash password baru
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);

// Update password
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param('si', $new_hash, $user_id);

if ($stmt->execute()) {
    header('Location: ../ui-form/profile.php?msg=' . urlencode('Password berhasil diubah'));
} else {
    header('Location: ../ui-form/profile.php?msg=' . urlencode('Gagal mengubah password'));
}
exit;
?>

