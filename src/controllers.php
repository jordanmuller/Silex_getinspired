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
    ->get('/film/{id}', 'movie.controller:ficheMovie')
    ->value('id', null) // value() donne une valeur par défaut au paramètre URL id
    ->bind('movie_detail')
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
//******************************  ADMIN  *************************************//
$app
->match('/admin/box/register', 'box.controller:registerBoxAction')
->bind('box_register')
;

//*****************************BACK OFFICE*********************************//

// crée un groupe de routes
$admin = $app['controllers_factory'];

$admin->before(function () use ($app)
{
    if(!$app['user.manager']->isAdmin())
    {
        $app->abort(403, 'Accès refusé'); 
    }
});

// Toutes les routes définies par $admin
// auront une URL commençant par /admin sans avoir à l'ajouter dans chaque route
// grâce à la fonction mount()
$app->mount('/admin', $admin);

/********************** MOVIES *********************************/

$admin
    ->get('/films/', 'admin.movie.controller:listAction')
    ->bind('admin_movies')
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
