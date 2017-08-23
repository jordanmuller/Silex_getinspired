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
            ->setPrice($data['price'])
        ;
        
        if (isset($data['moyenne'])) {
            $movie->setAvg($data['moyenne']);
        }

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
    
    public function find($id) 
    {
        $query = "SELECT * FROM movies WHERE id_movie = :id";
        
        $dbMovie = $this->db->fetchAssoc(
            $query,
            [
                ':id' => $id
            ]
        );
        
        if(!empty($dbMovie))
        {
            return $this->buildEntity($dbMovie);
        }
    }
    
    public function save(Movie $movie) 
    {
        // les données à enregistrer en BDD
        $data = ['title' => $movie->getTitle(),
                 'production_year' => $movie->getProductionYear(),
                 'nationality' => $movie->getNationality(),
                 'synopsis' => $movie->getSynopsis(),
                 'director' => $movie->getDirector(),
                 'actors' => $movie->getActors(),
                 'gender' => $movie->getGender(),
                 'trailer' => $movie->getTrailer(),
                 'poster' => $movie->getPoster(),
                 'price' => $movie->getPrice()
                ];

        
        // si le film a un id, on est en update
        // sinon en insert
        $where = !empty($movie->getId())
            ? ['id_movie' => $movie->getId()]
            : null
        ;
        
        // appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data, $where);
        
        if(empty($movie->getId())){
            $movie->setId($this->db->lastInsertId());
        }
    }
    
    public function delete(Movie $movie) 
    {
        // Méthode delete de Doctrine, 1er argument le nom de la table, deuxieme argument le champ correspondant pour entrainer la suppression
        $this->db->delete(
            'movies',
            ['id_movie' => $movie->getId()]
        );
    }
    public function findBy(array $filters)
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
    
    // On récupère tous les films dont les id sont égaux à ceux de la table detail_box avec la valeur id_box(multiples) 
    public function findByBoxId($id) 
    {
        $dbMovies = $this->db->fetchAll(
            'SELECT m.* FROM movies m '
                . 'JOIN detail_box db ON m.id_movie = db.id_movie '
                . 'WHERE db.id_box = :id',
                
        [
                ':id' => $id
            ]
        );
        
        $movies = [];
        
        foreach($dbMovies AS $dbMovie)
        {
            $movie = $this->buildEntity($dbMovie);
            
            $movies[] = $movie;
        }
        
        return $movies;
        
    }
    
    // On récupère tous le films dont les id sont égaux avec ceux de la table list_detail
    public function findByListeId($id) 
    {
        $dbMovies = $this->db->fetchAll(
            "SELECT m.* FROM movies m "
            . "LEFT JOIN list_detail ld ON m.id_movie = ld.id_movie "
            . "WHERE ld.id_list = :id",
            [
                ':id' => $id
            ]
        );
        
        $movies = [];
        
        foreach($dbMovies AS $dbMovie)
        {
            $movie = $this->buildEntity($dbMovie);
            
            $movies[] = $movie;
        }
        
        return $movies;
    }
    
    public function findByNotes() {
        $dbMovies = $this->db->fetchAll(
            'SELECT m.*, ROUND(AVG(mn.note),1) AS moyenne '
                . 'FROM movie_note mn '
                . 'JOIN movies m ON m.id_movie = mn.id_movie '
                . 'GROUP BY mn.id_movie '
                . 'ORDER BY moyenne DESC LIMIT 0, 6'                
        );
        
        $movies = [];
        
        foreach($dbMovies AS $dbMovie)
        {
            $movie = $this->buildEntity($dbMovie);
            
            $movies[] = $movie;
        }
        
        return $movies;
    }
}





    
   
