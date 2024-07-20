<?php

namespace App\controllers;

abstract class AbstractProductManagement {
    protected $db;
    protected $productDAO;

    public function __construct($db, $productDAO) {
        $this->db = $db;
        $this->productDAO = $productDAO;
    }

    abstract public function addProduct();

    abstract public function getProducts();

    abstract public function getSpecificProduct($sku);

    abstract public function deleteProduct();
}
?>
