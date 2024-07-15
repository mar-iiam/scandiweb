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


