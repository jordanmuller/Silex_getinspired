<?php

namespace Repository;

class ListeRepository extends RepositoryAbstract 
{
    protected function getTable() 
    {
        return 'lists';
    }
    
    private function buildEntity(array $data)
    {
        $category = new Category();
        
        $category 
            ->setId($data['category_id'])
            ->setName($data['name'])
        ;
        // On crée un nouvel objet à partir de la calsse Catégory présente dans Entity
        $liste = new Liste();

        // On attribue des valeurs à l'objet en récupérant les données en BDD suite à l'instanciation de la classe category ci-dessus
        $liste
            ->setId($data['id'])
            ->setTitle($data['title'])
            ->setContent($data['content'])
            ->setUser($user)
            ->setMovie($movie)
        ;

        // Après on renvoie l'objet $category et ses valeurs
        return $liste;
    }
}
