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
        // les données à enregistrer en BDD
        $data = [
                 'id_user' => $order->getId_user(),
                 'price' => $order->getPrice(),
                 'register_date' => $order->getRegister_date(),
                 'state' => $order->getState()
                ];

        if (!empty($order->getPrice())) {
            $data['price'] = $order->getPrice();
        }
        
        // si la commande a un id, on est en update
        // sinon en insert
        $where = !empty($order->getId())
            ? ['id_order' => $order->getId()]
            : null
        ;
        
        // appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data, $where);
        
        if(empty($order->getId())){
            $order->setId($this->db->lastInsertId());
        }
    }
    
    private function buildEntity(array $data) {
        $order = new Order();
        
        $order  ->setId_order($data['id_order'])
                ->setId_user($data['id_user'])
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
             ['id_order' => $user->getId_order()]
        );  
        
    }
}
