<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = $_POST['name'];

    // Validation checks
    if (empty($email) || empty($password) || empty($confirm_password) || empty($name)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (in_array($email, $existing_users)) {
        $error_message = "Email is already registered.";
    } else {
        // Registration successful
        // Normally, you would hash the password and store user info in a database
        $_SESSION['registered'] = true;
        $_SESSION['email'] = $email;
        header('Location: login.php'); // Redirect to login page after successful registration
        exit;
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
    <title>CampusClubs - Sign Up</title>

    <!-- CSS Files -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;700;900&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/tooplate-little-fashion.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f0f5;
        }

        .signup-container {
            max-width: 420px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .signup-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 700;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ddd;
        }

        .btn-custom {
            width: 100%;
            padding: 12px;
            background-color: #0069d9;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
        }

        .footer a {
            text-decoration: none;
            color: #0069d9;
            font-weight: 500;
        }

        .footer a:hover {
            color: #0056b3;
        }

        .error-message {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="signup-container">
        <h2>Create an Account on <span style="color: #0069d9;">CampusClubs</span></h2>

        <?php
        if (isset($error_message)) {
            echo "<div class='error-message'>$error_message</div>";
        }
        ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            <button type="submit" class="btn-custom">Sign Up</button>
        </form>

        <div class="footer">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
