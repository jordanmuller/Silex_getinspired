<?php

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Box;

class BoxAdminController extends ControllerAbstract {
    
    public function registerBoxAction()
    {
        $box = new Box(); 
        $errors = []; 
        
        if(!empty($_POST))
        {
            $box
               ->setId($_POST['id_box'])
               ->setTitle($_POST['title'])        
               ->setContent($_POST['content'])
               ->setPrice($_POST['price'])
               
            ;
            
            if(empty($_POST['title']))
            {
                $errors['title'] = 'Le titre est obligatoire'; 
            }                      
            
            if(empty($_POST['content']))
            {
                $errors['content'] = 'Le contenu est obligatoire'; 
            }
            elseif(strlen ($_POST['content']) < 50)
            {
                $errors['content'] = 'Le contenu doit avoir un minimum de 50 caractères';
            }
            
            var_dump($errors);
            if(empty($errors))
            { 
                $this->app['box.repository']->save($box); 
                
                //return $this->redirectRoute('list_box');
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
            }
        }
        
        return $this->render(
            'admin/box/box_register.html.twig',
            [
                'box' => $box
            ]
        );
    } 
}
