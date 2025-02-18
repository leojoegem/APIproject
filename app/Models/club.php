<?php
require_once 'includes/dbConnect.php';

class Club {
    private $db;
    public $id;
    public $name;
    public $description;
    public $created_by;

    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new club
    public function create() {
        $query = "INSERT INTO clubs (name, description, created_by) VALUES (:name, :description, :created_by)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':created_by', $this->created_by);
        return $stmt->execute();
    }

    // Fetch all clubs
    public function getAllClubs() {
        $query = "SELECT * FROM clubs";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch club by ID
    public function getClubById() {
        $query = "SELECT * FROM clubs WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>