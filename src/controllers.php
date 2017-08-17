<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
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
    ->get('/box/{id}', 'box.controller:detailBoxAction')
    ->bind('box_detail')
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
->match('/utilisateur/profil', 'user.controller:profileAction')
->bind('user_profile')
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
->get('/utilisateur/suppression', 'user.controller:deleteAction')
->bind('user_profile_delete')
;

/************************* LISTE *************************************/

$app
    ->get('listes/affichage', 'liste.controller:listAction')
    ->bind('lists_list')
    ;

$app
    ->match('/listes/register', 'liste.controller:registerListeAction')
    ->bind('list_register')
;


//******************************  ADMIN  *************************************//
$app
->match('/admin/box/register', 'box.controller:registerBoxAction')
->bind('box_register')
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
