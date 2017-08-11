<?php

namespace Repository;

use Entity\Movie;

class MovieRepository extends RepositoryAbstract
{
    protected function getTable() 
    {
        return 'movies';
    }
    
    private function buildEntity(array $data)
    {
        $movie = new Movie();
        
        
        $movie
            ->setId($data['id_movie'])
            ->setTitle($data['title'])
            ->setProductionYear($data['production_year'])
            ->setNationality($data['nationality'])
            ->setSynopsis($data['synopsis'])
            ->setDirector($data['director'])
            ->setActors($data['actors'])
            ->setGender($data['gender'])
            ->setTrailer($data['trailer'])
            ->setPoster($data['poster'])
            ->setMark($data['mark'])
            ->setPrice($data['price'])
        ;

        // Après on renvoie l'objet $category et ses valeurs
        return $movie;
    }
    
    public function findAll() {
        $query = "SELECT * FROM movies";
        
        $dbMovies = $this->db->fetchAll($query);
        
        $movies = [];
        
        foreach($dbMovies AS $dbMovie)
        {
            $movie = $this->buildEntity($dbMovie);
            
            $movies[] = $movie;
        }
        
        return $movies;
    }
    
    public function findby(array $filters)
    {
        $query = "SELECT * FROM movies WHERE true";
                
        if(!empty($_GET['title']))
        {
            $query .= " AND title  LIKE '%" . addslashes($_GET['title']) . "%'";
        }
        if(!empty($_GET['actors']))
        {
            $query .= " AND actors LIKE '%" . addslashes($_GET['actors']) . "%'";
        }
        if(!empty($_GET['production_year']))
        {
            $query .= " AND production_year LIKE '%" . addslashes($_GET['production_year']) . "%'";
        }
        if(!empty($_GET['gender']))
        {
            $query .= " AND gender LIKE '%" . addslashes($_GET['gender']) . "%'";
        }
        
        // Preparation de la requete
        // 
        // exécution de la requete
        $dbMovies = $this->db->fetchAll($query);
        
        $movies = [];
        
        foreach($dbMovies AS $dbMovie)
        {
            $movie = $this->buildEntity($dbMovie);
            
            $movies[] = $movie;
        }
        
        return $movies;
    }
}
