<?php

namespace Entity;

class Liste
{
    private $id_list;
    private $title;
    private $description;
    private $picture;
    private $user;
    private $movies = [];
    
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

    function getMovies() {
        return $this->movies;
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

    function setMovies(array $movies) {
        $this->movies = $movies;
        return $this;
    }

    public function getUserId() 
    {
        // Si la propriété catégory qui contient un objet $categry de la classe Category n'est pas null
        if(!is_null($this->user))
        {
            // On récupère l'id grâce à la méthode getId() de la class Category
            return $this->user->getId_user();
        }
    }
    
    public function getUserPseudo() 
    {
        if(!is_null($this->user))
        {
            return $this->user->getPseudo();
        }
    }
    
    public function getMovieId() 
    {
        // Si la propriété catégory qui contient un objet $movie de la classe Category n'est pas null
        if(!is_null($this->movie))
        {
            // On récupère l'id grâce à la méthode getId() de la class Movie
            return $this->movie->getId();
        }
    }
    
    public function getMovieTitle() 
    {
        if(!is_null($this->movie))
        {
            return $this->movie->getTitle();
        }
    }
}
