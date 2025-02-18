<?php
require_once 'includes/dbConnect.php';

class Membership {
    private $db;
    public $user_id;
    public $club_id;

    public function __construct($db) {
        $this->db = $db;
    }

    // Join a club
    public function join() {
        $query = "INSERT INTO memberships (user_id, club_id) VALUES (:user_id, :club_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':club_id', $this->club_id);
        return $stmt->execute();
    }

    // Leave a club
    public function leave() {
        $query = "DELETE FROM memberships WHERE user_id = :user_id AND club_id = :club_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':club_id', $this->club_id);
        return $stmt->execute();
    }

    // Fetch all memberships for a user
    public function getMembershipsByUser() {
        $query = "SELECT * FROM memberships WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>