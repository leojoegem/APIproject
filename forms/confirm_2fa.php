<?php
// confirm_2fa.php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If 2FA code is not in session, redirect to form page
if (!isset($_SESSION['twoFactorCode'])) {
    header('Location: form.php');
    exit;
}

// Handle the 2FA code verification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredCode = $_POST['code'];

    // Check if entered code matches the one in the session
    if ($enteredCode == $_SESSION['twoFactorCode']) {
        // Successful verification
        echo "2FA Verification successful!";
        // You can now proceed with further actions, such as redirecting to a dashboard
    } else {
        // Invalid code
        echo "Invalid 2FA code. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm 2FA Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Enter the 2FA Code</h2>
        <form action="confirm_2fa.php" method="post">
            <div class="form-group">
                <label for="code">2FA Code</label>
                <input type="text" class="form-control" name="code" id="code" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify</button>
        </form>
    </div>
</body>
</html>
