<?php

namespace Controller;

class BoxController extends ControllerAbstract {
    public function listBoxAction()
    {
        $boxes = $this->app['box.repository']->findAll();
        
        return $this->render(
            'box_list.html.twig',
            [
                'boxes' => $boxes
            ]
        );
    }
    
    public function detailBoxAction($id) 
    {
        $box = $this->app['box.repository']->find($id);
        $movies = $this->app['movie.repository']->findByBoxId($id);
        
        // Formulaire d'ajout au panier 
        if (!empty($_POST)) {
            $this->app['basket.manager']->addBox($box, $_POST['quantity']);
            
            return $this->redirectRoute('basket');
        }
        
        return $this->render(
            'box_detail.html.twig',
            [
                'box' => $box,
                'movies' => $movies
            ]
        );
    }
}
