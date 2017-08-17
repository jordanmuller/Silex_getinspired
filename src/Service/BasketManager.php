<?php

namespace Service;

use Entity\Box;
use Symfony\Component\HttpFoundation\Session\Session;

class BasketManager
{
    
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
        
    }
    
    public function initBasket()
    {
        if (!$this->session->has('basket')) {
            $this->session->set('basket', []);
        }
    }

    public function addBox(Box $box, $qt = 1)
    {
        $this->initBasket();

        $basketEntry = [
            'box' => $box,
            'qt' => $qt
        ];
        
        $basket = $this->session->get('basket');
        // On récupère l'id de la box, donc $basket['id_box'] = 
        $basket[$box->getId()] = $basketEntry;
        
        $this->session->set('basket', $basket);
    }
    
    public function get()
    {
        return $this->session->get('basket');
    }

    public function getTotal()
    {
        $total = 0;
        
        if ($this->session->has('basket')) {
            foreach ($this->session->get('basket') as $element) {
                $elementPrice = $element['box']->getPrice() * $element['qt'];
                //var_dump($elementPrice);
                $total += $elementPrice;
            }
        }
        
        return $total;
    }
    
    public function removeBox($idBox)
    {
        if ($this->session->has('basket')) {
            $basket = $this->session->get('basket');
            
            unset($basket[$idBox]);
            
            $this->session->set('basket', $basket);
        }
    }

}
