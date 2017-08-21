<?php

namespace Entity;

class User {

    private $id_user; 
    private $civility; 
    private $lastname; 
    private $firstname; 
    private $pseudo; 
    private $email;
    private $birthdate; 
    private $password; 
    private $role; 
    
    function getId_user() {
        return $this->id_user;
    }

    function getCivility() {
        return $this->civility;
    }

    function getLastname() {
        return $this->lastname;
    }

    function getFirstname() {
        return $this->firstname;
    }

    function getPseudo() {
        return $this->pseudo;
    }

    function getEmail() {
        return $this->email;
    }

    function getBirthdate() {
        return $this->birthdate;
    }

    function getPassword() {
        return $this->password;
    }

    function getRole() {
        return $this->role;
    }

    function setId_user($id_user) {
        $this->id_user = $id_user;
        return $this;
    }

    function setCivility($civility) {
        $this->civility = $civility;
        return $this;
    }

    function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }

    function setFirstname($firstname) {
        $this->firstname = $firstname;
        return $this;
    }

    function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
        return $this;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    function setBirthdate($birthdate) {
        $this->birthdate = $birthdate;
        return $this;
    }

    function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    function setRole($role) {
        $this->role = $role;
        return $this;
    }

        
    
    public function isAdmin()
    {
        return $this->role == 'admin'; 
    }

}
