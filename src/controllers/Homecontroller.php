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
$product->setSKU('12sd');
$product->setspecific_attribute('hello');

// Save the product to the database
$userDAO->createProduct($product);

// Retrieve the product from the database



