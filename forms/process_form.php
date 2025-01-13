<?php
// process_form.php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include PHPMailer autoload file
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Class to handle sending 2FA email
class TwoFactorAuth {
    private $mail;
    
    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->setupMail();
    }

    private function setupMail() {
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'your_email@gmail.com';  // Your email
        $this->mail->Password = 'your_app_password';  // App-specific password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
        $this->mail->setFrom('your_email@gmail.com', 'Your Name');
    }

    public function send2FACode($email, $username, $code) {
        try {
            $this->mail->clearAddresses(); // Clear previous addresses
            $this->mail->addAddress($email, $username);  // Recipient's email and name
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Your 2FA Code';
            $this->mail->Body = "Your 2FA code is: <b>$code</b>";

            $this->mail->send();
            return true; // Return true on success
        } catch (Exception $e) {
            return "Email could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Save form data to session
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Generate a 6-digit random 2FA code
    $twoFactorCode = rand(100000, 999999);
    $_SESSION['twoFactorCode'] = $twoFactorCode;

    // Send 2FA code to the user's email
    $twoFA = new TwoFactorAuth();
    $sendResult = $twoFA->send2FACode($email, $username, $twoFactorCode);

    if ($sendResult === true) {
        // Redirect to the 2FA confirmation page
        header('Location: confirm_2fa.php');
        exit;
    } else {
        echo "Error: " . $sendResult;
    }
}
?>