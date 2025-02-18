<?php
require_once 'includes/dbConnect.php';

class Announcement {
    private $db;
    public $id;
    public $club_id;
    public $message;
    public $expires_at;

    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new announcement
    public function create() {
        $query = "INSERT INTO announcements (club_id, message, expires_at) VALUES (:club_id, :message, :expires_at)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':club_id', $this->club_id);
        $stmt->bindParam(':message', $this->message);
        $stmt->bindParam(':expires_at', $this->expires_at);
        return $stmt->execute();
    }

    // Fetch all announcements for a club
    public function getAnnouncementsByClub() {
        $query = "SELECT * FROM announcements WHERE club_id = :club_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':club_id', $this->club_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>