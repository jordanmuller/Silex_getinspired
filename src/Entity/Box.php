<?php

namespace Entity;

class Box {
    private $id_box;
    private $title;
    private $content;
    private $price;
    private $stock;
    
    function getId() {
        return $this->id_box;
    }

    function getTitle() {
        return $this->title;
    }

    function getContent() {
        return $this->content;
    }

    function getPrice() {
        return $this->price;
    }
    
    function getStock() {
        return $this->stock;
    }

    function setId($id_box) {
        $this->id_box = $id_box;
        return $this;
    }

    function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    function setContent($content) {
        $this->content = $content;
        return $this;
    }

    function setPrice($price) {
        if (!empty($price)) {
            $this->price = $price;
        }
        return $this;
    }    
    
    function setStock($stock) {
        $this->stock = $stock;
        return $this;
    }
}
