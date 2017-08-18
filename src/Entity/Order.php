<?php

namespace Entity;

class Order {
    private $id_order;
    private $id_user;
    private $price;
    private $register_date;
    private $state;
    
    public function getId_order() {
        return $this->id_order;
    }

    public function getId_user() {
        return $this->id_user;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getRegister_date() {
        return $this->register_date;
    }

    public function getState() {
        return $this->state;
    }

    public function setId_order($id_order) {
        $this->id_order = $id_order;
        return $this;
    }

    public function setId_user($id_user) {
        $this->id_user = $id_user;
        return $this;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    public function setRegister_date($register_date) {
        $this->register_date = $register_date;
        return $this;
    }

    public function setState($state) {
        $this->state = $state;
        return $this;
    }
    
}
