<?php

namespace Repository;

use Entity\Order;

class OrderRepository extends RepositoryAbstract{

    protected function getTable(){
        return 'orders';
    }
    
    public function findAll() {
        $query = 'SELECT * FROM orders';
        
        $dbOrders = $this->db->fetchAll($query);
        
        $orders = [];
        
        foreach($dbOrders as $dbOrder){
            $order = $this->buildEntity($dbOrder);
            
            $orders[] = $order;            
        }
        
        return $orders;
    }
    
    public function save(Order $order) {
        
        // les données à enregistrer en BDD, les indices doivent donc correspondre aux champs de la bdd
        $data = [
                 'id_user' => $order->getIdUser(),
                 'price' => $order->getPrice(),
                 'register_date' => $order->getRegister_date(),
                 
                ];
        //echo '<pre>'; var_dump($data); echo '</pre>';

       
        
        // Si $order->getState n'est pas vide, alors $data['state'] vaut par défaut $order->getState();
        // Cela fonctionne lorsque l'on assigne une valeur par défaut à un champ de la bdd
        if (!empty($order->getState())) {
            $data['state'] = $order->getState();
        }
        
        // si la commande a un id, on est en update
        // sinon en insert
        $where = !empty($order->getId_order())
            ? ['id_order' => $order->getId_order()]
            : null
        ;
        
        // appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data, $where);
        
        if(empty($order->getId_order())){
            $order->setId_order($this->db->lastInsertId());
        }
    }
    
    private function buildEntity(array $data) {
        // On crée un nouvel objet user
        $user = new User();
        
        $user
            ->setId_user($data['id_user'])
        ;
        
        $order = new Order();
        
        $order  ->setId_order($data['id_order'])
                ->setUser($user)
                ->setPrice($data['price'])
                ->setRegister_date($data['register_date'])
                ->setState($data['state'])
        ;
        
        return $order;
    }
    
    public function delete(Order $order)
    {
        $this->db->delete(
            'order', 
             ['id_order' => $order->getId_order()]
        );  
        
    }
}
