<?php

namespace Entity;

class Note 
{
    private $id_movie_note;
    private $movie;
    private $note;
    private $user;
    
    function getId_movie_note() {
        return $this->id_movie_note;
    }

    function getMovie() {
        return $this->movie;
    }

    function getNote() {
        return $this->note;
    }

    function getUser() {
        return $this->user;
    }

    function setId_movie_note($id_movie_note) {
        $this->id_movie_note = $id_movie_note;
        return $this;
    }

    function setMovie(Movie $movie) {
        $this->movie = $movie;
        return $this;
    }

    function setNote($note) {
        $this->note = $note;
        return $this;
    }

    function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function getIdUser() 
    {
        if(!is_null($this->user))
        {
            return $this->user->getId_user();
        }
    }    
    
    public function getIdMovie() {
        if(!is_null($this->movie))
        {
            return $this->movie->getId();
        }
    }
}
