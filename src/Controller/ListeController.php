<?php

namespace Controller;

use Entity\Liste;
use Entity\Movie;
use Entity\User;

class ListeController extends ControllerAbstract
{
    public function listAction() 
    {
          
        $listes = $this->app['liste.repository']->findAll();
        
        
        return $this->render(
            'liste/listes_list.html.twig',
            [
               'listes' => $listes,
          //     'movies' => $movies
            ]
        );
    }
    
    public function registerListeAction($id = null)
    {
        if(!is_null($id)){
            // on va chercher la catégorie en BDD
            $liste = $this->app['liste.repository']->find($id);
            
            if(!$liste instanceof Liste){
                $this->app->abort(404);
            }
        }
        else{
            $liste = new Liste();
            $liste->setUser(new User());
            $liste->setMovie(new Movie());
        } 
        $errors = []; 
        
        if(!empty($_POST))
        {
            $liste
               ->setTitle($_POST['title'])        
               ->setDescription($_POST['description'])
               ->setPicture($_POST['picture'])         
            ;
             $liste->getUser()->setId($_POST['user']);
             $liste->getMovie()->setId($_POST['movie']);
             
             // On a besoin de la liste des films pour construire le select
            // dans le formulaire
            $movies = $this->app['movie.repository']->findAll();
            
            if(empty($_POST['title']))
            {
                $errors['title'] = 'Le titre est obligatoire'; 
            }                      
            
            if(empty($_POST['description']))
            {
                $errors['description'] = 'La description est obligatoire'; 
            }
            elseif(iconv_strlen ($_POST['description']) < 50)
            {
                $errors['content'] = 'La description doit avoir un minimum de 50 caractères';
            }
            
            if(empty($_POST['picture']))
            {
                $errors['picture'] = 'Votre liste doit être illustrée'; 
            }
            
            if(empty($errors))
            { 
                $this->app['liste.repository']->save($liste); 
                
                return $this->redirectRoute('homepage');
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
            }
        }
        
        return $this->render(
            'liste/liste_register.html.twig',
            [
                'liste' => $liste,
                'user' => $user,
                'movies' => $movies
            ]
        );
    }
}
