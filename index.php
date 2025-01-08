<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E2633wXjSkEh2U6UHDtUy4UJfjG" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        #out_put {
            margin-top: 20px;
            font-size: 1.25rem;
            color: #495057;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    // Handle the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_term'])) {
        $input = htmlspecialchars($_POST['search_term']); // Sanitize user input
        echo "<div id='out_put'>You searched for: $input</div>";
    }
    ?>

    <!-- Include the reusable search bar -->
    <?php include 'search_bar.php'; ?>

    <div class="container mt-5">
        <!-- Include Motorcycle list -->
        <?php include('fetch_list.php'); ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
