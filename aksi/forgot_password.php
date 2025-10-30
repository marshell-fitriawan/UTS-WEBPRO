<?php
require_once __DIR__ . '/../connect.php';
require_once __DIR__ . '/helper_mail.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid');
}
$email = trim($_POST['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../ui-form/forgot_form.php?msg=' . urlencode('Email tidak valid'));
    exit;
}

$r = $conn->query("SELECT id, full_name, status FROM users WHERE username = '" . $conn->real_escape_string($email) . "' LIMIT 1");
if (!$r || $r->num_rows === 0) {
    header('Location: ../ui-form/forgot_form.php?msg=' . urlencode('Email tidak ditemukan'));
    exit;
}
$user = $r->fetch_assoc();
if ($user['status'] !== 'active') {
    header('Location: ../ui-form/forgot_form.php?msg=' . urlencode('Akun belum aktif'));
    exit;
}

$token = bin2hex(random_bytes(16));
if ($conn->query("UPDATE users SET reset_token = '" . $conn->real_escape_string($token) . "' WHERE id = " . intval($user['id']))) {
    $base = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['REQUEST_URI']));
    $reset_link = $base . '/ui-form/reset_form.php?token=' . $token;
    $subject = 'Reset Password - Admin Gudang';
    $body = "<p>Halo " . htmlspecialchars($user['full_name']) . ",</p>
             <p>Silakan klik tautan berikut untuk mereset password Anda:</p>
             <p><a href=\"$reset_link\">Reset Password</a></p>";
    send_mail_html($email, $subject, $body);
    header('Location: ../ui-form/forgot_form.php?msg=' . urlencode('Cek email untuk tautan reset'));
    exit;
} else {
    header('Location: ../ui-form/forgot_form.php?msg=' . urlencode('Gagal set reset token'));
    exit;
}
?>
