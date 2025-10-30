<?php
require_once __DIR__ . '/../connect.php';
require_once __DIR__ . '/helper_mail.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
    header('Location: ../ui-form/register_form.php?msg=' . urlencode('Input tidak valid (cek email & password >=6)'));
    exit;
}

// Validasi konfirmasi password
if ($password !== $password_confirm) {
    header('Location: ../ui-form/register_form.php?msg=' . urlencode('Password dan konfirmasi password tidak cocok'));
    exit;
}

// cek unik email
$r = $conn->query("SELECT id FROM users WHERE username = '" . $conn->real_escape_string($email) . "' LIMIT 1");
if ($r && $r->num_rows > 0) {
    header('Location: ../ui-form/register_form.php?msg=' . urlencode('Email sudah terdaftar'));
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$token = bin2hex(random_bytes(16));

$q = "INSERT INTO users (username, password, full_name, role, status, activation_token) VALUES (
    '" . $conn->real_escape_string($email) . "',
    '" . $conn->real_escape_string($hash) . "',
    '" . $conn->real_escape_string($name) . "',
    'admin_gudang',
    'inactive',
    '" . $conn->real_escape_string($token) . "'
)";

if ($conn->query($q)) {
    // kirim email aktivasi
    $base = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['REQUEST_URI']));
    $activation_link = $base . '/aksi/active.php?token=' . $token;
    $subject = 'Aktivasi Akun - Admin Gudang';
    $body = "<p>Halo " . htmlspecialchars($name) . ",</p>
             <p>Silakan klik tautan berikut untuk mengaktifkan akun Anda:</p>
             <p><a href=\"$activation_link\">Aktifkan akun</a></p>";
    send_mail_html($email, $subject, $body);

    header('Location: ../ui-form/register_form.php?msg=' . urlencode('Registrasi berhasil. Cek email untuk aktivasi.'));
    exit;
} else {
    header('Location: ../ui-form/register_form.php?msg=' . urlencode('Gagal registrasi: ' . $conn->error));
    exit;
}
?>
