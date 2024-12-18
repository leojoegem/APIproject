<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Home</title>
    <link href = "https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E2633wXjSkEh2U6UHDtUy4UJfjG" crossorigin = "anonymous">
</head>

<style>
    #search {
        margin-top: 20px;
        margin-left: 20px;
        width: 500px;
    }
</style>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $input = htmlspecialchars($_POST['in_put']);
        echo "<div id='out_put'>You searched for: $input</div>";
    }
    ?>
    <form action = "" method = "post">
        <input class="form-control form-control-lg" type="text" name="in_put" id="in_put" placeholder="Search..." autofocus>
    </form>
    <br>
    <div id = "out_put"></div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src = "userdisplay.js"></script>
</body>
</html>