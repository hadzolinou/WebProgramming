<?php
require_once __DIR__ . '/../utils/Database.php';

class UserDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function checkUserCredentials($username, $password) {
        $sql = "SELECT * FROM User WHERE Username = ? AND Password = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function addUser($username, $password, $email, $fullName, $address, $phone) {
        $sql = "INSERT INTO User (Username, Password, Email, FullName, Address, Phone) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $password, $email, $fullName, $address, $phone]);
    }

    public function getUserById($userId) {
        $sql = "SELECT * FROM User WHERE UserID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($userId, $email, $fullName, $address, $phone) {
        $sql = "UPDATE User SET Email = ?, FullName = ?, Address = ?, Phone = ? WHERE UserID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$email, $fullName, $address, $phone, $userId]);
    }

    public function deleteUser($userId) {
        $sql = "DELETE FROM User WHERE UserID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId]);
    }
}
?>
