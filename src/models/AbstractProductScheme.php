<?php
namespace App\models;

abstract class AbstractProductScheme {
    private $id;
    private $SKU;
    private $name;
    private $price;
    private $specific_attribute;
    private $type;

    // Setter for ID
    public function setId($id) {
        $this->id = $id;
    }

    // Getter for ID
    public function getId() {
        return $this->id;
    }

    // Setter for Name
    public function setName($name) {
        $this->name = $name;
    }

    // Getter for Name
    public function getName() {
        return $this->name;
    }

    // Setter for SKU
    public function setSKU($SKU) {
        $this->SKU = $SKU;
    }

    // Getter for SKU
    public function getSKU() {
        return $this->SKU;
    }

    // Setter for Price
    public function setPrice($price) {
        $this->price = $price;
    }

    // Getter for Price
    public function getPrice() {
        return $this->price;
    }

    // Setter for Type
    public function setType($type) {
        $this->type = $type;
    }

    // Getter for Type
    public function getType() {
        return $this->type;
    }

    // Setter for Specific Attribute
    public function setSpecificAttribute($specific_attribute) {
        $this->specific_attribute = $specific_attribute;
    }

    // Getter for Specific Attribute
    public function getSpecificAttribute() {
        return $this->specific_attribute;
    }
}
?>
