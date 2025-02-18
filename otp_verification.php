<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entered_otp = $_POST['otp']; // Get the entered OTP

    if ($entered_otp == $_SESSION['otp']) {
        // OTP is correct, user is verified
        unset($_SESSION['otp']); // Clear OTP from session

        // Now you can proceed with completing the registration or log them in
        // Here, we assume registration is completed and redirect the user to the login page
        header('Location: login.php');
        exit;
    } else {
        // OTP is incorrect
        $error_message = "Incorrect OTP. Please try again.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CampusClubs - OTP Verification</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="signup-container">
            <h2>Verify Your OTP</h2>

            <?php
            if (isset($error_message)) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter the OTP sent to your email" required>
                </div>
                <button type="submit" class="btn btn-primary">Verify OTP</button>
            </form>

            <div class="footer">
                <p>Didn't receive the email? <a href="signup.php">Request a new one</a></p>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
