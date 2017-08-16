<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Movie;


class MovieAdminController extends ControllerAbstract 
{
    public function listAction() 
    {
        $movies = $this->app['movie.repository']->findAll();
        
        return $this->render(
                'admin/movie/admin_movies.html.twig',
                ['movies' => $movies]
        );
    }
    
    public function deleteAction($id)
    {
        $movie = $this->app['movie.repository']->find($id);
        
        // if(empty($category)), on peut écrire le !instanceof différemment 
        if(!$movie instanceof Movie)
        {
            $this->app->abort(404);
        }
        
        // La méthode delete va être définie dans CategoryRepository 
        $this->app['movie.repository']->delete($movie);
        
        $this->addFlashMessage('Le film a été supprimé');
        
        return $this->redirectRoute('admin_movies');
    }
    
    public function registerAction($id = null) 
    {
        if(!is_null($id)){
            // on va chercher le film en BDD
            $movie = $this->app['movie.repository']->find($id);
            
            if(!$movie instanceof Movie){
                $this->app->abort(404);
            }
        }
        else{
            // nouvel objet film
            $movie = new Movie();
        } 
        $errors = []; 
        
        if(!empty($_POST))
        {
            if(isset($_POST['old_poster']))
            {
              $poster_bdd = $_POST['old_poster'];
            }
            // vérification si l'utilisateur a chargé une image
            if(!empty($_FILES['poster']['name']))
            {
                // si ce n'est pas vide alors un fichier a bien été chargé via le formulaire
                
                
              // vérification de l'extension de l'image (jpg, jpeg, png, gif)
              $extension = strrchr($_FILES['poster']['name'], '.'); // cette fonction prédéfinie permet de découper une chaîne
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
                   
                 $poster_bdd = $_FILES['poster']['name'];
                 // si $verif_extension est égal à true
                 $poster_dossier = $this->app['photo_dir'] . $poster_bdd;

                 copy($_FILES['poster']['tmp_name'], $poster_dossier); // copy() permet de copier un fichier depuis un emplacement fourni en premier argument 
                 // vers un autre emplacement fourni en deuxième argument
                 
               }
               elseif(!$verif_extension)
               {
                 $errors['poster'] = 'Attention, l\'extension n\'est pas au bon format';                 
               }
            }
            
            $movie
                ->setTitle($_POST['title'])
                ->setProductionYear($_POST['production_year'])
                ->setNationality($_POST['nationality'])
                ->setSynopsis($_POST['synopsis'])
                ->setDirector($_POST['director'])
                ->setActors($_POST['actors'])
                ->setGender($_POST['gender'])
                ->setTrailer($_POST['trailer'])
                ->setPoster($poster_bdd)
                ->setPrice($_POST['price'])
            ;
            
            if(empty($_POST['title']))
            {
                $errors['title'] = 'Le titre est obligatoire'; 
            }                      
            
            if(empty($_POST['production_year']))
            {
                $errors['production_year'] = 'Veuillez indiquer l\'année de production du film'; 
            }
            
            if(empty($_POST['nationality']))
            {
                $errors['nationality'] = 'Veuillez indiquer la nationalité du film';
            }
            
            if(empty($_POST['synopsis']))
            {
                $errors['synopsis'] = 'Veuillez écrire le synopsis du film';
            }
            elseif(iconv_strlen($_POST['synopsis']) < 50)
            {
                $errors['synopsis'] = 'Le synopsis doit avoir un minimum de 50 caractères';
            }
            
            if(empty($_POST['director']))
            {
                $errors['director'] = 'Veuillez renseigner le nom du réalisateur'; 
            }
            
            if(empty($_POST['actors']))
            {
                $errors['actors'] = 'Veuillez renseigner le nom du réalisateur'; 
            }
            
            if(empty($_POST['gender']))
            {
                $errors['gender'] = 'Veuillez renseigner le nom des acteurs'; 
            }
            
            if(empty($_POST['trailer']))
            {
                $errors['trailer'] = 'Veuillez ajouter la bande-annonce du film'; 
            }
            
            if(is_null($poster_bdd))
            {
                $errors['poster'] = 'Veuillez ajouter l\'affiche du film'; 
            }
            
            if(empty($_POST['price']))
            {
                $errors['price'] = 'Veuillez ajouter un prix au film'; 
            }
            
            
            
            if(empty($errors))
            { 
                $this->app['movie.repository']->save($movie); 
                
                return $this->redirectRoute('admin_movies');
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
            }
        }
        
        return $this->render(
            'admin/movie/admin_movie_register.html.twig',
            [
                'movie' => $movie
            ]
        );
        
    }
}
