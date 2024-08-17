<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function envoiMailElem($recipient, $sujet, $msg) {
    $email_address = 'shiko875@gmail.com';
    $email_password = 'idgb pbuw mspz tofa';

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $email_address;                         // SMTP username
        $mail->Password   = $email_password;                        // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($email_address, 'Mailer');
        $mail->addAddress($recipient);                              // Add a recipient

        // Content
        $mail->isHTML(false);                                       // Set email format to plain text
        $mail->Subject = $sujet;
        $mail->Body    = $msg;

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient = $_POST['email'] ?? 'default@example.com';
    $sujet = $_POST['sujet'] ?? 'Default Subject';
    $msg = $_POST['msg'] ?? 'Default Message';

    envoiMailElem($recipient, $sujet, $msg);
}
?>
