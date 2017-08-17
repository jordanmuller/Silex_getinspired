<?php

namespace Repository;

use Entity\Box;

class BoxRepository extends RepositoryAbstract{
    
    protected function getTable(){
        return 'box';
    }
    
    public function findAll() {
        $query = 'SELECT * FROM box';
        
        $dbBoxes = $this->db->fetchAll($query);
        
        $boxes = [];
        
        foreach($dbBoxes as $dbBox){
            $box = $this->buildEntity($dbBox);
            
            $boxes[] = $box;            
        }
        
        return $boxes;
    }
    
    public function find($id) {
        $dbBox = $this->db->fetchAssoc(
            'SELECT * FROM box WHERE id_box=:id',
            [
                ':id' => $id
            ]
        );
        
        if(!empty($dbBox)){
            return $this->buildEntity($dbBox);
        }
    }
    
    public function save(Box $box) {
        // les données à enregistrer en BDD
        $data = ['titre' => $box->getTitle(),
                 'contenu' => $box->getContent(),
                 'stock' => $box->getStock()
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
        
        if(empty($box->getId())){
            $box->setId($this->db->lastInsertId());
        }
    }
    
    public function saveMovies(Box $box, array $movieIds)
    {
        $this->db->delete('detail_box', ['id_box' => $box->getId()]);
        
        foreach ($movieIds as $movieId) {
            $this->db->insert(
                'detail_box', 
                [
                    'id_box' => $box->getId(),
                    'id_movie' => $movieId
                ]
            );
        }
    }
    
    
    public function delete(Box $box) {
        $this->db->delete(
            'box',
            ['id_box' => $box->getId()]
        );
    }
    
    public function deleteBasket(Box $box) {
        $this->db->delete(
            'box',
            ['id_box' => $box->getId()] 
        );
    }
    
    private function buildEntity(array $data) {
        $box = new Box();
        
        $box    ->setId($data['id_box'])
                ->setTitle($data['titre'])
                ->setContent($data['contenu'])
                ->setPrice($data['prix'])
                ->setStock($data['stock'])
        ;
        
        return $box;
    }
}
