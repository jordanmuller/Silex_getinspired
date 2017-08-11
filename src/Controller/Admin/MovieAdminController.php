<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Movie;


class MovieAdminController extends ControllerAbstract 
{
    public function listAction() 
    {
        $movies = $this->app['movie.repository']->findAll();
        
        return $this->render(
                'admin/movie/admin_movies.html.twig',
                ['movies' => $movies]
        );
    }
    
    public function deleteAction($id)
    {
        $movie = $this->app['movie.repository']->find($id);
        
        // if(empty($category)), on peut écrire le !instanceof différemment 
        if(!$movie instanceof Movie)
        {
            $this->app->abort(404);
        }
        
        // La méthode delete va être définie dans CategoryRepository 
        $this->app['movie.repository']->delete($movie);
        
        $this->addFlashMessage('Le film a été supprimé');
        
        return $this->redirectRoute('admin_movies');
    }
    
    public function registerAction($id = null) 
    {
        if(!is_null($id)){
            // on va chercher le film en BDD
            $movie = $this->app['movie.repository']->find($id);
            
            if(!$movie instanceof Movie){
                $this->app->abort(404);
            }
        }
        else{
            // nouvel objet film
            $movie = new Movie();
        } 
        $errors = []; 
        
        if(!empty($_POST))
        {
            $movie
                ->setTitle($_POST['title'])
                ->setProductionYear($_POST['production_year'])
                ->setNationality($_POST['nationality'])
                ->setSynopsis($_POST['synopsis'])
                ->setDirector($_POST['director'])
                ->setActors($_POST['actors'])
                ->setGender($_POST['gender'])
                ->setTrailer($_POST['trailer'])
                ->setPoster($_POST['poster'])
                ->setPrice($_POST['price'])
            ;
            
            if(empty($_POST['title']))
            {
                $errors['title'] = 'Le titre est obligatoire'; 
            }                      
            
            if(empty($_POST['production_year']))
            {
                $errors['production_year'] = 'Veuillez indiquer l\'année de production du film'; 
            }
            
            if(empty($_POST['nationality']))
            {
                $errors['nationality'] = 'Veuillez indiquer la nationalité du film';
            }
            
            if(empty($_POST['synopsis']))
            {
                $errors['synopsis'] = 'Veuillez écrire le synopsis du film';
            }
            elseif(iconv_strlen($_POST['synopsis']) < 50)
            {
                $errors['synopsis'] = 'Le synopsis doit avoir un minimum de 50 caractères';
            }
            
            if(empty($_POST['director']))
            {
                $errors['director'] = 'Veuillez renseigner le nom du réalisateur'; 
            }
            
            if(empty($_POST['actors']))
            {
                $errors['actors'] = 'Veuillez renseigner le nom du réalisateur'; 
            }
            
            if(empty($_POST['gender']))
            {
                $errors['gender'] = 'Veuillez renseigner le nom des acteurs'; 
            }
            
            if(empty($_POST['trailer']))
            {
                $errors['trailer'] = 'Veuillez ajouter la bande-annonce du film'; 
            }
            
            if(empty($_POST['poster']))
            {
                $errors['poster'] = 'Veuillez ajouter l\'affiche du film'; 
            }
            
            if(empty($_POST['price']))
            {
                $errors['price'] = 'Veuillez ajouter un prix au film'; 
            }
            
            
            
            if(empty($errors))
            { 
                $this->app['movie.repository']->save($movie); 
                
                return $this->redirectRoute('admin_movies');
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
            }
        }
        
        return $this->render(
            'admin/movie/admin_movie_register.html.twig',
            [
                'movie' => $movie
            ]
        );
        
    }
}
