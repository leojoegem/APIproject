<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'dbConnect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Securely hash password
    $verification_token = bin2hex(random_bytes(16)); // Generate email verification token

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already exists! Please use a different email.'); window.location.href = 'signup.php';</script>";
        exit();
    }

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password_hash, verification_token) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $password, $verification_token);
    
    if ($stmt->execute()) {
        // Send verification email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'leojoegem@gmail.com'; 
            $mail->Password = 'eofn inez hekr nfol'; 
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('leojoegem@gmail.com', 'CampusClubs');
            $mail->addAddress($email);
            $mail->Subject = "Verify Your Email";
            $mail->Body = "Click the link below to verify your email: \n\n http://yourdomain.com/verify_email.php?token=$verification_token";
            $mail->send();
        } catch (Exception $e) {
            die("Mailer Error: " . $mail->ErrorInfo);
        }

        echo "<script>alert('Registration successful! Check your email to verify your account.'); window.location.href = 'index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up - CampusClubs</title>
    <style>
        #container { margin: 40px auto; padding: 20px; width: 400px; border: 1px solid #ddd; }
        label { font-size: 16px; font-weight: bold; }
        input { width: 100%; padding: 10px; margin: 5px 0; }
        input[type=submit] { background-color: #007bff; color: white; border: none; cursor: pointer; }
        input[type=submit]:hover { background-color: #0056b3; }
        a { font-size: 14px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div id="container">
        <form method="post" action="signup.php">
            <h2>Create an Account</h2>
            <label>Name:</label>
            <input type="text" name="name" required>
            
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Phone Number:</label>
            <input type="text" name="phone" required>
            
            <label>Password:</label>
            <input type="password" name="password" required>
            
            <input type="submit" name="signup" value="Sign Up">
            <p>Already have an account? <a href="index.php">Login</a></p>
        </form>
    </div>
</body>
</html>
