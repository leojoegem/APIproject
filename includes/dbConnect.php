<?php
$servername = "localhost";
$port = 3308; 
$username = "root";
$password = "";
$dbname = "campusclubs";

try {
    $dsn = "mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
