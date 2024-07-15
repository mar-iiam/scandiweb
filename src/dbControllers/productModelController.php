<?php
namespace App\dbControllers;
use App\models\productScheme;
use PDO;
use Exception;
class productModelController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createProduct(productScheme $product) {
        $stmt = $this->db->getPdo()->prepare("INSERT INTO products (name, SKU, price, specific_attribute, type) VALUES (:name, :sku, :price, :specific_attribute, :type)");
        if ($this->checkSKU($product->getSKU())) {
            throw new Exception("SKU already exists in the database.");
        }
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

    private function checkSKU($SKU) {
        $stmt = $this->db->getPdo()->prepare("SELECT 1 FROM products WHERE SKU = :SKU LIMIT 1;");
        $stmt->bindParam(':SKU', $SKU, PDO::PARAM_STR);
        $stmt->execute();
    
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Return true if SKU exists, false otherwise
        return $result !== false;
    }
    
    public function getProduct($sku) {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM products WHERE SKU = :sku");
        $stmt->execute([':sku' => $sku]);  // Corrected to match the placeholder

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $product = new productScheme();
            $product->setSKU($row['SKU']);
            $product->setName($row['name']);
            $product->setPrice($row['price']);
            $product->setType($row['type']);
            $product->setSpecific_attribute($row['specific_attribute']);

            return $product;
        } else {
            return null;
        }
    }
   public function getAllProducts(){
    $stmt = $this->db->getPdo()->query("SELECT * FROM products");

    $products = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $product = new productScheme();
        $product->setSKU($row['SKU']);
        $product->setName($row['name']);
        $product->setprice($row['price']);
        $product->settype($row['type']);
        $product->setspecific_attribute($row['specific_attribute']);

        $products[] = $product;
    }

    return $products;
   }


    public function deleteProduct($sku) {
        $stmt = $this->db->getPdo()->prepare("DELETE FROM products WHERE SKU = :sku");
        $stmt->execute([':sku' => $sku]);
    }
}
