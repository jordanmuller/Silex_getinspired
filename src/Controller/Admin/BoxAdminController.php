<?php

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Box;

class BoxAdminController extends ControllerAbstract {
    public function listBoxAction()
    {
        $boxes = $this->app['box.repository']->findAll();
        
        return $this->render(
            'admin/box/box_list_admin.html.twig',
            [
                'boxes' => $boxes
            ]
        );
    }
    
    
    public function registerBoxAction($id = null)
    {
        if(!is_null($id)){
            // on va chercher la box en BDD
            $box = $this->app['box.repository']->find($id);
            // On va chercher les films contenus dans la box en BDD
            $boxMovies = $this->app['movie.repository']->findByBoxId($id);
            
            if(!$box instanceof Box){
                $this->app->abort(404);
            }
        }
        else{
            // nouvelle catégorie
            $box = new Box();
            $boxMovies = [];
        } 
        
        $movies = $this->app['movie.repository']->findAll();
        $errors = []; 
        
        if(!empty($_POST))
        {
            $box
               ->setTitle($_POST['title'])        
               ->setContent($_POST['content'])
               ->setPrice($_POST['price'])
               ->setStock($_POST['stock'])
               
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
            
            if(empty($_POST['stock']))
            {
                $errors['stock'] = 'Le stock est obligatoire'; 
            }
            
            if(empty($errors))
            { 
                $this->app['box.repository']->save($box); 
                
                $this->app['box.repository']->saveMovies($box, $_POST['movie']);
                
                return $this->redirectRoute('box_list_admin');
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
                'box' => $box,
                'movies' => $movies,
                'boxMovies' => $boxMovies
            ]
        );
    }
    
    public function deleteAction($id) {
        $box = $this->app['box.repository']->find($id);
        
        if(!$box instanceof Box){
            $this->app->abort(404);
        }
        
        $this->app['box.repository']->delete($box);
                
        $this->addFlashMessage('La box est supprimée');            
        return $this->redirectRoute('box_list_admin');
        
    }
}
