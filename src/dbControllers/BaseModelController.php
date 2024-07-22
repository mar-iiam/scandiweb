<?php
namespace App\dbControllers;

use PDO;
use Exception;
use App\models\productScheme;
abstract class BaseModelController {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Abstract methods to be implemented by subclasses
    abstract protected function createProduct(ProductScheme $product): void;
    abstract protected function checkSKU(string $SKU): bool;
    abstract protected function getAllProducts(): array;
    abstract protected function deleteOneProduct(string $sku): void;

    // Common method to map row to product
    protected function mapRowToProduct(array $row) {
        // This method should be overridden in subclasses if necessary
    }
}