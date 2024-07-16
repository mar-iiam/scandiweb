<?php
namespace App\Controllers;
use config\MysqlDatabase;
use App\dbControllers\productModelController;
use App\models\productScheme;
use Exception;
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
        $db = new MysqlDatabase();
        $userDAO = new ProductModelController($db);
        try {
            if ($userDAO->checkSKU($product->getSKU())) {
                http_response_code(406); 
                echo json_encode(["status" => "faild", "message" => "SKU already exists."]);
                return;
            }
            http_response_code(200); 
            $userDAO->createProduct($product);
            echo json_encode(["status" => "success", "message" => "Product added successfully."]);
        } catch (Exception $e) {
           
            // Set appropriate HTTP status code (e.g., 400 for bad request, 500 for internal server error)
            http_response_code(500); 
            // Send error message as JSON response
            
        }
    }

    public function getProducts(){
        $db = new MysqlDatabase();
        $userDAO = new productModelController($db);
        $Allproducts=$userDAO->getAllProducts();
        if($Allproducts){
            foreach ($Allproducts as $product) {
                echo json_encode(["Name" => $product->getName(),
                 "SKU" => $product->getSKU(),
                 "Price" => $product->getprice(),
                 "Price" => $product->getprice(),
                 "Specific_Attribute" => $product->getspecific_attribute(),
                 "type"=> $product->gettype()
                ]);
                
            }
        }else {
            echo "No products found ";
        }
     
        
    }
    public function getSpecificProduct(){
        $db = new MysqlDatabase();
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
        $db = new MysqlDatabase();
        $productDAO = new ProductModelController($db);

        // Call DAO method to delete product
        $productDAO->deleteProduct($sku);

        // Return success message or handle errors accordingly
        echo "Product  deleted successfully";
    }
}