<?php

namespace Service;

use Entity\Box;
use Entity\Order;
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
            // On passe un tableau vide en argement dans le contenu de $_SESSION['basket'][]
            $this->session->set('basket', []);
        }
    }
    
    // On obtient $_SESSION['basket']['box']
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
            
            // On crée une nouvelle session
            $this->session->set('basket', $basket);
        }
    }
    
    // Fonction pour vider entièrement le panier
    public function removeAll() 
    {
        if ($this->session->has('basket'))
        {
            $basket = $this->session->get('basket');
            
            unset($basket);
            // la méthode ->set() prend une variable ou un tableau en argument si le panier est vide
            $this->session->set('basket', []);
        }
    }
}
