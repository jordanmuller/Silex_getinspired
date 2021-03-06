<?php

namespace Repository;

use Entity\User;

class UserRepository extends RepositoryAbstract
{
    protected function getTable()
    {
        return 'users'; 
    }
    
    public function find($id) 
    {
        $query = "SELECT * FROM users WHERE id_user = :id";
        
        $dbUser = $this->db->fetchAssoc(
            $query,
            [
                ':id' => $id
            ]
        );
        
        if(!empty($dbUser))
        {
            return $this->buildEntity($dbUser);
        }
    }
    
    
    public function findByEmail($email, $idUser = null)
    {
        $query = 'SELECT * FROM users WHERE email = :email';
        $parameters = [
                ':email' => $email
            ];  
        
        if (!is_null($idUser)) {
            $query .= ' AND id_user != :id';
            $parameters[':id'] = $idUser;
        }
        
        $dbUser = $this->db->fetchAssoc(
            $query, 
            $parameters    
        );
        
        if(!empty($dbUser))
        {
            return $this->buildEntity($dbUser);
        }
    }
    
    public function findByPseudo($pseudo, $idUser = null)
    {
        $query = 'SELECT * FROM users WHERE pseudo = :pseudo';
        $parameters = [
                ':pseudo' => $pseudo
            ];
        
        if (!is_null($idUser)) {
            $query .= ' AND id_user != :id';
            $parameters[':id'] = $idUser;
        }
        
        $dbUser = $this->db->fetchAssoc(
            $query, 
            $parameters    
        );
        
        if(!empty($dbUser))
        {
            return $this->buildEntity($dbUser);
        }
    }
    
    public function findByProfile()
    {
        $dbUser = $this->db->fetchAssoc(
            'SELECT pseudo, lastname, firstname, email, civility birthdate FROM users'
        );
    }
    
    public function save(User $user)
    {
        // les données à enregistrer en BDD
        $data = [
            'civility'  => $user->getCivility(),
            'lastname'  => $user->getLastname(),
            'firstname' => $user->getFirstname(),
            'bio'       => $user->getBio(),
            'pseudo'    => $user->getPseudo(), 
            'avatar'    => $user->getAvatar(), 
            'email'     => $user->getEmail(),
            'birthdate' => $user->getBirthdate(), 
            'password'  => $user->getPassword(),
        ];
        
        // si la catégorie a un id, on est en update
        // sinon en insert
        $where = !empty($user->getId_user())
        ? ['id_user' => $user->getId_user()]
        : null; 
        
        // appel à la méthode en Repository\Abstract pour enregistrer
        $this->persist($data, $where);
        
        // on set l'id quand on est en insert
        if (empty($user->getId_user()))
        {
            $user->setId_user($this->db->lastInsertId());
        }
    }
    
    private function buildEntity(array $data)
    {
        $user = new User(); 
        
        $user
            ->setId_user($data['id_user'])
            ->setCivility($data['civility'])
            ->setLastname($data['lastname'])
            ->setFirstname($data['firstname'])
            ->setPseudo($data['pseudo'])   
            ->setBio($data['bio'])
            ->setEmail($data['email'])
            ->setBirthdate($data['birthdate'])    
            ->setPassword($data['password'])
            ->setRole($data['role'])
            ->setAvatar($data['avatar'])
        ;
        return $user; 
    }
    
    public function delete(User $user)
    {
        $this->db->delete(
            'users', 
             ['id_user' => $user->getId_user()]
        );         
    }
}
