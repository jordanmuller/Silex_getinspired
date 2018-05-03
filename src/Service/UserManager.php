<?php

namespace Service;

use Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;

class UserManager 
{   
    /**
     *
     * @var Session
     */   
    private $session;
    
    /**
     * 
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session; 
    }
    
    /**
     * 
     * @param string $plainPassword
     * @return bool
     */
    
    public function encodePassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT);
    }
    
    public function verifyPassword($plainPassword, $encodePassword)
    {
        return password_verify($plainPassword, $encodePassword); 
    }
    
    public function login(User $user)
    {
        $this->session->set('user', $user); 
    }
    
    public function logout()
    {
        $this->session->remove('user'); 
    }
    
    public function edit()
    {
        $this->session->get('user'); 
    }
 
    public function getUser()
    {
        return $this->session->get('user'); 
    }

    /**
     * 
     * @return string
     */
    
    public function getUserName()
    {
        if($this->session->has('user'))
        {
            return $this->session->get('user')->getFullName(); 
        }
        
        return '';
    }
    
    public function getUserId() 
    {
        if($this->session->has('user'))
        {
            return $this->session->get('user')->getId_user(); 
        }
        
        return '';
        
    }
    
    /**
     * 
     * @return bool
     */  
    public function isAdmin()
    {
        return $this->session->has('user') &&  $this->session->get('user')->isAdmin(); 
    }
}
