<?php

namespace Controller;

use Entity\User;

class UserController extends ControllerAbstract
{
    public function registerAction()
    {
        $user = new User(); 
        $errors = []; 
        
        $birthdate_year = $birthdate_month = $birthdate_day = '';
        
        if(!empty($_POST))
        {
            $birthdate_year = $_POST['birthdate_year'];
            $birthdate_month = $_POST['birthdate_month'];
            $birthdate_day = $_POST['birthdate_day'];
            
            $user
               ->setLastname($_POST['lastname'])
               ->setFirstname($_POST['firstname'])
               ->setPseudo($_POST['pseudo'])
               ->setEmail($_POST['email'])
               ->setBirthdate($_POST['birthdate_year'] . '-' . $_POST['birthdate_month'] . '-' . $_POST['birthdate_day'])
               ->setPassword($_POST['password'])
            ;
            
            if(isset($_POST['civility'])) {
                $user->setCivility($_POST['civility']);
            }

            if(empty($_POST['civility']))
            {
                $errors['civility'] = 'Veuillez cocher le champ civilité'; 
            }

            if(empty($_POST['lastname']))
            {
                $errors['lastname'] = 'Le nom est obligatoire'; 
            }
            elseif(strlen($_POST['lastname'])>100)
            {
                 $errors['lastname'] = 'Le nom ne doit pas dépasser les 100 caractères';
            }
            
            if(empty($_POST['firstname']))
            {
                $errors['firstname'] = 'Le prénom est obligatoire'; 
            }
            elseif(strlen($_POST['firstname'])>100)
            {
                 $errors['firstname'] = 'Le prénom ne doit pas dépasser les 100 caractères';
            }
            
            if(empty($_POST['pseudo']))
            {
                $errors['pseudo'] = 'Le pseudo est obligatoire'; 
            }
            elseif(strlen($_POST['pseudo'])>100)
            {
                 $errors['pseudo'] = 'Le pseudo ne doit pas dépasser les 100 caractères';
            }
            elseif (!empty($this->app['user.repository']->findByPseudo($_POST['pseudo'])))
            {
                $errors['pseudo'] = 'Le pseudo est déjà utilisé';
            }
            
            if(empty($_POST['email']))
            {
                $errors['email'] = 'L\'email est obligatoire'; 
            }
            elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            {
                 $errors['email'] = 'L\'email n\'est pas valide';
            }
            elseif (!empty($this->app['user.repository']->findByEmail($_POST['email'])))
            {
                $errors['email'] = 'L\'email est déjà utilisé';
            }
            
            if(empty($_POST['birthdate_day']) || empty($_POST['birthdate_month']) || empty($_POST['birthdate_year']))
            {
                $errors['birthdate'] = 'La date de naissance est obligatoire';
            }
            
            if(empty($_POST['password']))
            {
                $errors['password'] = 'Le mot de passe est obligatoire'; 
            }
            elseif(!preg_match('/^[a-zA-Z0-9_-]{6,20}$/', $_POST['password']))
            {
                $errors['password'] = 'Le mot de passe doit faire entre 6 et 20 carcatères'
                . ' et ne contient que des lettres, des chiffres, ou les carctères _ et -'
                ;
            }
            
            if(empty($_POST['password_confirm']))
            {
                $errors['password_confirm'] = 'La confirmation du mot de passe est obligatoire'; 
            }
            elseif ($_POST['password_confirm'] != $_POST['password']) 
            {
                $errors['password_confirm'] = 'La confirmation n\'est pas identique au mot de passe'; 
            }
            
            if(empty($_POST['cgu']))
            {
                $errors['cgu'] = 'Veuillez accepter les conditions générales de vente'; 
            }
            
            if(empty($errors))
            {
                $birthday = $_POST['birthdate_year'] . '-' . $_POST['birthdate_month'] . '-' . $_POST['birthdate_day'];
                $user->setPassword($this->app['user.manager']->encodePassword($_POST['password'])); 
                $this->app['user.repository']->save($user); 
                
                $this->addFlashMessage('Vous êtes bien inscrit!'); 
                return $this->redirectRoute('user_login');
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
            }
        }
        
        return $this->render(
            'user/register.html.twig',
            [
                'user' => $user,
                'birthdate_day' => $birthdate_day,
                'birthdate_month' => $birthdate_month,
                'birthdate_year' => $birthdate_year,
            ]
        );
    } 
    
    public function loginAction()
    {
        $email = ''; 
        
        if(!empty($_POST))
        {
            $email = $_POST['email']; 
            
            $user = $this->app['user.repository']->findByEmail($email); 
            
            if(!is_null($user))
            {
                if($this->app['user.manager']->verifyPassword($_POST['password'], $user->getPassword()))
                {
                    $this->app['user.manager']->login($user); 
                    
                    return $this->redirectRoute('homepage');
                }
            }
            
            $this->addFlashMessage('Identification incorrecte', 'error'); 
        }
        
        return $this->render(
            'user/login.html.twig', 
            ['email' => $email]
        ); 
    }
    
    public function logoutAction()
    {
        $this->app['user.manager']->logout(); 
        
        return $this->redirectRoute('homepage');
    }
    
    public function profileAction()
    {
        //$this->app['user.controller']; 
        
        return $this->render(
            'user/profil.html.twig',
            [
                'user' => $this->app['user.manager']->getUser()
            ]
        ); 
    }  
    
    public function deleteAction()
    {
        $user = $this->app['user.manager']->getUser(); 
        
        $this->app['user.repository']->delete($user);
        $this->app['user.manager']->logout();
        
        $this->addFlashMessage('Votre compté a bien été supprimée'); 
        
        //return new \Symfony\Component\HttpFoundation\Response('');
        return $this->redirectRoute('homepage');
    }
}
