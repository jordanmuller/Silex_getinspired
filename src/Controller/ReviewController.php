<?php

namespace Controller;

use Entity\Review;

class ReviewController extends ControllerAbstract
{
    public function listAction() 
    {
        $reviews = $this->app['review.repository']->findByMovies($id);
        
        return $this->render(
                'reviews.html.twig',
                ['reviews' => $reviews]
        );
    }
    
    public function registerReviewAction($id = null)
    {
        // nouveau commentaire
        $review = new Review();
        
        $errors = []; 
        
        if(!empty($_POST))
        {
            $review        
               ->setContent($_POST['commentaire'])
               ->setDate_enregistrement(NOW())
                    
            ;
            
            if(empty($_POST['commentaire']))
            {
                $errors['commentaire'] = 'Le message est vide'; 
            }                      
                        
            if(empty($errors))
            { 
                $this->app['box.repository']->save($review);
                
                return $this->redirectRoute('movie_detail');
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
            }
        }
        
        return $this->render(
            'reviews.html.twig',
            [
                'review' => $review
            ]
        );
    }
}
