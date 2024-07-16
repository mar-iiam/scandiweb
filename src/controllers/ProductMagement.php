<?php
namespace App\Controllers;
use config\database;
use App\dbControllers\productModelController;
use App\models\productScheme;

class ProductMagement
{
    public function Add_product() {
        // Handle POST request data
        $postData = json_decode(file_get_contents('php://input'), true);

        // Validate and sanitize data as needed
        $name = htmlspecialchars($postData['name'] ?? '');
        $type = htmlspecialchars($postData['type'] ?? '');
        $price = htmlspecialchars($postData['price'] ?? '');
        $sku = htmlspecialchars($postData['sku'] ?? '');
        $specificAttribute = htmlspecialchars($postData['specific_attribute'] ?? '');

        // Create ProductScheme object
        $product = new ProductScheme();
        $product->setName($name);
        $product->settype($type);
        $product->setprice($price);
        $product->setSKU($sku);
        $product->setspecific_attribute($specificAttribute);

        // Initialize Database and DAO
        $db = new Database();
        $userDAO = new ProductModelController($db);

        // Call DAO method to create product
        $userDAO->createProduct($product);

        // Return success message or handle errors accordingly
        echo 'Product added successfully';
    }

    public function getProducts(){
        $db = new Database();
        $userDAO = new productModelController($db);
        $Allproducts=$userDAO->getAllProducts();
        foreach ($Allproducts as $product) {
            echo "Product Details:\n";
            echo "Name: " . $product->getName() . "\n";
            echo "SKU: " . $product->getSKU() . "\n";
            echo "Price: " . $product->getprice() . "\n";
            echo "Specific Attribute: " . $product->getspecific_attribute() . "\n";
            echo "Type: " . $product->gettype() . "\n";
            echo "----------------------\n";
        }
        
    }
    public function getSpecificProduct(){
        $db = new Database();
        $userDAO = new productModelController($db);
        $Reproduct=$userDAO->getProduct('M12');
        if ($Reproduct) {
            echo "Product Details:\n";
            echo "Name: " . $Reproduct->getName() . "\n";
            echo "SKU: " . $Reproduct->getSKU() . "\n";
            echo "Price: " . $Reproduct->getprice() . "\n";
            echo "Specific Attribute: " . $Reproduct->getspecific_attribute() . "\n";
            echo "Type: " . $Reproduct->gettype() . "\n";
        } else {
            echo "Product not found.\n";
        }
    }

    public function delete_product($sku) {
        // Retrieve SKU from route variables

        // Initialize Database and DAO
        $db = new Database();
        $productDAO = new ProductModelController($db);

        // Call DAO method to delete product
        $productDAO->deleteProduct($sku);

        // Return success message or handle errors accordingly
        echo "Product  deleted successfully";
    }
}