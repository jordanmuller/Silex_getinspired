<?php

namespace Controller;

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
        
        return $this->render(
            'movie_detail.html.twig',
            [
                'movie' => $movie
            ]
        );
    }
}
