<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../vendor/autoload.php';

function send_mail_html($to, $subject, $html_body)
{
    $mail = new PHPMailer(true);

    try {
        // Debugging (0=none, 2=verbose)
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        // Gunakan SMTP Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // email
        $mail->Username   = 'marshellfitriawan19@gmail.com';
        $mail->Password   = 'rgkm bpjx foeh iaku';

        // From
        $mail->setFrom('marshellfitriawan19@gmail.com', 'Management Gudang Marshell');

        // Tujuan
        $mail->addAddress($to);

        // Konten
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $html_body;

        // Kirim
        return $mail->send();

    } catch (Exception $e) {
        // Kembalikan pesan error untuk debugging
        return "Mailer Error: {$mail->ErrorInfo}";
    }
}
