<?php
// fetch_list.php
require_once 'dbConnect.php';

if(isset($_POST['search_term'])) {
    $search_term = $_POST['search_term'];
    $sql = "SELECT * FROM Motorcycle WHERE make LIKE '%$search_term%' OR model LIKE '%$search_term%' OR year LIKE '%$search_term%' OR price LIKE '%$search_term%'";
} else {
    $sql = "SELECT * FROM Motorcycle";
}

$stmt = $conn->query($sql);

$motorcycle = $stmt->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Motorcycle List</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Motorcycle List</h2>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($motorcycle as $motorcycle) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($motorcycle['make']); ?></td>
                        <td><?php echo htmlspecialchars($motorcycle['model']); ?></td>
                        <td><?php echo htmlspecialchars($motorcycle['year']); ?></td>
                        <td><?php echo htmlspecialchars($motorcycle['price']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>