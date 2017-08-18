<?php

namespace Repository;

use Entity\Movie;
use Entity\Review;
use Entity\User;

class ReviewRepository extends RepositoryAbstract
{
    protected function getTable()
    {
        return 'reviews'; 
    }
    
    public function findByMovies($id) 
    {
        $dbReviews = $this->db->fetchAll(
            'SELECT r.content, r.date_enregistrement, u.pseudo, u.avatar, u.id_user, m.id_movie, r.id_review '
                . 'FROM reviews r '
                . 'JOIN movies m ON m.id_movie = r.id_movie '
                . 'JOIN users u ON u.id_user = r.id_user '
                . 'WHERE m.id_movie = :id '
                . 'ORDER BY r.date_enregistrement ASC LIMIT 0, 5',
                
        [
                ':id' => $id
            ]
        );
        
        $reviews = [];
        
        foreach($dbReviews AS $dbReview)
        {
            $review = $this->buildEntity($dbReview);
            
            $reviews[] = $review;
        }
        
        return $reviews;
    }
    
    public function save(Review $review)
    {
        // les données à enregistrer en BDD
        $data = [
            //  On utilise les méthodes définies dans Entity Review, une fois que les objets $movie et $user ont été créés en propriété
            'id_user'  => $review->getIdUser(),
            'id_movie'  => $review->getIdMovie(),
            'content'  => $review->getContent(),
            'date_enregistrement' => $review->getDate_enregistrement()
        ];
        
        // si le commentaire a un id, on est en update
        // sinon en insert
        $where = !empty($review->getId_review())
        ? ['id_review' => $review->getId_review()]
        : null; 
        
        // appel à la méthode en Repository\Abstract pour enregistrer
        $this->persist($data, $where);
        
        // on set l'id quand on est en insert
        if (empty($review->getId_review()))
        {
            $review->setId_review($this->db->lastInsertId());
        }
    }
    
    
    
    private function buildEntity(array $data)
    {
        $user = new User();
        
        $user
            ->setId_user($data['id_user'])
            ->setPseudo($data['pseudo'])
            ->setAvatar($data['avatar'])
                
        ;
        
        $movie = new Movie();
        
        $movie
            ->setId($data['id_movie']);
        
        
        
        $review = new Review(); 
        
        $review
            ->setId_review($data['id_review'])
            ->setUser($user)
            ->setMovie($movie)
            ->setContent($data['content'])
            ->setDate_enregistrement($data['date_enregistrement'])
        ;
        return $review; 
    }
}
