<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST['name'];
    $email   = $_POST['email'];  // visitor email
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = ''; 
        $mail->Password   = '';   // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;
        // Who sends & who receives
        $mail->setFrom('', 'FreshNest Contact Form');
        $mail->addReplyTo($email, $name); 
        $mail->addAddress('', 'FreshNest Team');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Contact from $name";
        $mail->Body    = "<b>Name:</b> $name<br>
                          <b>Email:</b> $email<br>
                          <b>Message:</b><br>$message";

        if ($mail->send()) {
            header("Location: sent.html");
            exit;
        } else {
            echo "❌ Message could not be sent. Error: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
    }
}
?>


