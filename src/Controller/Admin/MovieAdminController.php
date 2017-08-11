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
    
    public function deleteAction()
    {
        $movie = $this->app['movie.repository']->find($id);
        
        // if(empty($category)), on peut écrire le !instanceof différemment 
        if(!$movie instanceof Article)
        {
            $this->app->abort(404);
        }
        
        // La méthode delete va être définie dans CategoryRepository 
        $this->app['movie.repository']->delete($movie);
        
        $this->addFlashMessage('Le film a été supprimé');
        
        return $this->redirectRoute('admin_movies');
    }
}
