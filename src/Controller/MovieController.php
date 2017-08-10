<?php

namespace Controller;

class MovieController extends ControllerAbstract
{
    public function listAction() 
    {
        $movies = $this->app['movie.repository']->findAll();
        
        return $this->render(
                'movies.html.twig',
                ['movies' => $movies]
        );
    }
}
