<?php
function renderMotorcycleTable($motorcycles) {
    if (empty($motorcycles)) {
        echo "<tr><td colspan='4'>No motorcycles found.</td></tr>";
    } else {
        foreach ($motorcycles as $bike) {
            echo "<tr>
                <td>" . htmlspecialchars($bike['make']) . "</td>
                <td>" . htmlspecialchars($bike['model']) . "</td>
                <td>" . htmlspecialchars($bike['year']) . "</td>
                <td>" . htmlspecialchars($bike['price']) . "</td>
            </tr>";
        }
    }
}
?>
