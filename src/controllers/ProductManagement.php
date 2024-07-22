<?php

namespace App\controllers;

use config\MysqlDatabase;
use App\dbControllers\productModelController;
use App\models\productScheme;
use Exception;
class ProductManagement extends AbstractProductManagement{

    public function __construct() {
        $db = new MysqlDatabase();
        $productDAO = new productModelController($db);
        parent::__construct($db, $productDAO);
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
        $product->setSpecificAttribute($specificAttribute);

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
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *'); // Allow requests from any origin
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Allow methods
        header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allow headers
        $allProducts = $this->productDAO->getAllProducts();
        if ($allProducts) {
            $products = [];
            foreach ($allProducts as $product) {
                $products[] = [
                    "Name" => $product->getName(),
                    "SKU" => $product->getSKU(),
                    "Price" => $product->getPrice(),
                    "Specific_Attribute" => $product->getSpecificAttribute(),
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

    public function deleteProduct() {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *'); // Allow requests from any origin
        header('Access-Control-Allow-Methods: GET, POST,DELETE, OPTIONS'); // Allow methods
        header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allow headers
      // Get the raw body
    $body = file_get_contents('php://input');
    
    // Decode JSON body into an array
    $data = json_decode($body, true);
    
    // Ensure the data is an array
    if (!is_array($data) || empty($data)) {
        // Respond with an error
        echo json_encode(['error' => 'Invalid input']);
        http_response_code(400);
        return;
    }
    
    // Process the array of IDs
    foreach ($data as $sku) {
        // Delete the product with the given ID
        // (Implement your deletion logic here)
        $this->productDAO->deleteOneProduct($sku);
    }

    // Respond with success
    echo json_encode(['success' => true]);
    http_response_code(200);
    }
}
