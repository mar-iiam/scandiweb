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

    public function createProduct(ProductScheme $product): void {
        $query = "
            INSERT INTO products (name, SKU, price, specific_attribute, type)
            VALUES (:name, :sku, :price, :specific_attribute, :type)
        ";
        $stmt = $this->db->getPdo()->prepare($query);

        $params = [
            ':name' => $product->getName(),
            ':sku' => $product->getSKU(),
            ':price' => $product->getprice(),
            ':specific_attribute' => $product->getspecific_attribute(),
            ':type' => $product->gettype(),
        ];

        if (!$stmt->execute($params)) {
            throw new Exception("Error inserting product into database.");
        }

        $product->setId($this->db->getPdo()->lastInsertId());
    }

    public function checkSKU(string $SKU): bool {
        $query = "SELECT 1 FROM products WHERE SKU = :sku LIMIT 1";
        $stmt = $this->db->getPdo()->prepare($query);
        $stmt->bindParam(':sku', $SKU, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
    

    public function getAllProducts(): array {
        $query = "SELECT * FROM products";
        $stmt = $this->db->getPdo()->query($query);

        $products = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = $this->mapRowToProduct($row);
        }

        return $products;
    }

     
    private function mapRowToProduct(array $row): ProductScheme {
        $product = new ProductScheme();
        $product->setId($row['id']);
        $product->setSKU($row['SKU']);
        $product->setName($row['name']);
        $product->setprice($row['price']);
        $product->settype($row['type']);
        $product->setspecific_attribute($row['specific_attribute']);

        return $product;
    }

    public function  deleteOneProduct(string $sku): void {
        $query = "DELETE FROM products WHERE SKU = :sku";
        $stmt = $this->db->getPdo()->prepare($query);
        $stmt->execute([':sku' => $sku]);
    }
}
