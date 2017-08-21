<?php

namespace Controller;

use Entity\Order;


class BasketController extends ControllerAbstract 
{

    public function basketAction()
    {
  
        $basket = $this->app['basket.manager']->get();
        //echo '<pre>'; var_dump($_POST); echo '</pre>';
        return $this->render(
            'basket.html.twig',
                [
                    'basket' => $basket
                    //'box' => $box
                ]
        );
    }
    
    public function deleteBasket($id_box)
    {
        $basket = $this->app['basket.manager']->removeBox($id_box); 
        
        $this->addFlashMessage('Votre box a bien été supprimé'); 
        
        return $this->redirectRoute('basket');
    }
    
    public function emptyBasket() 
    {
        $basket = $this->app['basket.manager']->removeAll();
        
        $this->addFlashMessage('Votre panier a été vidé');
        
        return $this->redirectRoute('basket');
    }
    
    public function payBasket() 
    {
        // On récupère la session en cours l'objet $user grâce à user.manager
        $user = $this->app['user.manager']->getUser();
        echo '<pre>'; var_dump($user); echo '</pre>';
        //echo '<pre>'; var_dump($_POST); echo '</pre>';
        
        // Enregistrement d'une nouvelle commande
        if (!empty($_POST))
        {
            // Objet de la classe DateTime pour pouvoir formater la date
            $now = new \DateTime();
            
            $order = new Order();
            
            $order->setUser($user);
            $order->setPrice($_POST['price']);
            $order->setRegister_Date($now->format('Y-m-d H:i:s'));
             
             $errors = [];
             
            if(empty($_POST['price']))
            {
                $errors['price'] = 'Il doit y avoir un prix'; 
            }
            //echo '<pre>'; var_dump($errors); echo '</pre>';
            if(empty($errors))
            { 
                $this->app['order.repository']->save($order);
                $message = '<strong>Votre commande a bien été enregistrée</strong>';
                $this->addFlashMessage($message, 'success');
                
                // on repasse l'id du film dans la route movie_detail comme stipulé dans controllers
                return $this->redirectRoute('basket');
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
                
                
            }            
        }
        
        
        
        
    }
}