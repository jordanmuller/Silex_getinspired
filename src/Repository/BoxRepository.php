<?php

namespace Repository;

use Entity\Box;

class BoxRepository extends RepositoryAbstract{
    
    protected function getTable(){
        return 'box';
    }
    
    public function save(Box $box) {
        // les données à enregistrer en BDD
        $data = ['titre' => $box->getTitle(),
                 'contenu' => $box->getContent(),
                ];

        if (!empty($box->getPrice())) {
            $data['prix'] = $box->getPrice();
        }
        
        // si la catégorie a un id, on est en update
        // sinon en insert
        $where = !empty($box->getId())
            ? ['id_box' => $box->getId()]
            : null
        ;
        
        // appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data, $where);
        
        // on set l'id quand on est en insert
        if(empty($box->getId())){
            $box->setId($this->db->lastInsertId());
        }
    }
    
    private function buildEntity(array $data) {
        $box = new Box();
        
        $box    ->setId($data['id_box'])
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->setPrice($data['price'])
        ;
        
        return $box;
    }
}
