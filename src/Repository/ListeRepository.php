<?php

namespace Repository;

use Entity\Liste;
use Entity\Movie;
use Entity\User;

class ListeRepository extends RepositoryAbstract 
{
    protected function getTable() 
    {
        return 'lists';
    }
    
    private function buildEntity(array $data)
    {
        $user = new User();
        
        $user
            ->setId_user($data['id_user'])
            ->setPseudo($data['pseudo'])
          
        ;
        /*
        $movie = new Movie();
               
        $movie
            ->setId($data['id_movie'])
            
        ;
         * 
         */
        // On crée un nouvel objet à partir de la classe Liste présente dans Entity
        $liste = new Liste();

        // On attribue des valeurs à l'objet en récupérant les données en BDD suite à l'instanciation de la classe category ci-dessus
        $liste
            ->setId_list($data['id_list'])
            ->setTitle($data['list_title'])
            ->setDescription($data['description'])
            ->setPicture($data['picture'])
            ->setUser($user)
           // ->setMovie($movie)
        ;

        // Après on renvoie l'objet $category et ses valeurs
        return $liste;
    }
    
     public function findAll($withMovies = true) 
    {
        $query = 'SELECT * FROM lists l '
                //. 'LEFT JOIN list_detail ld ON l.id_list = ld.id_list '
                . 'LEFT JOIN users u ON l.id_user = u.id_user '
                
        ;
                
        $dbListes = $this->db->fetchAll($query);
        
        $listes = [];
        
        foreach($dbListes AS $dbListe)
        {
            $liste = $this->buildEntity($dbListe);
            
            if ($withMovies) {
                $movies = $this->app['movie.repository']->findByListeId($liste->getId_list());
                $liste->setMovies($movies);
            }
            
            $listes[] = $liste;
        }
        return $listes;
    }
    
    public function save(Liste $liste) 
    {
        // les données à enregistrer en BDD
        $data = ['title' => $liste->getTitle(),
                 'description' => $liste->getDescription(),
                 'picture' => $liste->getPicture(),
                 'user' => $liste->getUserId(),
                 'movie' => $liste->getMovieId()
                ];

        
        // si la liste a un id, on est en update
        // sinon en insert
        $where = !empty($liste->getId())
            ? ['id_list' => $liste->getId()]
            : null
        ;
        
        // appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data, $where);
        
        if(empty($liste->getId())){
            $liste->setId($this->db->lastInsertId());
        }
    }
}
