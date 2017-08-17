<?php

namespace Controller;

use Entity\Review;

class MovieController extends ControllerAbstract
{
    public function listAction() 
    {
        $movies = $this->app['movie.repository']->findby($_GET);
        
        return $this->render(
                'movies.html.twig',
                ['movies' => $movies]
        );
    }
    
    public function ficheMovie($id) 
    {
        $movie = $this->app['movie.repository']->find($id);
        // On récupère l'utilisateur en cours
        $user = $this->app['user.manager']->getUser();       
        
        // GESTION DES COMMENTAIRES
        // 
        // affichage des commentaires
        $reviews = $this->app['review.repository']->findByMovies($id);
        
        
        if(!empty($_POST))
        {
            // enregistrement d'un nouveau commentaire
            $review = new Review();
            $review->setMovie($movie);
            $review->setUser($user);

            $errors = []; 
        
            
            $now = new \DateTime();
            
            $review
               ->setContent($_POST['content'])
               ->setDate_enregistrement($now->format('Y-m-d H:i:s'))                    
            ;
            
            if(empty($_POST['content']))
            {
                $errors['content'] = 'Le message est vide'; 
            }                      
                        
            if(empty($errors))
            { 
                $this->app['review.repository']->save($review);
                $message = '<strong>Votre commentaire a bien été enregistré</strong>';
                $this->addFlashMessage($message, 'success');
                
                // on repasse l'id du film dans la route movie_detail comme stipulé dans controllers
                return $this->redirectRoute('movie_detail', ['id' => $movie->getId()]);
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
            }
        }        
        
        return $this->render(
            'movie_detail.html.twig',
            [
                'movie' => $movie,
                'reviews' => $reviews,
                'user' => $user
            ]
        );
    }
}
