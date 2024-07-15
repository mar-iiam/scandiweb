<?php
namespace App\controllers;
require '../../vendor/autoload.php';

use config\database;
use App\dbControllers\productModelController;
use App\models\productScheme;
// Create a new database connection
$db = new Database();

// Create a new UserDAO instance
$userDAO = new productModelController($db);

// Create a new User instance and set properties
$product = new productScheme();
$product->setName('mouse');
$product->settype('electronic');
$product->setprice('200');
$product->setSKU('M12');
$product->setspecific_attribute('hello');

// Save the product to the database
//$userDAO->createProduct($product);
$Reproduct=$userDAO->getProduct('M12');
if ($product) {
    echo "Product Details:\n";
    echo "Name: " . $product->getName() . "\n";
    echo "SKU: " . $product->getSKU() . "\n";
    echo "Price: " . $product->getprice() . "\n";
    echo "Specific Attribute: " . $product->getspecific_attribute() . "\n";
    echo "Type: " . $product->gettype() . "\n";
} else {
    echo "Product not found.\n";
}
echo "--------------------------------------------------------------";
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

$userDAO->deleteProduct('12sd');



