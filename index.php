<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'includes/dbConnect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['email'] = $email;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data && password_verify($password, $data['password_hash'])) {
        $otp = rand(100000, 999999);
        $otp_expiry = date("Y-m-d H:i:s", strtotime("+3 minutes"));

        // Send OTP via email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'leojoegem@gmail.com'; //host email 
            $mail->Password = 'eofn inez hekr nfol'; // app password
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('leojoegem@gmail.com', 'CampusClubs');
            $mail->addAddress($email);
            $mail->Subject = "Your OTP for Login";
            $mail->Body = "Your OTP is: $otp";
            $mail->send();
        } catch (Exception $e) {
            die("Mailer Error: " . $mail->ErrorInfo);
        }

        // Update OTP in the database
        $updateStmt = $conn->prepare("UPDATE users SET otp = ?, otp_expiry = ? WHERE id = ?");
        $updateStmt->bind_param("ssi", $otp, $otp_expiry, $data['id']);
        $updateStmt->execute();

        $_SESSION['temp_user'] = ['id' => $data['id']];
        header("Location: otp_verification.php");
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password. Please try again.'); window.location.href = 'index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - CampusClubs</title>
    <style>
        #container { margin: 40px auto; padding: 20px; width: 400px; border: 1px solid #ddd; }
        label { font-size: 16px; font-weight: bold; }
        input[type=text], input[type=password] { width: 100%; padding: 10px; margin: 5px 0; }
        input[type=submit] { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer; }
        input[type=submit]:hover { background-color: #218838; }
        a { font-size: 14px; color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div id="container">
        <form method="post" action="index.php">
            <h2>Login</h2>
            <label for="email">Email</label><br>
            <input type="text" name="email" placeholder="Enter Your Email" required><br>
            
            <label for="password">Password:</label><br>
            <input type="password" name="password" placeholder="Enter Your Password" required><br>
            
            <input type="submit" name="login" value="Login"><br>
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </form>
    </div>
</body>
</html>
