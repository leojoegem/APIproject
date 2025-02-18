<?php
// fetch_list.php
require_once 'includes/dbConnect.php';

// Initialize search term
$search_term = '';

// Check if form is submitted and search_term is passed via POST
if (isset($_POST['search_term']) && !empty($_POST['search_term'])) {
    $search_term = '%' . $_POST['search_term'] . '%';  // Sanitize the search term with wildcards
}

// Prepare SQL query for fetching motorcycles, with or without search term
if (!empty($search_term)) {
    // SQL with search term
    $sql = "SELECT * FROM Motorcycle WHERE make LIKE ? OR model LIKE ? OR year LIKE ? OR price LIKE ?";
} else {
    // SQL without search term
    $sql = "SELECT * FROM Motorcycle";
}

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

// Bind the search term if it's provided
if (!empty($search_term)) {
    $stmt->bind_param('ssss', $search_term, $search_term, $search_term, $search_term);
}

// Execute the query
if (!$stmt->execute()) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

// Get the result
$result = $stmt->get_result();

// Fetch all motorcycles
$motorcycle = $result->fetch_all(MYSQLI_ASSOC);
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
    
        <!-- Table of motorcycles -->
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
                <?php
                // Check if there are motorcycles to display
                if (empty($motorcycle)) {
                    echo "<tr><td colspan='4'>No motorcycles found.</td></tr>";
                } else {
                    foreach ($motorcycle as $bike) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($bike['make']); ?></td>
                            <td><?php echo htmlspecialchars($bike['model']); ?></td>
                            <td><?php echo htmlspecialchars($bike['year']); ?></td>
                            <td><?php echo htmlspecialchars($bike['price']); ?></td>
                        </tr>
                    <?php endforeach; 
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
