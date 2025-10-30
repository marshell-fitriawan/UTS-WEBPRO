<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'marshellfitriawan19@gmail.com'; // GANTI
    $mail->Password   = 'rgkm bpjx foeh iaku'; // GANTI DENGAN APP PASSWORD
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // from & to
    $mail->setFrom('marshellfitriawan19@gmail.com', 'Website UTS');
    $mail->addAddress('marshellfitriawan195@gmail.com'); // email penerima

    // konten
    $mail->isHTML(true);
    $mail->Subject = 'Test Email Gmail SMTP';
    $mail->Body    = 'Hello! Ini email dari PHP via Gmail SMTP.';

    $mail->send();
    echo "<h3 style='color:green'>✅ Email Gmail terkirim!</h3>";

} catch (Exception $e) {
    echo "<h3 style='color:red'>❌ Gagal mengirim email Gmail.</h3>";
    echo "Error: " . $mail->ErrorInfo;
}
