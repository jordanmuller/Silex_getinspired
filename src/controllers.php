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
//***************************** BACK OFFICE *********************************//

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
