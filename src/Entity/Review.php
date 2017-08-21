<?php

namespace Entity;

class Review 
{
    private $id_review;
    private $user;
    private $movie;
    private $content;
    private $date_enregistrement;
    
    public function getId_review() {
        return $this->id_review;
    }
    
    public function getUser() {
        return $this->user;
    }

    public function getMovie() {
        return $this->movie;
    }

    public function getContent() {
        return $this->content;
    }
    
    public function getDate_enregistrement() {
        return $this->date_enregistrement;
    }
    
    public function setId_review($id_review) {
        $this->id_review = $id_review;
        return $this;
    }
    
    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setMovie(Movie $movie) {
        $this->movie = $movie;
        return $this;
    }
    
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }  
    
    public function setDate_enregistrement($date_enregistrement) {
        $this->date_enregistrement = $date_enregistrement;
        return $this;
    }
    
    public function getIdUser() {
        if(!is_null($this->user))
        {
            return $this->user->getId_user();
        }
    }
    
    public function getUserPseudo() {
        if(!is_null($this->user)) {
            return $this->user->getPseudo();
        }
    }
    
    public function getUserAvatar() {
        if(!is_null($this->user)) {
            return $this->user->getAvatar();
        }
    }
    
    public function getIdMovie() {
        if(!is_null($this->movie))
        {
            return $this->movie->getId();
        }
    }


}


