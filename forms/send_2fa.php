<?php
session_start();
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Collect form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Save form data to session for later use
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;

// Generate a 6-digit random 2FA code and save it to the session
$twoFactorCode = rand(100000, 999999);
$_SESSION['twoFactorCode'] = $twoFactorCode;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'leojoegem@gmail.com';  // Your email
    $mail->Password = 'adsv bzob lynp pitx';  // Your email app-specific password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Enable verbose debug output
    $mail->SMTPDebug = 2; // Change to 0 to disable debugging

    $mail->setFrom('leojoegem@gmail.com', 'Josalah');
    $mail->addAddress($email, $username);  // Recipient's email and name

    $mail->isHTML(true);
    $mail->Subject = 'Your 2FA Code';
    $mail->Body = "Your 2FA code is: <b>$twoFactorCode</b>";

    $mail->send();
    $_SESSION['message'] = "2FA Code has been sent to $email. Please check your inbox.";

    // Redirect to the confirm_2fa.php page
    header('Location: confirm_2fa.php');
    exit;
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}