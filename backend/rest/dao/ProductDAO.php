<?php
require_once __DIR__ . '/../utils/Database.php';


class ProductDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addProduct($name, $description, $price, $stock, $image) {
        $sql = "INSERT INTO Product (Name, Description, Price, Stock, Image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $description, $price, $stock, $image]);
    }

    public function getProductById($productId) {
        $sql = "SELECT * FROM Product WHERE ProductID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduct($productId, $name, $description, $price, $stock, $image) {
        $sql = "UPDATE Product SET Name = ?, Description = ?, Price = ?, Stock = ?, Image= ? WHERE ProductID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $description, $price, $stock, $productId, $image]);
    }

    public function deleteProduct($productId) {
        $sql = "DELETE FROM Product WHERE ProductID = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$productId]);
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM Product";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
