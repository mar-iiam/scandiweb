<?php
namespace App\dbControllers;
use App\models\productScheme;
class productModelController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createProduct(productScheme $product) {
        $stmt = $this->db->getPdo()->prepare("INSERT INTO products (name, SKU, price, specific_attribute, type) VALUES (:name, :sku, :price, :specific_attribute, :type)");
    
        // Check for successful execution
        if ($stmt->execute([
            ':name' => $product->getName(),
            ':sku' => $product->getSKU(),
            ':price' => $product->getPrice(),
            ':specific_attribute' => $product->getspecific_attribute(),
            ':type' => $product->getType(),
        ])) {
            $product->setId($this->db->getPdo()->lastInsertId());
        } else {
            // Handle error (e.g., throw exception or log error)
            throw new Exception("Error inserting product into database.");
        }
    }

    public function getUser($id) {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $user = new User();
            $user->setId($row['id']);
            $user->setName($row['name']);
            $user->setEmail($row['email']);
            return $user;
        } else {
            return null;
        }
    }

    public function updateUser(User $user) {
        $stmt = $this->db->getPdo()->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute([
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':id' => $user->getId()
        ]);
    }

    public function deleteUser($id) {
        $stmt = $this->db->getPdo()->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
