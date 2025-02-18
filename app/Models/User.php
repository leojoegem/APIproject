<?php
require_once 'includes/dbConnect.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class User {
    private $db;
    public $id;
    public $username;
    public $email;
    public $password;
    public $role;
    public $otp; // For 2FA

    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new user
    public function create() {
        $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':role', $this->role);
        return $stmt->execute();
    }

    // Fetch user by username
    public function getUserByUsername() {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch user by ID
    public function getUserById() {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Generate and send OTP for 2FA
    public function sendOTP() {
        $this->otp = rand(100000, 999999); // Generate a 6-digit OTP

        // Store OTP in the database (for verification later)
        $query = "UPDATE users SET otp = :otp WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':otp', $this->otp);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        // Send OTP via email using PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com'; // Replace with your email
        $mail->Password = 'your_password'; // Replace with your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('no-reply@example.com', 'Campus Clubs');
        $mail->addAddress($this->email); // Send to the user's email
        $mail->isHTML(true);

        $mail->Subject = 'Your OTP for Campus Clubs';
        $mail->Body = "Your OTP is: <b>{$this->otp}</b>";

        if (!$mail->send()) {
            return false; // Failed to send OTP
        }
        return true; // OTP sent successfully
    }

    // Verify OTP
    public function verifyOTP($otp) {
        $query = "SELECT otp FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $storedOTP = $stmt->fetchColumn();

        return $storedOTP == $otp; // Compare stored OTP with user input
    }
}
?>