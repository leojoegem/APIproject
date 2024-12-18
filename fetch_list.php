<?php
// fetch_list.php
require_once 'dbConnect.php';

$sql = "SELECT * FROM Motorcycle";

$stmt = $conn->query($sql);

$motorcycle = $stmt->fetch_all(MYSQLI_ASSOC);

foreach ($motorcycle as $motorcycle) {
    echo $motorcycle['make'] . '<br>';
}
?>