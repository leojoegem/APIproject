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

// Generate a 6-digit random 2FA code
$twoFactorCode = rand(100000, 999999);

// Save the 2FA code in the session
$_SESSION['twoFactorCode'] = $twoFactorCode;
$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT); // Hash the password

// Send the 2FA code to the user's email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'leojoegem@gmail.com';  // Replace with your email
    $mail->Password = 'adsv bzob lynp pitx';  // Replace with your email app-specific password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your-email@gmail.com', 'Josalah');
    $mail->addAddress($email);  // Send to the provided email

    $mail->isHTML(true);
    $mail->Subject = 'Your 2FA Code';
    $mail->Body = "Your 2FA code is: <b>$twoFactorCode</b>";

    $mail->send();
    echo '2FA Code has been sent to your email. Please check your inbox.';
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
