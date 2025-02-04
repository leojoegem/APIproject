<?php
session_start();
include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_otp'])) {
    $otp = $_POST['otp'];
    $userId = $_SESSION['temp_user']['id'];

    $stmt = $conn->prepare("SELECT otp, otp_expiry FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data['otp'] == $otp && strtotime($data['otp_expiry']) > time()) {
        $_SESSION['user_id'] = $userId;
        header("Location: dashboard.php");
    } else {
        echo "<script>alert('Invalid or expired OTP. Please try again.'); window.location.href = 'otp_verification.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification - CampusClubs</title>
</head>
<body>
    <h2>Enter OTP</h2>
    <form method="post" action="otp_verification.php">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <input type="submit" name="verify_otp" value="Verify OTP">
    </form>
</body>
</html>
