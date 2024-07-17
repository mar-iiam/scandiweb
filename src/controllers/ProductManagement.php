<?php

namespace App\Controllers;

use config\MysqlDatabase;
use App\dbControllers\productModelController;
use App\models\productScheme;
use Exception;

class ProductManagement {
    protected $db;
    protected $productDAO;

    public function __construct() {
        $this->db = new MysqlDatabase();
        $this->productDAO = new productModelController($this->db);
    }

    public function addProduct() {
        // Handle POST request data
        $postData = json_decode(file_get_contents('php://input'), true);

        // Validate and sanitize data as needed
        $name = htmlspecialchars($postData['name'] ?? '');
        $type = htmlspecialchars($postData['type'] ?? '');
        $price = htmlspecialchars($postData['price'] ?? '');
        $sku = htmlspecialchars($postData['sku'] ?? '');
        $specificAttribute = htmlspecialchars($postData['specific_attribute'] ?? '');

        // Create ProductScheme object
        $product = new productScheme();
        $product->setName($name);
        $product->setType($type);
        $product->setPrice($price);
        $product->setSKU($sku);
        $product->setspecific_attribute($specificAttribute);

        try {
            if ($this->productDAO->checkSKU($product->getSKU())) {
                http_response_code(406);
                echo json_encode(["status" => "failed", "message" => "SKU already exists."]);
                return;
            }
            $this->productDAO->createProduct($product);
            http_response_code(200);
            echo json_encode(["status" => "success", "message" => "Product added successfully."]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "failed", "message" => $e->getMessage()]);
        }
    }

    public function getProducts() {
        $allProducts = $this->productDAO->getAllProducts();
        if ($allProducts) {
            $products = [];
            foreach ($allProducts as $product) {
                $products[] = [
                    "Name" => $product->getName(),
                    "SKU" => $product->getSKU(),
                    "Price" => $product->getPrice(),
                    "Specific_Attribute" => $product->getspecific_attribute(),
                    "Type" => $product->getType()
                ];
            }
            echo json_encode($products);
        } else {
            echo json_encode(["status" => "failed", "message" => "No products found."]);
        }
    }

    public function getSpecificProduct($sku) {
        $product = $this->productDAO->getProduct($sku);
        if ($product) {
            echo json_encode([
                "Name" => $product->getName(),
                "SKU" => $product->getSKU(),
                "Price" => $product->getPrice(),
                "Specific_Attribute" => $product->getSpecificAttribute(),
                "Type" => $product->getType()
            ]);
        } else {
            echo json_encode(["status" => "failed", "message" => "Product not found."]);
        }
    }

    public function deleteProduct($sku) {
        try {
            $this->productDAO->deleteProduct($sku);
            echo json_encode(["status" => "success", "message" => "Product deleted successfully."]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "failed", "message" => $e->getMessage()]);
        }
    }
}
