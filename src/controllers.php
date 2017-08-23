<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    $movies = $app['movie.repository']->findByNotes();
    $reviews = $app['review.repository']->findLastComments();
    
    return $app['twig']->render('index.html.twig', array('movies' => $movies, 'reviews' => $reviews));
})
->bind('homepage')
;

//****************************** FRONT OFFICE ********************************//


/***************************** MOVIES *************************************/
$app
    ->get('/films/affichage', 'movie.controller:listAction')
    ->bind('movies_list')
;
$app
    ->match('/film/{id}', 'movie.controller:ficheMovie')
    ->bind('movie_detail')
;

/***************************** BOX *************************************/
$app
    ->get('/box/affichage', 'box.controller:listBoxAction')
    ->bind('box_list')
;

$app
    ->match('/box/{id}', 'box.controller:detailBoxAction')
    ->value('id', null) // value() donne une valeur par défaut au paramètre URL id
    ->bind('box_detail')
;

/************************** BASKET ************************************/
$app
->match('/utilisateur/panier', 'basket.controller:basketAction')
->bind('basket')
;

$app
->match('/utilisateur/panier/supprimer/{id_box}', 'basket.controller:deleteBasket')
->bind('basket_delete')
;

$app
->match('utilisateur/panier/vider', 'basket.controller:emptyBasket')
->bind('basket_empty')
;

$app
->match('utilisateur/panier/payer', 'basket.controller:payBasket')
->bind('basket_pay')
;

/************************** USER ************************************/

$app
->match('/utilisateur/inscription', 'user.controller:registerAction')
->bind('user_register')
;

$app
->match('/utilisateur/connexion', 'user.controller:loginAction')
->bind('user_login')
;

$app
->match('/utilisateur/deconnexion', 'user.controller:logoutAction')
->bind('user_logout')
;

$app
->match('/utilisateur/profil/{pseudo}/', 'user.controller:profileAction')
->bind('user_profile')
;

$app
->match('/utilisateur/profil/{pseudo}', 'user.controller:backProfile')
->bind('back_profile')
;

$app
->match('/utilisateur/edit_profil/{pseudo}', 'user.controller:editAction')
->bind('user_profile_edit')
;

$app
->match('/utilisateur/password_profil/{pseudo}', 'user.controller:passwordAction')
->bind('user_profile_password')
;

$app
->match('/utilisateur/password/desinscription', 'user.controller:desinscriptionAction')
->bind('user_profile_desinscription')
;

$app
->get('/utilisateur/suppression', 'user.controller:deleteAction')
->bind('user_profile_delete')
;

/************************* LISTE *************************************/

$app
    ->get('listes/affichage', 'liste.controller:listAction')
    ->bind('lists_list')
    ;

$app
    ->get('liste/affichage/{id}', 'liste.controller:ficheListe')
    ->bind('list_detail')
;

$app
    ->match('/listes/register/', 'liste.controller:registerListeAction')
    ->bind('list_register')
;

//*****************************BACK OFFICE*********************************//

// crée un groupe de routes
$admin = $app['controllers_factory'];

// toutes les routes définies par $admin
// auront une URL commençant par /admin sans avoir à l'ajouter dans chaque route
$app->mount('/admin', $admin);

$admin->before(function () use ($app)
{
    if(!$app['user.manager']->isAdmin())
    {
        $app->abort(403, 'Accès refusé'); 
    }
});

//*************************  ADMIN  *****************************//
/******  BOX  *******/
$admin
->get('/box/list', 'admin.box.controller:listBoxAction')
->bind('box_list_admin')
;

$admin
->match('/box/register/{id}', 'admin.box.controller:registerBoxAction')
->value('id', null)
->bind('box_register')
;

$admin->get('/box/suppression/{id}', 'admin.box.controller:deleteAction')
->assert('id', '\d+') // id doit être un nombre
->bind('box_delete_admin')
;

/********** REQUETE AJAX REVIEWS **************/
$app
    // on appelle la méthode addSignaleAjax dans review.controller
    ->post('/reviews/addSignale', 'review.controller:addSignaleAjax')
    ->bind('add_signale_ajax')
;

$app
    // on appelle la méthode addSignaleAjax dans review.controller
    ->post('/reviews/removeSignale', 'review.controller:removeSignaleAjax')
    ->bind('remove_signale_ajax')
;

$app
    // on appelle la méthode addSignaleAjax dans review.controller
    ->post('/reviews/deleteComment', 'review.controller:deleteCommentAjax')
    ->bind('delete_comment_ajax')
;

/********************** MOVIES *********************************/

$admin
    ->get('/films/', 'admin.movie.controller:listAction')
    ->bind('admin_movies')
;

$admin
    ->match('/film/enregistrement/{id}', 'admin.movie.controller:registerAction')
    ->value('id', null)
    ->bind('admin_movie_register')
;

$admin
    ->get('/film/suppression/{id}', 'admin.movie.controller:deleteAction')
    ->assert('id', '\d+')
    ->bind('admin_movie_delete')
;

/**************************** LISTES  *****************************/
$admin 
    ->match('/listes/', 'admin.list.controller:listListeAction')
    ->bind('admin_listes')
;

$admin
    ->match('/listes/suppression/{id}', 'admin.list.controller:deleteAction')
    ->assert('id', '\d+') // id doit être un nombre
    ->bind('list_delete_admin')
;

$admin
    ->match('/listes/modification/{id}', 'liste.controller:registerListeAction')
    ->assert('id', '\d+')
    // On précise un bind et une URL différents de ceux de "Créer une liste" 
    ->bind('list_modif')
;

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
