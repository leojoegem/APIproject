<?php
session_start();

// Check if the user is redirected from the send_2fa.php
if (!isset($_SESSION['twoFactorCode'])) {
    header('Location: index.php'); // Redirect to the registration form if no code is set
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredCode = $_POST['twoFactorCode'];

    // Check if the entered code matches the one stored in the session
    if ($enteredCode == $_SESSION['twoFactorCode']) {
        $message = "2FA code verified successfully! You can now proceed.";
        // Here you can redirect to a success page or perform further actions (e.g., save user to the database)
        // For example: header('Location: success.php'); exit;
    } else {
        $message = "Invalid 2FA code. Please try again.";
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
        <h2>Confirm 2FA Code</h2>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="twoFactorCode">Enter the 2FA Code</label>
                <input type="text" class="form-control" name="twoFactorCode" id="twoFactorCode" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify Code</button>
        </form>
    </div>
</body>
</html>