<?php

namespace Controller;

use Entity\Review;
use Entity\Note;

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
        
        
        // GESTION DES NOTES
        
        // affichage de la moyennes
        $moyennes = $this->app['note.repository']->moyenneByMovie($id);
//        echo '<pre>'; var_dump($moyennes); echo '</pre>';
        
        $notes = $this->app['note.repository']->findByMovies($id);
        
        
        // GESTION DES COMMENTAIRES
        
        // affichage des commentaires
        $reviews = $this->app['review.repository']->findByMovies($id);
        
        
        if(!empty($_POST))
        {
            if(!$this->app['user.manager']->getUser()){
                $message = '<strong>Vous devez être connecté pour poster un commentaire/noter un film</strong>';
                $this->addFlashMessage($message, 'error');  
                return $this->redirectRoute('user_login');              
            }
            
            if(!empty($_POST['rating']))
            {
                $note = new Note();
                $note->setMovie($movie);
                $note->setUser($user);

                $errors = [];

                $note->setNote($_POST['rating']);

                if(empty($_POST['rating']))
                {
                     $errors['rating'] = 'Vous devez saisir une note'; 
                }

                if(empty($errors))
                { 
                    $this->app['note.repository']->save($note);
                    $message = '<strong>Votre note a bien été enregistrée</strong>';
                    $this->addFlashMessage($message, 'success');

                }
                else
                {
                    $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                    $message .='<br>' . implode('<br>', $errors); 
                    $this->addFlashMessage($message, 'error'); 
                }
            }

            // enregistrement d'un nouveau commentaire
            $review = new Review();
            $review->setMovie($movie);
            $review->setUser($user);
            
            $errors = [];        
            
            $now = new \DateTime();
            
            $review
               ->setContent($_POST['content'])
               ->setDate_enregistrement($now->format('Y-m-d H:i:s'))
//               ->setSignale($_POST['signale'])
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
                'user' => $user,
                'notes' => $notes,
                'moyennes' => $moyennes,
            ]
        );
    }
}
