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

    public function getSlug() {
        return urlencode(strtolower(str_replace(' ', '-', $this->name)));
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Clubs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            margin-top: 20px;
            font-size: 2.5em;
            color: #444;
        }
        .club {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px 0;
            width: 80%;
            max-width: 600px;
        }
        .club h2 {
            margin: 0 0 10px;
            font-size: 1.5em;
            color: #333;
        }
        .club p {
            margin: 0;
            font-size: 1em;
            color: #666;
        }
        .club a {
            text-decoration: none;
            color: #007BFF;
        }
        .club a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Campus Clubs</h1>
    <?php foreach ($clubList->getClubs() as $club): ?>
        <div class="club">
            <h2><a href="club-details.php?club=<?php echo $club->getSlug(); ?>"><?php echo htmlspecialchars($club->getName()); ?></a></h2>
            <p><?php echo htmlspecialchars($club->getDescription()); ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
