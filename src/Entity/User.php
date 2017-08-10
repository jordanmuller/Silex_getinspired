<?php

namespace Entity;

class User {

    private $id_user; 
    private $civility; 
    private $lastname; 
    private $firstname; 
    private $pseudo; 
    private $email;
    private $birthdate_day; 
    private $birthdate_month; 
    private $birthdate_year; 
    private $password; 
    
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

    function getBirthdate_day() {
        return $this->birthdate_day;
    }

    function getBirthdate_month() {
        return $this->birthdate_month;
    }

    function getBirthdate_year() {
        return $this->birthdate_year;
    }

    function getPassword() {
        return $this->password;
    }

    function setId_user($id_user) {
        $this->id_user = $id_user;
    }

    function setCivility($civility) {
        $this->civility = $civility;
    }

    function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setBirthdate_day($birthdate_day) {
        $this->birthdate_day = $birthdate_day;
    }

    function setBirthdate_month($birthdate_month) {
        $this->birthdate_month = $birthdate_month;
    }

    function setBirthdate_year($birthdate_year) {
        $this->birthdate_year = $birthdate_year;
    }

    function setPassword($password) {
        $this->password = $password;
    }
    
    public function isAdmin()
    {
        return $this->role == 'admin'; 
    }

}
