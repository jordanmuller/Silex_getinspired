<?php

namespace Entity;

class Liste
{
    private $id_list;
    private $title;
    private $description;
    private $picture;
    private $user;
    private $movie;
    
    function getId_list() {
        return $this->id_list;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getPicture() {
        return $this->picture;
    }

    function getUser() {
        return $this->user;
    }

    function getMovie() {
        return $this->movie;
    }

    function setId_list($id_list) {
        $this->id_list = $id_list;
        return $this;
    }

    function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    function setPicture($picture) {
        $this->picture = $picture;
        return $this;
    }

    function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    function setMovie(Movie $movie) {
        $this->movie = $movie;
        return $this;
    }


}
