<?php
require_once 'includes/dbConnect.php';

class Alumni {
    private $db;
    public $user_id;
    public $club_id;

    public function __construct($db) {
        $this->db = $db;
    }

    // Move a user to alumni
    public function moveToAlumni() {
        $query = "INSERT INTO alumni (user_id, club_id) VALUES (:user_id, :club_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':club_id', $this->club_id);
        return $stmt->execute();
    }
}
?>