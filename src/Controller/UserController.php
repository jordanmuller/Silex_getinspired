<?php

namespace Controller;

use Entity\User;

class UserController extends ControllerAbstract
{
    public function registerAction()
    {
        $user = new User(); 
        $errors = []; 
        
        if(!empty($_POST))
        {
            $user
               ->setId_user($_POST['id_user'])
               ->setCivility($_POST['civility'])        
               ->setLastname($_POST['lastname'])
               ->setFirstname($_POST['firstname'])
               ->setPseudo($_POST['$pseudo'])
               ->setEmail($_POST['email'])
               ->setBirthdate_day($_POST['$birthdate_day'])
               ->setBirthdate_month($_POST['$birthdate_month'])
               ->setBirthdate_year($_POST['birthdate_year'])
               ->setPassword($_POST['$password'])
            ;
            
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
            
            if(empty($errors))
            {
                $user->setPassword($this->app['user.manager']->encodePassword($_POST['password'])); 
                $this->app['user.repository']->save($user); 
                
                return $this->redirectRoute('homepage');
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
                'user' => $user
            ]
        );
    } 
}
