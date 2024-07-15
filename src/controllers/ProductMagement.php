<?php
namespace App\Controllers;
use config\database;
use App\dbControllers\productModelController;
use App\models\productScheme;

class ProductMagement
{
    
    public function Add_product()
    {
        $db = new Database();
        $userDAO = new productModelController($db);
        $product = new productScheme();
        $product->setName('Eva Serum');
        $product->settype('Skin care');
        $product->setprice('200');
        $product->setSKU('ER33');
        $product->setspecific_attribute('20g');
        $userDAO->createProduct($product);
        echo 'Product added successfuly';
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

    public function delete_product(){
        $db = new Database();
        $userDAO = new productModelController($db);
        $userDAO->deleteProduct('M12');
    }
}