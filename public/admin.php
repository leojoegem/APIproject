<?php

class Club {
    private $name;
    private $description;

    public function __construct($name, $description) {
        $this->name = $name;
        $this->description = $description;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }
}

class ClubList {
    private $clubs = [];

    public function addClub(Club $club) {
        $this->clubs[] = $club;
    }

    public function getClubs() {
        return $this->clubs;
    }
}

$clubList = new ClubList();
$clubList->addClub(new Club("Science Club", "A club for students interested in science."));
$clubList->addClub(new Club("Art Club", "A club for students interested in art."));
$clubList->addClub(new Club("Drama Club", "A club for students interested in drama and theater."));
$clubList->addClub(new Club("Music Club", "A club for students interested in music."));
$clubList->addClub(new Club("Chess Club", "A club for students who would like to exercise their passion for chess"));

// Handle CSV export
if (isset($_GET['export'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=clubs-data.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Club Name', 'Description', 'Joined Users', 'Date Created']);

    foreach ($clubList->getClubs() as $club) {
        fputcsv($output, [$club->getName(), $club->getDescription(), rand(5, 50) . " users", date('Y-m-d')]);
    }

    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Campus Clubs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            margin: 20px 0;
            font-size: 2.5em;
            color: #222;
        }
        .club {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px 0;
            width: 80%;
            max-width: 800px;
        }
        .club h2 {
            margin: 0 0 10px;
            font-size: 1.75em;
            color: #007BFF;
        }
        .club p {
            margin: 0 0 15px;
            font-size: 1em;
            color: #666;
        }
        .admin-controls {
            display: flex;
            gap: 10px;
        }
        .admin-controls button {
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .admin-controls button.edit {
            background-color: #ffc107;
            color: #fff;
        }
        .admin-controls button.edit:hover {
            background-color: #e0a800;
        }
        .admin-controls button.delete {
            background-color: #dc3545;
            color: #fff;
        }
        .admin-controls button.delete:hover {
            background-color: #c82333;
        }
        .admin-controls .add {
            background-color: #28a745;
            color: #fff;
            display: block;
            margin: 20px auto;
        }
        .admin-controls .add:hover {
            background-color: #218838;
        }
        .export-btn {
            background-color: #17a2b8;
            color: #fff;
            padding: 12px 24px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }
        .export-btn:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>
    <h1>Admin - Campus Clubs</h1>
    <a href="?export=1" class="export-btn">Export Club Data as CSV</a>
    <?php foreach ($clubList->getClubs() as $club): ?>
        <div class="club">
            <h2><?php echo htmlspecialchars($club->getName()); ?></h2>
            <p><?php echo htmlspecialchars($club->getDescription()); ?></p>
            <div class="admin-controls">
                <button class="edit">Edit</button>
                <button class="delete">Delete</button>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="admin-controls">
        <button class="add">Add New Club</button>
    </div>
</body>
</html>
