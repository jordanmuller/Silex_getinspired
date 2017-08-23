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
    
     public function find($id) 
    {
        $query = "SELECT * FROM lists l "
                . "LEFT JOIN users u ON l.id_user = u.id_user "
                . "LEFT JOIN list_detail ld ON ld.id_list = l.id_list "
                . "LEFT JOIN movies m ON m.id_movie = ld.id_movie "
                . "WHERE l.id_list = :id";
        
        $dbList = $this->db->fetchAssoc(
            $query,
            [
                ':id' => $id
            ]
        );
        
        if(!empty($dbList))
        {
            //On crée l'entity à partir de ce que l'on récupère dans la BDD
            return $this->buildEntity($dbList);
        }
    }
    
    public function save(Liste $liste) 
    {
        // les données à enregistrer en BDD
        $data = ['list_title' => $liste->getTitle(),
                 'description' => $liste->getDescription(),
                 'picture' => $liste->getPicture(),
                 'id_user' => $liste->getUserId()
                ];

                
        // si la liste a un id, on est en update
        // sinon en insert
        $where = !empty($liste->getId_list())
            ? ['id_list' => $liste->getId_list()]
            : null
        ;
        
        // appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data, $where);
        
        if(empty($liste->getId_list())){
            $liste->setId_list($this->db->lastInsertId());
        }
    }
    
    public function saveMovies(Liste $list, array $movieIds)
    {
        $this->db->delete('list_detail', ['id_list' => $list->getId_list()]);
        
        foreach ($movieIds as $movieId) {
            $this->db->insert(
                'list_detail', 
                [
                    'id_list' => $list->getId_list(),
                    'id_movie' => $movieId
                ]
            );
        }
    }
    
    public function delete(Liste $liste) 
    {
        // Méthode delete de Doctrine, 1er argument le nom de la table, deuxieme argument le champ correspondant pour entrainer la suppression
        $this->db->delete(
            'lists',
            ['id_list' => $liste->getId_list()]
        );
    }
}
