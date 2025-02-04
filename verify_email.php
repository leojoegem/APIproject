<?php
session_start();
include '<includes>dbConnect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        // Update user as verified
        $stmt = $conn->prepare("UPDATE users SET email_verified = 1, verification_token = NULL WHERE id = ?");
        $stmt->bind_param("i", $data['id']);
        $stmt->execute();

        echo "<script>alert('Email verified successfully! You can now log in.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Invalid verification token.'); window.location.href = 'index.php';</script>";
    }
}
?>
