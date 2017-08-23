<?php

namespace Controller;

use Entity\Liste;
use Entity\Movie;
use Entity\User;

class ListeController extends ControllerAbstract
{
    public function listAction() 
    {
          
        $listes = $this->app['liste.repository']->findAll();
        
        
        return $this->render(
            'liste/listes_list.html.twig',
            [
               'listes' => $listes,
          //     'movies' => $movies
            ]
        );
    }
    
    public function ficheListe($id) 
    {
         $liste = $this->app['liste.repository']->find($id);
         $movies = $this->app['movie.repository']->findByListeId($id);
         
         return $this->render(
            'liste/list_detail.html.twig',
            [
                'liste' => $liste,
                'movies' => $movies
            ]
        );
    }
    
    public function registerListeAction($id = null)
    {
        if(!$this->app['user.manager']->getUser())
        {
          $message = '<strong>Vous devez être connecté pour créer une liste</strong>'; 
          $this->addFlashMessage($message, 'error'); 
          return $this->redirectRoute('user_login');
        }
        
        //On récupère l'objet user de la session utilisateur en cours
        $user = $this->app['user.manager']->getUser(); 
        $movies = $this->app['movie.repository']->findAll();
        
        // Si l'id n'est pas null on est dans le cadre d'une modification (update)
        if(!is_null($id)){
            // on va chercher la liste en BDD
            $liste = $this->app['liste.repository']->find($id);
            $listeMovies = $this->app['movie.repository']->findByListeId($id);
            
            if(!$liste instanceof Liste){
                $this->app->abort(404);
            }
        }
        else{
            $liste = new Liste();
            $listeMovies = [];
            $liste->setUser($user);
        } 
        
        $errors = []; 
        $picture_bdd = '';
        
        if(!empty($_POST))
        {
            if(!empty($_POST['old_poster']))
            {
              $picture_bdd = $_POST['old_poster'];
            }
            
            if(empty($_FILES['picture']['name']) && empty($_POST['old_picture']))
            {
                $errors['picture'] = 'Attention, Vous devez ajouter une photo à votre liste';
            }
                      
            // vérification si l'utilisateur a chargé une image
            if(!empty($_FILES['picture']['name']))
            {
                // si ce n'est pas vide alors un fichier a bien été chargé via le formulaire
                
                
              // vérification de l'extension de l'image (jpg, jpeg, png, gif)
              $extension = strrchr($_FILES['picture']['name'], '.'); // cette fonction prédéfinie permet de découper une chaîne
              // selon le caractère fourni en 2ème argument ('.'). Attention, cette fonction découpera la chaîne à partir de
              //  la dernière occurance du 2ème argument.

              $extension = strtolower($extension); // on transforme $extension afin que tous les caractères soient en minuscule
              $extension = substr($extension, 1); // ex: .jpg -> jpg
              $tab_extension_valide = array('jpg', 'jpeg', 'png', 'gif'); // les extensions acceptées

              // on va maintenant vérifier l'extension
              $verif_extension = in_array($extension, $tab_extension_valide); // in_array vérifie si une valeur fournie en 1er argument
              // fait partie des valeurs contenues dans un tableau array fournie en 2ème argument
              
               if($verif_extension)
               {
                   
                 $picture_bdd = $_FILES['picture']['name'];
                 // si $verif_extension est égal à true
                 $poster_dossier = $this->app['photo_dir'] . $picture_bdd;

                 copy($_FILES['picture']['tmp_name'], $poster_dossier); // copy() permet de copier un fichier depuis un emplacement fourni en premier argument 
                 // vers un autre emplacement fourni en deuxième argument
                 
               }
               elseif(!$verif_extension)
               {
                 $errors['picture'] = 'Attention, l\'extension n\'est pas au bon format';                 
               }
            }
            
            $liste
               ->setTitle($_POST['title'])        
               ->setDescription($_POST['description'])
               ->setPicture($picture_bdd)         
            ;
             
            
             // On a besoin de la liste des films pour construire le select
            // dans le formulaire
            $movies = $this->app['movie.repository']->findAll();
            
            if(empty($_POST['title']))
            {
                $errors['title'] = 'Le titre est obligatoire'; 
            }                      
            
            if(empty($_POST['description']))
            {
                $errors['description'] = 'La description est obligatoire'; 
            }
            elseif(iconv_strlen ($_POST['description']) < 50)
            {
                $errors['content'] = 'La description doit avoir un minimum de 50 caractères';
            }
            
            
            
            
            if(empty($errors))
            { 
                $this->app['liste.repository']->save($liste); 
                $this->app['liste.repository']->saveMovies($liste, $_POST['movie']);
                if($this->app['user.manager']->getUser()->isAdmin())
                {
                    return $this->redirectRoute('admin_listes');
                }
                else if($this->app['user.manager']->getUser())
                {
                    
                    $pseudo = $this->app['user.manager']->getUser()->getPseudo();
                    
                    return $this->redirectRoute('user_profile', array('pseudo' => $pseudo));
                }
                
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
            }
        }
       
        return $this->render(
            'liste/liste_register.html.twig',
            [
                'liste' => $liste,
                'user' => $user,
                'movies' => $movies,
                'listeMovies' => $listeMovies
            ]
        );
    }
    
}
