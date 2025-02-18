<?php
class ClubList {
    private $clubs = [];

    public function __construct() {
        $this->clubs[] = new Club("Science Club", "A club for students interested in science.");
        $this->clubs[] = new Club("Art Club", "A club for students interested in art.");
        $this->clubs[] = new Club("Drama Club", "A club for students interested in drama and theater.");
        $this->clubs[] = new Club("Music Club", "A club for students interested in music.");
        $this->clubs[] = new Club("Chess Club", "A club for students who would like to exercise their passion for chess.");
    }

    public function findClubBySlug($slug) {
        foreach ($this->clubs as $club) {
            if ($club->getSlug() === $slug) {
                return $club;
            }
        }
        return null;
    }
}

if (isset($_GET['club'])) {
    $slug = $_GET['club'];
    $clubList = new ClubList();
    $club = $clubList->findClubBySlug($slug);
} else {
    $club = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Details</title>
</head>
<body>
    <?php if ($club): ?>
        <h1><?php echo htmlspecialchars($club->getName()); ?></h1>
        <p><?php echo htmlspecialchars($club->getDescription()); ?></p>
        <form method="post" action="join-club.php">
            <input type="hidden" name="club_name" value="<?php echo htmlspecialchars($club->getName()); ?>">
            <button type="submit">Join This Club</button>
        </form>
    <?php else: ?>
        <h1>Club Not Found</h1>
        <p>The club you are looking for does not exist.</p>
    <?php endif; ?>
</body>
</html>
