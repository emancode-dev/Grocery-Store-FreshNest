<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'emanamirniazi@gmail.com';       // 🔑 your Gmail
        $mail->Password   = 'fbvf pufi vnya gccx';         // 🔑 your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('emanamirniazi@gmail.com', 'Feedback Form');
        $mail->addAddress('emanamirniazi@gmail.com'); // you will receive it here

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Feedback Received';
        $mail->Body    = nl2br($message);

        $mail->send();
        header("location:sent.html");
    } catch (Exception $e) {
        echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
