<?php

// Les namespaces que l'on a créé


// Les namespaces natifs à Silex, que l'on rajoute selon l'application


use Controller\BoxController;
use Controller\MovieController;
use Controller\UserController;
use Repository\MovieRepository;
use Service\UserManager;
use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...
    // pour accéder au Usermanager dans les templates twig 
    $twig->addGlobal('user_manager', $app['user.manager']); 
    return $twig;
});

/* */
/* Ajout Doctrine DBAL ($app['db'])
 * nécessite l'utilisation par composer
 * composer require doctrine/dbal:~2.2 en ligne de commande dans le répertoire de l'application
 */
require_once 'parameters.php';
$app->register(
    new DoctrineServiceProvider(),
    $dbParameters
);

// cela renregistre $app['session'] prédéfini dans Silex
$app->register(new SessionServiceProvider());

//*************************CONTROLLERS***************************//

/////////////////////////////FRONT - OFFICE////////////////////////////////

$app['user.controller'] = function() use ($app)
{
    return new UserController($app); 
};

$app['movie.controller'] = function() use ($app)
{
    return new MovieController($app);
};

$app['box.controller'] = function() use ($app)
{
    return new BoxController($app);
};

$app['detail.box.controller'] = function() use ($app)
{
    return new \Controller\DetailBoxController($app);
};
////////////////////////////BACK - OFFICE//////////////////////////////////

$app['admin.box.controller'] = function() use ($app)
{
    return new Controller\Admin\BoxAdminController($app);
};

$app['admin.movie.controller'] = function() use($app) {
  return new \Controller\Admin\MovieAdminController($app);  
};

//*************************REPOSITORIES APPEL A LA BDD ***************************//

$app['user.repository'] = function() use ($app)
{
    return new \Repository\UserRepository($app); 
};

$app['box.repository'] = function() use ($app)
{
    return new \Repository\BoxRepository($app); 
};

$app['movie.repository'] = function() use($app)
{
    return new MovieRepository($app);
};

//*************************USER MANAGER***************************//
$app['user.manager'] = function() use ($app)
{
    return new UserManager($app['session']); 
};


return $app;
