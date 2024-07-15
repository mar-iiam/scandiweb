<?php
namespace App\models;
class productScheme {
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

     // Setter for price
     public function setprice($price) {
        $this->price = $price;
    }

    // Getter for SKU
    public function getprice() {
        return $this->price;
    }

     // Setter for type
     public function settype($type) {
        $this->type = $type;
    }

    // Getter for type
    public function gettype() {
        return $this->type;
    }
    public function setspecific_attribute($specific_attribute){
        $this->specific_attribute = $specific_attribute;
    }
    public function getspecific_attribute (){
        return $this->specific_attribute;
    }
}

?>
