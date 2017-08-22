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
                $errors['password'] = 'Le mot de passe doit faire entre 6 et 20 caractères'
                . ' et ne doit contenir que des lettres, des chiffres, ou les caractères _ et -'
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
        
        // Formulaire de connexion
        if(!empty($_POST))
        {
            $email = $_POST['email']; 
            
            $user = $this->app['user.repository']->findByEmail($email); 
            
            if(!is_null($user))
            {
                if($this->app['user.manager']->verifyPassword($_POST['password'], $user->getPassword()))
                {
                    // On crée la session
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
    
    public function profileAction($pseudo)
    {
        $user = $this->app['user.manager']->getUser();
              
        if($pseudo){
            $listes = $this->app['liste.repository']->findByUserPseudo($pseudo);
        }else{
             $listes = $this->app['liste.repository']->findByUserPseudo($user->getPseudo());
        }
        
        // Si l'utilisateur n'est pas connecté on ne peut pas voir son profil
        if(!$this->app['user.manager']->getUser())
        {
           return $this->redirectRoute('user_login');
        }
        return $this->render(
            'user/profil.html.twig',
            [
                'user' => $this->app['user.manager']->getUser(),
                'listes' => $listes
            ]
        ); 
    }  
    
    public function desinscriptionAction()
    {
        return $this->render(
            'user/desinscription.html.twig' 
        ); 
    }
    
    public function backProfile($pseudo)
    {
        if($pseudo){
            $listes = $this->app['liste.repository']->findByUserPseudo($pseudo);
        }else{
             $listes = $this->app['liste.repository']->findByUserPseudo($user->getPseudo());
        }
        
        // Si l'utilisateur n'est pas connecté on ne peut pas voir son profil
        if(!$this->app['user.manager']->getUser())
        {
           return $this->redirectRoute('user_login');
        }
        return $this->render(
            'user/profil.html.twig',
            [
                'user' => $this->app['user.manager']->getUser(),
                'listes' => $listes
            ]
        ); 
    }
    
    public function editAction($pseudo)
    { 
        // $this->app['user.manager']->edit(); 
        
        $user = $this->app['user.manager']->getUser();

        if (!empty($_POST)) 
        {
            $user
               ->setLastname($_POST['lastname'])
               ->setFirstname($_POST['firstname'])
               ->setPseudo($_POST['pseudo'])
               ->setBio($_POST['bio'])
               ->setEmail($_POST['email'])
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
            elseif (!empty($this->app['user.repository']->findByPseudo($_POST['pseudo'], $user->getId_user())))
            {
                $errors['pseudo'] = 'Le pseudo est déjà utilisé';
            }
            
            if(isset($_POST['bio']) && strlen($_POST['firstname'])>1000)
            {
                $errors['bio'] = 'La bio ne doit pas dépasser les 1000 caractères';
            }
            
            if(empty($_POST['email']))
            {
                $errors['email'] = 'L\'email est obligatoire'; 
            }
            elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            {
                 $errors['email'] = 'L\'email n\'est pas valide';
            }
            elseif(!empty($this->app['user.repository']->findByEmail($_POST['email'], $user->getId_user())))
            {
                $errors['email'] = 'L\'email est déjà utilisé';
            }
            
            // vérification si l'utilisateur a chargé une image
            if(!empty($_FILES['avatar']['name']))
            {
                // si ce n'est pas vide alors un fichier a bien été chargé via le formulaire.

                // on concatène la référence sur le titre afin de ne jamais avoir un fichier avec un nom déjà existant sur le serveur.
                $photo_bdd = uniqid() . '_' . $_FILES['avatar']['name'];

                // vérification de l'extension de l'image (extension acceptées: jpg jpeg, png, gif)
                $extension = strrchr($_FILES['avatar']['name'], '.'); // cette fonction prédéfinie permet de découper une chaine selon un caractère fourni en 2eme argument (ici le .). Attention, cette fonction découpera la chaine à partir de la dernière occurence du 2eme argument (donc nous renvoie la chaine comprise après le dernier point trouvé)
                // exemple: maphoto.jpg => on récupère .jpg
                // exemple: maphoto.photo.png => on récupère .png
                // var_dump($extension);

                // on transforme $extension afin que tous les caractères soient en minuscule
                $extension = strtolower($extension); // inverse strtoupper()
                // on enlève le .
                $extension = substr($extension, 1); // exemple: .jpg => jpg
                // les extensions acceptées
                $tab_extension_valide = array("jpg", "jpeg", "png", "gif");
                // nous pouvons donc vérifier si $extension fait partie des valeur autorisé dans $tab_extension_valide
                $verif_extension = in_array($extension, $tab_extension_valide); // in_array vérifie si une valeur fournie en 1er argument fait partie des valeurs contenues dans un tableau array fourni en 2eme argument

                if(!$verif_extension) {
                    $errors['avatar'] =  'Attention, la photo n\' a pas une extension valide (extension acceptées: jpg / jpeg / png / gif)';
                }
            }
            
            if(empty($errors))
            {
                if(!empty($_FILES['avatar']['name']))
                {
                    $photo_dossier = $this->app['img.path'] . $photo_bdd;
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $photo_dossier);
                    $user->setAvatar($photo_bdd);
                }
                
                //$user->setPassword($this->app['user.manager']->encodePassword($_POST['password'])); 
                //$this->app['user.repository']->save($user); 
                
                $this->app['user.repository']->save($user);
                $this->addFlashMessage('Vos modifications ont bien été enregistrées'); 
                return $this->redirectRoute('user_profile');
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
            }
        }
        return $this->render('user/edit_profile.html.twig', ['user' => $user]);
    } 
    
    public function passwordAction()
    {
        if (!empty($_POST)) 
        {
            $user = $this->app['user.manager']->getUser();
            
            $user
                ->setPassword($_POST['password']);

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
                $this->addFlashMessage('Vos modifications ont bien été enregistrées'); 
                return $this->redirectRoute('user_profile');
            }
            else
            {
                $message = '<strong>Le formulaire contient des erreurs</strong>'; 
                $message .='<br>' . implode('<br>', $errors); 
                $this->addFlashMessage($message, 'error'); 
            }
        }

        return $this->render(
            'user/password_profile.html.twig',
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
        
        $this->addFlashMessage('Votre compté a bien été supprimé'); 
        
        //return new \Symfony\Component\HttpFoundation\Response('');
        return $this->redirectRoute('homepage');
    }
}
