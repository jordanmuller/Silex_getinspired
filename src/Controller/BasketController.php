<?php

namespace Controller;


class BasketController extends ControllerAbstract 
{

    public function basketAction()
    {
  
        $basket = $this->app['basket.manager']->get();

        return $this->render(
            'basket.html.twig',
                [
                    'basket' => $basket,
                    //'box' => $box
                ]
        );
    }
    
    public function deleteBasket($id_box)
    {
        $basket = $this->app['basket.manager']->removeBox($id_box); 
        
        //$this->addFlashMessage('Votre box a bien été supprimé'); 
        
        return $this->redirectRoute('basket');
    }
}