<?php

namespace Repository;

class DetailBox extends RepositoryAbstract{
    protected function getTable(){
        return 'detail_box';
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
}
