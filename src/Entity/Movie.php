<?php

namespace Entity;

class Movie 
{
    private $id;
    private $title;
    private $productionYear;
    private $nationality;
    private $synopsis;
    private $director;
    private $actors;
    private $gender;
    private $trailer;
    private $poster;
    private $mark;
    private $price;
    
    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getProductionYear() {
        return $this->productionYear;
    }

    function getNationality() {
        return $this->nationality;
    }

    function getSynopsis() {
        return $this->synopsis;
    }

    function getDirector() {
        return $this->director;
    }

    function getActors() {
        return $this->actors;
    }

    function getGender() {
        return $this->gender;
    }

    function getTrailer() {
        return $this->trailer;
    }

    function getPoster() {
        return $this->poster;
    }

    function getMark() {
        return $this->mark;
    }

    function getPrice() {
        return $this->price;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    function setProductionYear($productionYear) {
        $this->productionYear = $productionYear;
        return $this;
    }

    function setNationality($nationality) {
        $this->nationality = $nationality;
        return $this;
    }

    function setSynopsis($synopsis) {
        $this->synopsis = $synopsis;
        return $this;
    }

    function setDirector($director) {
        $this->director = $director;
        return $this;
    }

    function setActors($actors) {
        $this->actors = $actors;
        return $this;
    }

    function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }

    function setTrailer($trailer) {
        $this->trailer = $trailer;
        return $this;
    }

    function setPoster($poster) {
        $this->poster = $poster;
        return $this;
    }

    function setMark($mark) {
        $this->mark = $mark;
        return $this;
    }

    function setPrice($price) {
        $this->price = $price;
        return $this;
    }
    
    // On crée cette méthode dans l'objet pour savoir si la photo est située dans le répertoire locale ou à distance
    // On appelle cette fonction dans twig : movie.hasPhotoLocale
    public function hasPhotoLocale() 
    {
        if (strstr($this->getPoster(), 'http'))
        {
            return false;
        }
        else {
            return true;
        }
    }

}
