<?php
require_once 'dbConnect.php';

function fetchMotorcycles($search_term = '') {
    global $conn; // Ensure that this connection is valid

    if (!empty($search_term)) {
        $sql = "SELECT * FROM Motorcycle WHERE make LIKE ? OR model LIKE ? OR year LIKE ? OR price LIKE ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $search_term = '%' . $search_term . '%';
        $stmt->bind_param('ssss', $search_term, $search_term, $search_term, $search_term);
    } else {
        $sql = "SELECT * FROM Motorcycle";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
    }

    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
